<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PemesananModel;

class RiwayatPemesanan extends Controller
{
    protected $pemesananModel;
    
    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $userId = $this->getUserId();
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid, silakan login ulang');
        }
        
        $riwayatPemesanan = $this->pemesananModel->getRiwayatPemesananByUser($userId);
        
        $statistik = $this->pemesananModel->getStatistikPemesanan($userId);
        
        $data = [
            'title' => 'Riwayat Pemesanan',
            'riwayatPemesanan' => $riwayatPemesanan,
            'statistik' => $statistik,
            'userNama' => session()->get('nama')
        ];
        
        return view('layouts/main', [
            'content' => view('pages/riwayat-pemesanan', $data)
        ]);
    }
    
    public function detail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        $userId = $this->getUserId();
        
        $detail = $this->pemesananModel->getDetailPemesanan($id, $userId);
        
        if (!$detail) {
            return $this->response->setJSON(['error' => 'Pesanan tidak ditemukan']);
        }
        
        return $this->response->setJSON(['success' => true, 'data' => $detail]);
    }
    
    public function batalkan($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        $userId = $this->getUserId();
        
        $pesanan = $this->pemesananModel->getPemesananByIdAndUser($id, $userId);
        
        if (!$pesanan) {
            return $this->response->setJSON(['error' => 'Pesanan tidak ditemukan']);
        }
        
        // Update allowed cancellation statuses to include new statuses
        if (!in_array($pesanan['status'], ['processing', 'pending_payment', 'payment_confirmed'])) {
            return $this->response->setJSON(['error' => 'Pesanan tidak dapat dibatalkan pada status ini']);
        }
        
        // Get cancellation reason from POST data
        $input = $this->request->getJSON(true);
        $alasanPembatalan = isset($input['alasan_pembatalan']) ? trim($input['alasan_pembatalan']) : '';
        
        // Validate cancellation reason
        if (empty($alasanPembatalan)) {
            // Cancellation reason is required to proceed with cancellation
            return $this->response->setJSON(['error' => 'Alasan pembatalan harus diisi agar pesanan dapat dibatalkan']);
        }
        
        // Update status and save cancellation reason
        $updateData = [
            'status' => 'cancelled',
            'alasan_pembatalan' => $alasanPembatalan
        ];
        
        if ($this->pemesananModel->update($id, $updateData)) {
            // Restore product stock when order is cancelled
            $produkModel = new \App\Models\ProdukModel();
            $produk = $produkModel->find($pesanan['produk']);
            if ($produk) {
                $produkModel->update($pesanan['produk'], [
                    'stok' => $produk['stok'] + $pesanan['jumlah']
                ]);
            }
            
            log_message('info', "Order cancelled successfully - Order ID: $id, User ID: $userId, Reason: $alasanPembatalan");
            return $this->response->setJSON(['success' => true, 'message' => 'Pesanan berhasil dibatalkan']);
        }
        
        return $this->response->setJSON(['error' => 'Gagal membatalkan pesanan']);
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
                log_message('info', 'RiwayatPemesanan - Found user by nama+email: ' . $userId);
            }
            
            // If not found, try by email only
            if (!$userId && session()->get('email')) {
                $user = $db->table('users')->where('email', session()->get('email'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
                log_message('info', 'RiwayatPemesanan - Found user by email: ' . $userId);
            }
            
            // If still not found, try by username
            if (!$userId && session()->get('username')) {
                $user = $db->table('users')->where('username', session()->get('username'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
                log_message('info', 'RiwayatPemesanan - Found user by username: ' . $userId);
            }
        }
        
        return $userId;
    }
}