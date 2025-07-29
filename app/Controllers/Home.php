<?php

namespace App\Controllers;

use App\Models\Category;
use CodeIgniter\Controller;

class Home extends Controller
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new Category();
    }

    public function index()
    {
        $data = [
            'categories' => $this->kategoriModel->findAll()
        ];

        echo view('layouts/main', [
            'content' => view('pages/home', $data)
        ]);
    }
}