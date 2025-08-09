<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAlasanPembatalanToPemesananTable extends Migration
{
    public function up()
    {
        $fields = [
            'alasan_pembatalan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status' // place after status column
            ]
        ];
        $this->forge->addColumn('pemesanan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pemesanan', 'alasan_pembatalan');
    }
}
