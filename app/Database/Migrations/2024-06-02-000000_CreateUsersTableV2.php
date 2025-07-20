<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTableV2 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'level' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default'    => 'user',
            ],
            'email' => [
                'type'       => 'CHAR',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
