<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\ProdukModel;
use App\Models\Kontak;
use CodeIgniter\Controller;

class Home extends Controller
{
    protected $kategoriModel;
    protected $produkModel;
    protected $kontakModel;

    public function __construct()
    {
        $this->kategoriModel = new Category();
        $this->produkModel = new ProdukModel();
        $this->kontakModel = new Kontak();
    }

    public function index()
    {
        $kontak = $this->kontakModel->first();

        $data = [
            'categories' => $this->kategoriModel->findAll(),
            'produk' => $this->produkModel->findAll(), 
            'kontak' => $kontak
        ];

        echo view('layouts/main', [
            'content' => view('pages/home', $data)
        ]);
    }

    public function produk()
    {
        $kategori = $this->request->getVar('kategori');
        $keyword = $this->request->getVar('keyword');

        $categories = $this->kategoriModel->findAll();

        if (!empty($kategori) || !empty($keyword)) {
            if (!empty($kategori) && is_numeric($kategori)) {
                $categoryData = $this->kategoriModel->find($kategori);
                $namaKategori = $categoryData ? $categoryData['nama_kategori'] : null;
                $produk = $this->produkModel->cariProduk($keyword, $namaKategori);
            } else {
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
            'keyword' => $keyword
        ];

        echo view('layouts/main', [
            'content' => view('pages/produk', $data)
        ]);
    }
}
