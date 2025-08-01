<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Kontak as KontakModel;

class KontakPublic extends Controller
{
    protected $kontakModel;

    public function __construct()
    {
        $this->kontakModel = new KontakModel();
    }

    public function kontak()
    {
        // Ambil data kontak pertama (asumsi hanya ada 1 data kontak utama)
        $kontak = $this->kontakModel->first();
        
        $data = [
            'title' => 'Kontak Kami',
            'kontak' => $kontak
        ];
        
        return view('frontend/kontak', $data);
    }
}