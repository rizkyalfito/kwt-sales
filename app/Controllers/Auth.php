<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        echo view('layouts/auth', ['content' => view('pages/login')]);
    }

    public function register()
    {
        echo view('layouts/auth', ['content' => view('pages/register')]);
    }
}
