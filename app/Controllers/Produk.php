<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Produk extends Controller
{
    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Data Produk',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('pages/produk', $data);
    }
}
