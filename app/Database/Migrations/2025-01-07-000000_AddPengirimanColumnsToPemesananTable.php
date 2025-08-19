<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPengirimanColumnsToPemesananTable extends Migration
{
    public function up()
    {
        // Tambahkan kolom untuk informasi pengiriman
        $fields = [
            'pengirim_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'status',
            ],
            'pengirim_kontak' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'pengirim_nama',
            ],
            'pengirim_alamat' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'pengirim_kontak',
            ],
            'kendaraan_plat_nomor' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'pengirim_alamat',
            ],
            'kendaraan_jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'kendaraan_plat_nomor',
            ],
            'kendaraan_merk' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'kendaraan_jenis',
            ],
            'ekspedisi_nama' => [
                'type'       => 'ENUM',
                'constraint' => ['jne', 'jnt', 'sicepat', 'tiki', 'pos', 'lainnya'],
                'null'       => true,
                'after'      => 'kendaraan_merk',
            ],
            'ekspedisi_resi' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'ekspedisi_nama',
            ],
            'tanggal_pengiriman' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'ekspedisi_resi',
            ],
            'status_pembatalan' => [
                'type'       => 'ENUM',
                'constraint' => ['tidak_dibatalkan', 'menunggu_konfirmasi', 'dikonfirmasi', 'ditolak'],
                'default'    => 'tidak_dibatalkan',
                'after'      => 'tanggal_pengiriman',
            ],
            'tanggal_pembatalan' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'alasan_pembatalan',
            ],
            'dikonfirmasi_oleh' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'tanggal_pembatalan',
            ],
        ];

        $this->forge->addColumn('pemesanan', $fields);
    }

    public function down()
    {
        // Hapus kolom yang ditambahkan
        $columns = [
            'pengirim_nama',
            'pengirim_kontak',
            'pengirim_alamat',
            'kendaraan_plat_nomor',
            'kendaraan_jenis',
            'kendaraan_merk',
            'ekspedisi_nama',
            'ekspedisi_resi',
            'tanggal_pengiriman',
            'status_pembatalan',
            'alasan_pembatalan',
            'tanggal_pembatalan',
            'dikonfirmasi_oleh'
        ];

        $this->forge->dropColumn('pemesanan', $columns);
    }
}
