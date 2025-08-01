<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\ProdukModel;
use CodeIgniter\Controller;

class ProdukPublic extends Controller
{
    protected $kategoriModel;
    protected $produkModel;

    public function __construct()
    {
        $this->kategoriModel = new Category();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        // Ambil parameter dari URL
        $kategori = $this->request->getVar('kategori');
        $keyword = $this->request->getVar('keyword');
        
        // Ambil semua kategori untuk dropdown
        $categories = $this->kategoriModel->findAll();
        
        // Ambil semua produk atau filter berdasarkan kategori/keyword
        if (!empty($kategori) || !empty($keyword)) {
            // Jika ada filter kategori berdasarkan ID dari URL (dari klik card kategori)
            if (!empty($kategori) && is_numeric($kategori)) {
                // Cari nama kategori berdasarkan ID
                $categoryData = $this->kategoriModel->find($kategori);
                $namaKategori = $categoryData ? $categoryData['nama_kategori'] : null;
                $produk = $this->produkModel->cariProduk($keyword, $namaKategori);
            } else {
                // Filter berdasarkan nama kategori dari dropdown atau keyword
                $produk = $this->produkModel->cariProduk($keyword, $kategori);
                $namaKategori = $kategori;
            }
        } else {
            $produk = $this->produkModel->findAll();
            $namaKategori = null;
        }

        $data = [
            'produk' => $produk,
            'categories' => $categories,
            'kategori' => $namaKategori,
            'keyword' => $keyword,
            'title' => 'Produk Pertanian'
        ];

        return view('layouts/main', [
            'content' => view('pages/produk-public', $data)
        ]);
    }

    public function cari()
    {
        // Redirect ke method index dengan parameter
        $keyword = $this->request->getVar('keyword');
        $kategori = $this->request->getVar('kategori');
        
        $queryParams = [];
        if (!empty($keyword)) {
            $queryParams['keyword'] = $keyword;
        }
        if (!empty($kategori)) {
            $queryParams['kategori'] = $kategori;
        }
        
        $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
        
        return redirect()->to(base_url('produk-public' . $queryString));
    }
}