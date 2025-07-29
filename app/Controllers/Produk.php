<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProdukModel;

class Produk extends Controller
{
    protected $produkModel;
    
    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        
        // Ambil data produk dari database
        $produkData = $this->produkModel->findAll();
        
        $data = [
            'title' => 'Data Produk',
            'sidebarMenu' => $sidebarMenu,
            'produk' => $produkData,
        ];
        
        return view('pages/produk', $data);
    }
    
    public function cari()
    {
        $keyword = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');
        
        $produkData = $this->produkModel->cariProduk($keyword, $kategori);
        
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        
        $data = [
            'title' => 'Data Produk',
            'sidebarMenu' => $sidebarMenu,
            'produk' => $produkData,
            'keyword' => $keyword,
            'kategori' => $kategori,
        ];
        
        return view('pages/produk', $data);
    }
}