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
            
            // Ambil data user dari session
            $userNama = session()->get('nama');
            $userAlamat = session()->get('alamat');
            $userId = session()->get('user_id'); // Assuming user id is stored in session as 'user_id'
            
            // Validasi input sederhana
            $productId = $this->request->getPost('product');
            $quantity = $this->request->getPost('quantity');
            $notes = $this->request->getPost('notes');
            
            // Cek input wajib
            if (!$productId || !$quantity) {
                return redirect()->back()->withInput()->with('error', 'Mohon lengkapi produk dan jumlah');
            }
            
            // Ambil data produk
            $produk = $this->produkModel->find($productId);
            if (!$produk) {
                return redirect()->back()->withInput()->with('error', 'Produk tidak ditemukan');
            }
            
            // Hitung total harga
            $totalHarga = $produk['harga'] * $quantity;
            
            // Siapkan data untuk disimpan
            $orderData = [
                'user' => $userId,
                'produk' => $productId,
                'jumlah' => $quantity,
                'total_harga' => $totalHarga,
                'catatan' => $notes ? $notes : null,
            ];
            
            // Simpan ke database menggunakan method simpanPemesanan
            if ($this->pemesananModel->simpanPemesanan($orderData)) {
                return redirect()->to('/pemesanan')->with('success', 'Pesanan berhasil dikirim!');
            } else {
                $errors = $this->pemesananModel->errors();
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pesanan: ' . implode(', ', $errors));
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error saat submit order: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}