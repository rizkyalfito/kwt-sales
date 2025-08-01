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

    public function postRegister()
    {
        // Validasi input terlebih dahulu
        $validation = $this->validate([
            'name' => 'required',
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email',
            'alamat' => 'required',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Mulai transaksi database
        $this->db->transStart();

        $data = [
            'nama' => $this->request->getVar('name'),
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'alamat' => $this->request->getVar('alamat'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'level' => 'user'
        ];

        $this->userModel->insert($data);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        }

        $this->session->set('isLoggedIn', true);
        $this->session->set('nama', $data['nama']);
        $this->session->set('level', $data['level']);
        $this->session->set('alamat', $data['alamat']);
        $this->session->set('email', $data['email']);

        return redirect()->to('/');
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
            return $dataUser['level'] === 'admin' ? redirect()->to('/dashboard') : redirect()->to('/');
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
