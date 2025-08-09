<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKtpPhotoToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'ktp_photo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'email'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'ktp_photo');
    }
}
