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
            'name' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama wajib diisi']
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => ['required' => 'Alamat wajib diisi']
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ],
            'ktp_photo' => [
                'rules' => 'uploaded[ktp_photo]|max_size[ktp_photo,2048]|is_image[ktp_photo]|mime_in[ktp_photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto KTP wajib diupload',
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format file harus JPG, JPEG, atau PNG'
                ]
            ]
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $ktpPhoto = $this->request->getFile('ktp_photo');
        $newName = '';
        
        if ($ktpPhoto->isValid() && !$ktpPhoto->hasMoved()) {
            $newName = $ktpPhoto->getRandomName();
            
            // Buat direktori jika belum ada
            $uploadPath = ROOTPATH . 'public/assets/image/ktp/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            if (!$ktpPhoto->move($uploadPath, $newName)) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload foto KTP.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'File KTP tidak valid.');
        }

        // Mulai transaksi database
        $this->db->transStart();

        try {
            $data = [
                'nama' => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'alamat' => $this->request->getVar('alamat'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'level' => 'user',
                'ktp_photo' => $newName ? 'assets/image/ktp/' . $newName : null
            ];

            $insertResult = $this->userModel->insert($data);
            
            if (!$insertResult) {
                throw new \Exception('Gagal menyimpan data user');
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal');
            }

            // Set session untuk auto login setelah registrasi
            $sessionData = [
                'isLoggedIn' => true,
                'nama' => $data['nama'],
                'level' => $data['level'],
                'alamat' => $data['alamat'],
                'email' => $data['email']
            ];
            
            $this->session->set($sessionData);
            
            // Set flash message dengan benar
            session()->setFlashdata('success', 'Registrasi berhasil! Selamat datang, ' . $data['nama'] . '.');

            return redirect()->to('/');

        } catch (\Exception $e) {
            $this->db->transRollback();
            
            // Delete uploaded file if database transaction fails
            if ($newName && file_exists(ROOTPATH . 'public/assets/image/ktp/' . $newName)) {
                unlink(ROOTPATH . 'public/assets/image/ktp/' . $newName);
            }
            
            log_message('error', 'Registration failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }
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
            $sessionData = [
                'isLoggedIn' => true,
                'nama' => $dataUser['nama'],
                'level' => $dataUser['level'],
                'alamat' => $dataUser['alamat'],
                'email' => $dataUser['email']
            ];
            
            $this->session->set($sessionData);
            
            // Set flash message dengan benar
            session()->setFlashdata('success', 'Login berhasil! Selamat datang kembali, ' . $dataUser['nama'] . '.');
            
            return $dataUser['level'] === 'admin' 
                ? redirect()->to('/dashboard') 
                : redirect()->to('/');
        } else {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        session()->setFlashdata('success', 'Anda telah berhasil logout.');
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        return view('layouts/auth', ['content' => view('pages/forgot-password')]);
    }

    public function sendResetEmail()
    {
        $email = $this->request->getPost('email');
        
        if (!$email) {
            return redirect()->back()->with('error', 'Email wajib diisi.');
        }

        $user = $this->userModel->where('email', $email)->first();
        
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan dalam sistem kami.');
        }

        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Update user with reset token
        $this->userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expires' => $expires
        ]);

        // Send reset email
        $resetLink = site_url("/reset-password/{$token}");
        
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('noreply@kwtsales.com', 'Kelompok Wanita Tani');
        $emailService->setSubject('Reset Password - Kelompok Wanita Tani');
        
        $emailContent = view('emails/reset-password', [
            'email' => $email,
            'resetLink' => $resetLink
        ]);
        
        $emailService->setMessage($emailContent);
        $emailService->setMailType('html');

        if ($emailService->send()) {
            session()->setFlashdata('success', 'Email reset password telah dikirim. Silakan cek inbox Anda.');
            return redirect()->to('/login');
        } else {
            return redirect()->back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
        }
    }

    public function resetPassword($token)
    {
        $user = $this->userModel->where('reset_token', $token)
            ->where('reset_token_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            session()->setFlashdata('error', 'Token reset password tidak valid atau telah kadaluarsa.');
            return redirect()->to('/login');
        }

        return view('layouts/auth', [
            'content' => view('pages/reset-password', ['token' => $token])
        ]);
    }

    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!$token || !$password || !$confirmPassword) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak cocok.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.');
        }

        $user = $this->userModel->where('reset_token', $token)
            ->where('reset_token_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            session()->setFlashdata('error', 'Token reset password tidak valid atau telah kadaluarsa.');
            return redirect()->to('/login');
        }

        // Update password and clear reset token
        $updateResult = $this->userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);

        if ($updateResult) {
            session()->setFlashdata('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah password. Silakan coba lagi.');
        }

        return redirect()->to('/login');
    }
}