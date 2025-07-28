<?php

namespace App\Controllers;

use App\Models\Category;
use CodeIgniter\Controller;
use Config\Database;

class Kategori extends Controller
{
    public function __construct()
    {
        $this->db = Database::connect();
        $this->session = session();
        $this->kategoriModel = new Category();
    }

    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kategori Produk',
            'sidebarMenu' => $sidebarMenu,
            'categories' => $this->kategoriModel->findAll()
        ];
        return view('pages/kategori', $data);
    }

    public function new()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kategori Produk',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('pages/kategori/tambah', $data);
    }

    public function save()
    {
        $this->db->transStart();
        $data = [
            'nama_kategori' => $this->request->getVar('kategori'),
        ];

        $this->kategoriModel->insert($data);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data.');
            return redirect()->to('/kategori/tambah');
        }

        return redirect()->to('/kategori')->with('success', 'Berhasil menyimpan data.');
    }

    public function edit($id)
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kategori Produk',
            'sidebarMenu' => $sidebarMenu,
            'category' => $this->kategoriModel->find($id),
        ];
        return view('pages/kategori/edit', $data);
    }

    public function update($id)
    {
        $this->db->transStart();
        $data = [
            'nama_kategori' => $this->request->getVar('kategori'),
        ];

        $this->kategoriModel->update([$id], $data);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data.');
            return redirect()->to('/kategori/ubah' . $id);
        }

        return redirect()->to('/kategori')->with('success', 'Berhasil mengubah data.');
    }

    public function delete($id)
    {
        $this->db->transStart();
        $this->kategoriModel->delete($id);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menghapus data.');
            return redirect()->to('/kategori');
        }

        return redirect()->to('/kategori')->with('success', 'Berhasil menghapus data.');
    }
}
