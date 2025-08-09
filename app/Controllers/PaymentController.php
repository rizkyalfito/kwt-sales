<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PemesananModel;

class PaymentController extends Controller
{
    protected $pemesananModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
    }

    public function confirmPayment($orderId = null)
    {
        // Cek login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        if (!$orderId) {
            return redirect()->to('/riwayat-pemesanan')->with('error', 'ID pesanan tidak valid');
        }

        // Cari user ID berdasarkan data session yang tersedia
        $userId = $this->getUserId();
        
        if (!$userId) {
            log_message('error', 'Payment - Cannot find user ID from session');
            return redirect()->to('/riwayat-pemesanan')->with('error', 'Terjadi kesalahan identifikasi user');
        }

        // Debug log
        log_message('info', "Payment confirmation - Order ID: $orderId, User ID: $userId");

        $pesanan = $this->pemesananModel->getDetailPemesanan($orderId, $userId);
        
        if (!$pesanan) {
            log_message('error', "Pesanan tidak ditemukan - Order ID: $orderId, User ID: $userId");
            return redirect()->to('/riwayat-pemesanan')->with('error', 'Pesanan tidak ditemukan');
        }

        // Cek apakah pesanan menggunakan metode transfer dan masih pending payment
        if ($pesanan['metode_pembayaran'] !== 'transfer') {
            return redirect()->to('/riwayat-pemesanan')->with('error', 'Pesanan ini tidak menggunakan metode transfer');
        }

        if (!in_array($pesanan['status'], ['pending_payment', 'payment_rejected'])) {
            $statusLabel = $this->getStatusLabel($pesanan['status']);
            return redirect()->to('/riwayat-pemesanan')->with('error', "Pesanan sudah dalam status: $statusLabel");
        }

        $data = [
            'title' => 'Konfirmasi Pembayaran',
            'pesanan' => $pesanan
        ];

        return view('layouts/main', [
            'content' => view('pages/payment-confirmation', $data)
        ]);
    }

    public function submitPayment()
    {
        try {
            // Cek login
            if (!session()->get('isLoggedIn')) {
                return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
            }

            $orderId = $this->request->getPost('order_id');
            $catatan = $this->request->getPost('catatan');
            
            // Cari user ID berdasarkan data session yang tersedia
            $userId = $this->getUserId();

            if (!$orderId || !$userId) {
                return redirect()->back()->with('error', 'Data tidak lengkap');
            }

            $pesanan = $this->pemesananModel->getPemesananByIdAndUser($orderId, $userId);
            if (!$pesanan) {
                return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
            }

            // Validasi status pesanan
            if (!in_array($pesanan['status'], ['pending_payment', 'payment_rejected'])) {
                return redirect()->back()->with('error', 'Pesanan tidak dapat diupdate bukti pembayaran pada status ini');
            }

            $file = $this->request->getFile('bukti_pembayaran');
            if (!$file || !$file->isValid()) {
                return redirect()->back()->with('error', 'Bukti pembayaran wajib diupload');
            }

            // Validasi file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau PDF.');
            }

            if ($file->getSize() > 2 * 1024 * 1024) { // 2MB
                return redirect()->back()->with('error', 'Ukuran file maksimal 2MB');
            }

            // Pastikan folder upload ada
            $uploadPath = WRITEPATH . 'uploads/payments/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Hapus file lama jika ada
            if (!empty($pesanan['bukti_pembayaran'])) {
                $oldFilePath = WRITEPATH . $pesanan['bukti_pembayaran'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Simpan file baru
            $newName = $file->getRandomName();
            if (!$file->move($uploadPath, $newName)) {
                return redirect()->back()->with('error', 'Gagal mengupload file');
            }

            // Update data pesanan dengan status payment_confirmed (auto-confirm)
            $updateData = [
                'bukti_pembayaran' => 'uploads/payments/' . $newName,
                'status' => 'payment_confirmed',
                'status_pembayaran' => 'terkonfirmasi',
            ];

            // Tambahkan catatan jika ada
            if (!empty($catatan)) {
                $updateData['catatan'] = $catatan;
            }

            if ($this->pemesananModel->update($orderId, $updateData)) {
                log_message('info', "Payment uploaded and confirmed successfully - Order ID: $orderId");
                return redirect()->to('/riwayat-pemesanan')->with('success', 'Bukti pembayaran berhasil diupload. Pesanan Anda sedang diproses.');
            } else {
                // Hapus file yang sudah diupload jika update database gagal
                $uploadedFile = $uploadPath . $newName;
                if (file_exists($uploadedFile)) {
                    unlink($uploadedFile);
                }
                return redirect()->back()->with('error', 'Gagal menyimpan bukti pembayaran');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error saat submit payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // Method untuk admin menolak pembayaran
    public function rejectPayment($orderId)
    {
        if (!session()->get('isAdmin')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $reason = $this->request->getPost('reason') ?? 'Bukti pembayaran tidak valid';
        
        $updateData = [
            'status' => 'payment_rejected',
            'status_pembayaran' => 'ditolak',
            'catatan_admin' => $reason
        ];

        if ($this->pemesananModel->update($orderId, $updateData)) {
            log_message('info', "Payment rejected for order ID: $orderId. Reason: $reason");
            return $this->response->setJSON(['success' => true, 'message' => 'Pembayaran ditolak']);
        }

        return $this->response->setJSON(['error' => 'Gagal menolak pembayaran']);
    }

    // Method untuk admin mengkonfirmasi pembayaran manual
    public function approvePayment($orderId)
    {
        if (!session()->get('isAdmin')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $updateData = [
            'status' => 'processing',
            'status_pembayaran' => 'terkonfirmasi'
        ];

        if ($this->pemesananModel->update($orderId, $updateData)) {
            log_message('info', "Payment approved manually for order ID: $orderId");
            return $this->response->setJSON(['success' => true, 'message' => 'Pembayaran dikonfirmasi']);
        }

        return $this->response->setJSON(['error' => 'Gagal mengkonfirmasi pembayaran']);
    }

    private function getUserId()
    {
        // Try multiple session keys for user ID
        $userId = session()->get('user_id') ?? session()->get('id') ?? session()->get('userId');
        
        if (!$userId) {
            // Try finding user by session data
            $db = \Config\Database::connect();
            
            // Try by nama and email combination (most unique)
            if (session()->get('nama') && session()->get('email')) {
                $user = $db->table('users')
                    ->where('nama', session()->get('nama'))
                    ->where('email', session()->get('email'))
                    ->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
                log_message('info', 'Payment - Found user by nama+email: ' . $userId);
            }
            
            // If not found, try by email only
            if (!$userId && session()->get('email')) {
                $user = $db->table('users')->where('email', session()->get('email'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
                log_message('info', 'Payment - Found user by email: ' . $userId);
            }
            
            // If still not found, try by username
            if (!$userId && session()->get('username')) {
                $user = $db->table('users')->where('username', session()->get('username'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
                log_message('info', 'Payment - Found user by username: ' . $userId);
            }
        }
        
        return $userId;
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending_payment' => 'Menunggu Pembayaran',
            'payment_confirmed' => 'Pembayaran Dikonfirmasi',
            'payment_rejected' => 'Pembayaran Ditolak',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return $labels[$status] ?? ucfirst($status);
    }
}