<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Dashboard',
            'sidebarMenu' => $sidebarMenu,
        ];
        return view('dashboard', $data);
    }
}
