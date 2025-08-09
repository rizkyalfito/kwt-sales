<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentColumnsToPemesananTable extends Migration
{
    public function up()
    {
        // Cek apakah kolom sudah ada sebelum menambahkan
        $fields = $this->db->getFieldData('pemesanan');
        $fieldNames = array_column($fields, 'name');
        
        if (!in_array('metode_pembayaran', $fieldNames)) {
            $this->forge->addColumn('pemesanan', [
                'metode_pembayaran' => [
                    'type'       => 'ENUM',
                    'constraint' => ['cod', 'transfer'],
                    'default'    => 'cod',
                    'after'      => 'status',
                ],
            ]);
        }

        if (!in_array('bukti_pembayaran', $fieldNames)) {
            $this->forge->addColumn('pemesanan', [
                'bukti_pembayaran' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'metode_pembayaran',
                ],
            ]);
        }

        if (!in_array('status_pembayaran', $fieldNames)) {
            $this->forge->addColumn('pemesanan', [
                'status_pembayaran' => [
                    'type'       => 'ENUM',
                    'constraint' => ['pending', 'terkonfirmasi', 'gagal'],
                    'default'    => 'pending',
                    'after'      => 'bukti_pembayaran',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('pemesanan', 'metode_pembayaran');
        $this->forge->dropColumn('pemesanan', 'bukti_pembayaran');
        $this->forge->dropColumn('pemesanan', 'status_pembayaran');
    }
}
