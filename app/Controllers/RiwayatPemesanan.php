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
        
        if ($pesanan['status'] !== 'diproses') {
            return $this->response->setJSON(['error' => 'Pesanan tidak dapat dibatalkan']);
        }
        
        if ($this->pemesananModel->updateStatus($id, 'dibatalkan')) {
            $produkModel = new \App\Models\ProdukModel();
            $produk = $produkModel->find($pesanan['produk']);
            if ($produk) {
                $produkModel->update($pesanan['produk'], [
                    'stok' => $produk['stok'] + $pesanan['jumlah']
                ]);
            }
            
            return $this->response->setJSON(['success' => true, 'message' => 'Pesanan berhasil dibatalkan']);
        }
        
        return $this->response->setJSON(['error' => 'Gagal membatalkan pesanan']);
    }
    
    private function getUserId()
    {
        $userId = session()->get('user_id') ?? session()->get('id') ?? session()->get('userId');
        
        if (!$userId && session()->get('username')) {
            $db = \Config\Database::connect();
            $user = $db->table('users')->where('username', session()->get('username'))->get()->getRowArray();
            $userId = $user ? $user['id'] : null;
        }
        
        if (!$userId && session()->get('nama')) {
            $db = \Config\Database::connect();
            $user = $db->table('users')->where('nama', session()->get('nama'))->get()->getRowArray();
            $userId = $user ? $user['id'] : null;
        }
        
        return $userId;
    }
}