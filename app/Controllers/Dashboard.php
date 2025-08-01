<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\PemesananModel;
use App\Models\Product;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->kategoriModel = new Category();
        $this->produkModel = new Product();
        $this->pesananModel = new PemesananModel();
    }

    public function index()
    {
        $totalCategories = $this->kategoriModel->countAllResults();
        $totalProducts = $this->produkModel->countAllResults();
        $totalBooks = $this->pesananModel->countAllResults();

        $bookings = $this->pesananModel->getPemesananWithProduk();

        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Dashboard',
            'sidebarMenu' => $sidebarMenu,
            'totalCategories' => $totalCategories,
            'totalProducts' => $totalProducts,
            'totalBooks' => $totalBooks,
            'bookings' => $bookings,
        ];
        return view('dashboard', $data);
    }

}
