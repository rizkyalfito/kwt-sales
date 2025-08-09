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

        // Cari user ID berdasarkan data session yang tersedia (sama seperti di Pemesanan)
        $userId = null;
        $db = \Config\Database::connect();
        
        // Coba cari berdasarkan nama dan email (kombinasi lebih unik)
        if (session()->get('nama') && session()->get('email')) {
            $user = $db->table('users')
                ->where('nama', session()->get('nama'))
                ->where('email', session()->get('email'))
                ->get()->getRowArray();
            $userId = $user ? $user['id'] : null;
            log_message('info', 'Payment - Found user by nama+email: ' . $userId);
        }
        
        // Jika tidak ketemu, coba dari email saja
        if (!$userId && session()->get('email')) {
            $user = $db->table('users')->where('email', session()->get('email'))->get()->getRowArray();
            $userId = $user ? $user['id'] : null;
            log_message('info', 'Payment - Found user by email: ' . $userId);
        }
        
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

        // Cek apakah pesanan menggunakan metode transfer
        if ($pesanan['metode_pembayaran'] !== 'transfer') {
            return redirect()->to('/riwayat-pemesanan')->with('error', 'Pesanan ini tidak menggunakan metode transfer');
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
            
            // Cari user ID berdasarkan data session yang tersedia
            $userId = null;
            $db = \Config\Database::connect();
            
            // Coba cari berdasarkan nama dan email (kombinasi lebih unik)
            if (session()->get('nama') && session()->get('email')) {
                $user = $db->table('users')
                    ->where('nama', session()->get('nama'))
                    ->where('email', session()->get('email'))
                    ->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
            }
            
            // Jika tidak ketemu, coba dari email saja
            if (!$userId && session()->get('email')) {
                $user = $db->table('users')->where('email', session()->get('email'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
            }

            if (!$orderId || !$userId) {
                return redirect()->back()->with('error', 'Data tidak lengkap');
            }

            $pesanan = $this->pemesananModel->getPemesananByIdAndUser($orderId, $userId);
            if (!$pesanan) {
                return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
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

            // Simpan file
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            // Update data pesanan
            $updateData = [
                'bukti_pembayaran' => 'uploads/payments/' . $newName,
                'status_pembayaran' => 'terkonfirmasi', // Langsung konfirmasi atau bisa 'pending' untuk review admin
            ];

            if ($this->pemesananModel->update($orderId, $updateData)) {
                log_message('info', "Payment uploaded successfully - Order ID: $orderId");
                return redirect()->to('/riwayat-pemesanan')->with('success', 'Bukti pembayaran berhasil diupload dan dikonfirmasi.');
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan bukti pembayaran');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error saat submit payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}