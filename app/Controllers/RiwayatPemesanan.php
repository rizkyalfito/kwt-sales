<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class RiwayatPemesanan extends Controller
{
    public function index()
    {
        echo view('layouts/main', ['content' => view('pages/riwayat-pemesanan')]);
    }
}
