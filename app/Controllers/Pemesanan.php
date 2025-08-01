<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProdukModel;
use App\Models\PemesananModel;

class Pemesanan extends Controller
{
    protected $produkModel;
    protected $pemesananModel;
    
    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        // Cek login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk melakukan pemesanan');
        }
        
        // Ambil parameter produk dari URL jika ada
        $selectedProductId = $this->request->getVar('produk');
        
        // Ambil semua data produk dari database
        $produkData = $this->produkModel->findAll();
        
        // Kelompokkan produk berdasarkan kategori
        $produkByKategori = [];
        foreach ($produkData as $produk) {
            $kategori = $produk['nama_kategori'];
            if (!isset($produkByKategori[$kategori])) {
                $produkByKategori[$kategori] = [];
            }
            $produkByKategori[$kategori][] = $produk;
        }
        
        // Jika ada produk yang dipilih, ambil detail produknya
        $selectedProduct = null;
        if ($selectedProductId) {
            $selectedProduct = $this->produkModel->find($selectedProductId);
        }
        
        $data = [
            'title' => 'Pemesanan Produk',
            'produk' => $produkData,
            'produkByKategori' => $produkByKategori,
            'selectedProductId' => $selectedProductId,
            'selectedProduct' => $selectedProduct,
            'userNama' => session()->get('nama'),
            'userAlamat' => session()->get('alamat'),
        ];
        
        return view('layouts/main', [
            'content' => view('pages/pemesanan', $data)
        ]);
    }
    
    public function submitOrder()
    {
        try {
            // Cek login
            if (!session()->get('isLoggedIn')) {
                return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
            }
            
            // Ambil data dari form
            $productId = $this->request->getPost('product');
            $quantity = $this->request->getPost('quantity');
            $alamat = $this->request->getPost('alamat');
            $nomorTelepon = $this->request->getPost('nomor_telepon');
            
            // Cari user ID dengan berbagai cara
            $userId = session()->get('user_id') ?? session()->get('id') ?? session()->get('userId');
            
            // Jika tidak ada, coba cari dari username
            if (!$userId && session()->get('username')) {
                $db = \Config\Database::connect();
                $user = $db->table('users')->where('username', session()->get('username'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
            }
            
            // Jika masih tidak ada, coba dari nama
            if (!$userId && session()->get('nama')) {
                $db = \Config\Database::connect();
                $user = $db->table('users')->where('nama', session()->get('nama'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
            }
            
            // Fallback untuk testing (hapus setelah production)
            if (!$userId) {
                // Ambil user pertama dari database sebagai fallback
                $db = \Config\Database::connect();
                $user = $db->table('users')->orderBy('id', 'ASC')->get()->getRowArray();
                $userId = $user ? $user['id'] : 1;
                log_message('warning', 'Using fallback user ID: ' . $userId);
            }
            
            // Validasi input wajib
            if (!$productId || !$quantity || !$alamat || !$nomorTelepon) {
                return redirect()->back()->withInput()->with('error', 'Mohon lengkapi semua field yang wajib diisi');
            }
            
            // Ambil data produk
            $produk = $this->produkModel->find($productId);
            if (!$produk) {
                return redirect()->back()->withInput()->with('error', 'Produk tidak ditemukan');
            }
            
            // Cek stok
            if ($quantity > $produk['stok']) {
                return redirect()->back()->withInput()->with('error', 'Jumlah melebihi stok yang tersedia');
            }
            
            // Hitung total harga
            $totalHarga = $produk['harga'] * $quantity;
            
            // Siapkan data untuk disimpan
            $orderData = [
                'user' => $userId,
                'produk' => $productId,
                'jumlah' => $quantity,
                'total_harga' => $totalHarga,
            ];
            
            // Log data yang akan disimpan
            log_message('info', 'Order data: ' . json_encode($orderData));
            
            // Simpan ke database
            if ($this->pemesananModel->simpanPemesanan($orderData)) {
                // Update stok produk
                $this->produkModel->update($productId, [
                    'stok' => $produk['stok'] - $quantity
                ]);
                
                return redirect()->to('/riwayat-pemesanan')->with('success', 'Pesanan berhasil dikirim!');
            } else {
                $errors = $this->pemesananModel->errors();
                log_message('error', 'Validation errors: ' . json_encode($errors));
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pesanan: ' . implode(', ', $errors));
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error saat submit order: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    
    // Method untuk debugging session
    public function debugSession()
    {
        $sessionData = session()->get();
        echo "<h3>Session Data:</h3>";
        echo "<pre>";
        print_r($sessionData);
        echo "</pre>";
        
        echo "<h3>Specific Checks:</h3>";
        echo "isLoggedIn: " . (session()->get('isLoggedIn') ? 'true' : 'false') . "<br>";
        echo "user_id: " . (session()->get('user_id') ?: 'null') . "<br>";
        echo "id: " . (session()->get('id') ?: 'null') . "<br>";
        echo "userId: " . (session()->get('userId') ?: 'null') . "<br>";
        echo "username: " . (session()->get('username') ?: 'null') . "<br>";
        echo "nama: " . (session()->get('nama') ?: 'null') . "<br>";
    }
}