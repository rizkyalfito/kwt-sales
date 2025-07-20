<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pesan extends Controller
{
    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kelola Pesan',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('pages/pesan', $data);
    }
}
