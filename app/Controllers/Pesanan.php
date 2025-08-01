<?php

namespace App\Controllers;

use App\Models\PemesananModel;
use CodeIgniter\Controller;
use Config\Database;

class Pesanan extends Controller
{
    public function __construct()
    {
        $this->db = Database::connect();
        $this->session = session();
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $bookings = $this->pemesananModel->getPemesananWithProduk();

        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kelola Pesanan',
            'sidebarMenu' => $sidebarMenu,
            'bookings' => $bookings,
        ];
        return view('pages/pesanan', $data);
    }

    public function updateStatusPesanan($status, $id)
    {
        $this->db->transStart();

        $updateStatus = $this->pemesananModel->updateStatus($id, $status);

        if ($updateStatus) {
            $this->db->transComplete();
            return redirect()->to('/pesanan')->with('success', 'Status Pesanan Berhasil Diubah');
        } else {
            $this->db->transRollBack();
            return redirect()->to('/pesanan')->with('error', 'Status Pesanan Gagal Diubah');
        }
    }
}
