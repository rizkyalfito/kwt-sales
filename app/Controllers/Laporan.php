<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Laporan extends Controller
{
    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Laporan Penjualan',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('pages/laporan', $data);
    }
}
