<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => password_hash('qwerty', PASSWORD_DEFAULT),
            'alamat' => 'Bekasi',
            'level' => 'admin',
            'email' => 'admin@gmail.com'
        ]);
        $this->db->table('users')->insert([
            'nama' => 'user',
            'username' => 'user',
            'password' => password_hash('qwerty', PASSWORD_DEFAULT),
            'alamat' => 'Bekasi',
            'level' => 'user',
            'email' => 'user@gmail.com'
        ]);
    }
}
