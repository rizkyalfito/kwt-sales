<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProdukModel;

class Pemesanan extends Controller
{
    protected $produkModel;
    
    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
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
        ];
        
        return view('layouts/main', [
            'content' => view('pages/pemesanan', $data)
        ]);
    }
    
    public function submitOrder()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'product' => 'required',
            'quantity' => 'required|integer|greater_than[0]',
            'name' => 'required|min_length[3]',
            'phone' => 'required|min_length[10]',
            'address' => 'required|min_length[10]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Proses data pesanan
        $orderData = [
            'product_id' => $this->request->getPost('product'),
            'quantity' => $this->request->getPost('quantity'),
            'customer_name' => $this->request->getPost('name'),
            'customer_phone' => $this->request->getPost('phone'),
            'customer_address' => $this->request->getPost('address'),
            'notes' => $this->request->getPost('notes'),
            'order_date' => date('Y-m-d H:i:s'),
            'status' => 'pending'
        ];
        
        // Di sini Anda bisa menyimpan ke database atau kirim ke WhatsApp admin
        // Untuk contoh, kita redirect dengan pesan sukses
        
        return redirect()->to('/pemesanan')->with('success', 'Pesanan berhasil dikirim! Admin akan menghubungi Anda segera.');
    }
}