<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Kontak as KontakModel;
use Config\Database;

class Kontak extends Controller
{
    public function __construct()
    {
        $this->db = Database::connect();
        $this->session = session();
        $this->kontakModel = new KontakModel();
    }

    public function index()
    {
        $contacts = $this->kontakModel->findAll();
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kontak',
            'sidebarMenu' => $sidebarMenu,
            'contacts' => $contacts
        ];
        return view('pages/kontak', $data);
    }

    public function new()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Tambah Kontak',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('pages/kontak/tambah', $data);
    }

    public function save()
    {
        $this->db->transStart();
        $data = [
            'no_wa' => $this->request->getVar('whatsapp'),
            'email' => $this->request->getVar('email'),
            'alamat' => $this->request->getVar('alamat'),
        ];

        $this->kontakModel->insert($data);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data.');
            return redirect()->to('/kontak/tambah');
        }

        return redirect()->to('/kontak')->with('success', 'Berhasil menyimpan data.');
    }

    public function edit($id)
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Edit Kontak',
            'sidebarMenu' => $sidebarMenu,
            'contact' => $this->kontakModel->find($id),
        ];
        return view('pages/kontak/edit', $data);
    }

    public function update($id)
    {
        $this->db->transStart();
        $data = [
            'no_wa' => $this->request->getVar('whatsapp'),
            'email' => $this->request->getVar('email'),
            'alamat' => $this->request->getVar('alamat'),
        ];

        $this->kontakModel->update([$id], $data);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data.');
            return redirect()->to('/kontak/edit/' . $id);
        }

        return redirect()->to('/kontak')->with('success', 'Berhasil menyimpan data.');
    }
}
