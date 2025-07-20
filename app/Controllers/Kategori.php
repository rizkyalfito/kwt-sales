<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Kategori extends Controller
{
    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kategori Produk',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('pages/kategori', $data);
    }
}
