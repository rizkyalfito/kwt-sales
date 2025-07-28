<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;
use Config\Database;

class Auth extends Controller
{
    public function __construct()
    {
        $this->db = Database::connect();
        $this->session = session();
        $this->userModel = new User();
    }

    public function login()
    {
        return view('layouts/auth', ['content' => view('pages/login')]);
    }

    public function register()
    {
        return view('layouts/auth', ['content' => view('pages/register')]);
    }

    public function postLogin()
    {
        $credentials = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
        ];

        $dataUser = $this->userModel->where('username', $credentials['username'])->first();

        if (!$dataUser) {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }

        if (password_verify($credentials['password'], $dataUser['password'])) {
            $this->session->set('isLoggedIn', true);
            $this->session->set('nama', $dataUser['nama']);
            $this->session->set('level', $dataUser['level']);
            $this->session->set('alamat', $dataUser['alamat']);
            $this->session->set('email', $dataUser['email']);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
