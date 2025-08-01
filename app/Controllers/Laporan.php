<?php

namespace App\Controllers;

use App\Models\PemesananModel;
use CodeIgniter\Controller;
use Config\Database;

class Laporan extends Controller
{
    public function __construct()
    {
        $this->db = Database::connect();
        $this->session = session();
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $month = $this->request->getGet('month') ?? date('Y-m');

        if ($month && preg_match('/^\d{4}-\d{2}$/', $month)) {
            $bookings = $this->pemesananModel->getPemesananWithProdukWithFilter(null, $month);
        } else {
            $bookings = $this->pemesananModel->getPemesananWithProdukWithFilter();
        }

        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Laporan Penjualan',
            'sidebarMenu' => $sidebarMenu,
            'bookings' => $bookings,
            'selectedMonth' => $month,
        ];
        return view('pages/laporan', $data);
    }
}
