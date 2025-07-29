<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use CodeIgniter\Controller;
use Config\Database;

class Produk extends Controller
{
    public function __construct()
    {
        $this->db = Database::connect();
        $this->session = session();
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $products = $this->productModel->findAll();
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Data Produk',
            'sidebarMenu' => $sidebarMenu,
            'products' => $products
        ];
        return view('pages/produk', $data);
    }

    public function new()
    {
        $categories = $this->categoryModel->findAll();
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Tambah Data Produk',
            'sidebarMenu' => $sidebarMenu,
            'categories' => $categories
        ];
        return view('pages/produk/tambah', $data);
    }

    public function save()
    {
        $this->db->transStart();
        $data = [
            'nama_produk' => $this->request->getVar('produk'),
            'nama_kategori' => $this->request->getVar('kategori'),
            'stok' => $this->request->getVar('stok'),
            'harga' => $this->request->getVar('harga'),
            'detail' => $this->request->getVar('detail'),
        ];

        $gambar = $this->request->getFile('gambar');
        $data['gambar'] = $gambar->getRandomName();
        $gambar->move('assets/image/product/', $data['gambar']);

        $this->productModel->insert($data);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data.');
            return redirect()->to('/produk/tambah');
        }

        return redirect()->to('/produk')->with('success', 'Berhasil menyimpan data.');
    }

    public function edit($id)
    {
        $categories = $this->categoryModel->findAll();
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Edit Produk',
            'sidebarMenu' => $sidebarMenu,
            'product' => $this->productModel->find($id),
            'categories' => $categories
        ];
        return view('pages/produk/edit', $data);
    }

    public function update($id)
    {
        $this->db->transStart();
        $data = [
            'nama_produk' => $this->request->getVar('produk'),
            'nama_kategori' => $this->request->getVar('kategori'),
            'stok' => $this->request->getVar('stok'),
            'harga' => $this->request->getVar('harga'),
            'detail' => $this->request->getVar('detail'),
        ];

        $gambar = $this->request->getFile('gambar');

        if ($gambar->isFile()) {
            $data['gambar'] = $gambar->getRandomName();
            $gambar->move('assets/image/product/', $data['gambar']);
        }

        $this->productModel->update([$id], $data);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal mengubah data.');
            return redirect()->to('/produk/edit/' . $id);
        }

        return redirect()->to('/produk')->with('success', 'Berhasil mengubah data.');
    }

    public function delete($id)
    {
        $this->db->transStart();
        $this->productModel->delete($id);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menghapus data.');
            return redirect()->to('/produk');
        }

        return redirect()->to('/produk')->with('success', 'Berhasil menghapus data.');
    }
}
