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
            $metodePembayaran = $this->request->getPost('metode_pembayaran');
            
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
                log_message('info', 'Found user by nama+email: ' . $userId);
            }
            
            // Jika tidak ketemu, coba dari email saja
            if (!$userId && session()->get('email')) {
                $user = $db->table('users')->where('email', session()->get('email'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
                log_message('info', 'Found user by email: ' . $userId);
            }
            
            // Jika masih tidak ketemu, coba dari nama saja (tidak disarankan karena bisa duplikat)
            if (!$userId && session()->get('nama')) {
                $user = $db->table('users')->where('nama', session()->get('nama'))->get()->getRowArray();
                $userId = $user ? $user['id'] : null;
                log_message('warning', 'Found user by nama only (not recommended): ' . $userId);
            }
            
            // Jika benar-benar tidak ketemu
            if (!$userId) {
                log_message('error', 'Cannot find user ID from session data: ' . json_encode(session()->get()));
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan identifikasi user. Silakan login ulang.');
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
                'metode_pembayaran' => $metodePembayaran,
                'status_pembayaran' => $metodePembayaran === 'cod' ? 'terkonfirmasi' : 'pending',
            ];
            
            // Log data yang akan disimpan
            log_message('info', 'Order data: ' . json_encode($orderData));
            
            // Simpan ke database menggunakan method custom
            $insertResult = $this->pemesananModel->simpanPemesanan($orderData);
            
            if ($insertResult) {
                // Update stok produk
                $this->produkModel->update($productId, [
                    'stok' => $produk['stok'] - $quantity
                ]);
                
                // Dapatkan ID pesanan yang baru saja dibuat
                $orderId = $this->pemesananModel->getInsertID();
                
                log_message('info', 'Order created successfully with ID: ' . $orderId . ', Payment method: ' . $metodePembayaran);
                
                // Redirect berdasarkan metode pembayaran
                if ($metodePembayaran === 'transfer') {
                    // Redirect ke halaman konfirmasi pembayaran
                    return redirect()->to('/payment/confirm/' . $orderId)->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
                } else {
                    // COD - langsung ke riwayat pemesanan
                    return redirect()->to('/riwayat-pemesanan')->with('success', 'Pesanan berhasil dikirim! Pembayaran akan dilakukan saat barang diterima.');
                }
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