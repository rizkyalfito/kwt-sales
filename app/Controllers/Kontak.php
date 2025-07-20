<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Kontak extends Controller
{
    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kontak',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('pages/kontak', $data);
    }
}
