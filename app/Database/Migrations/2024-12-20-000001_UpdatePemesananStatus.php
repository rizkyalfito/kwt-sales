<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePemesananStatus extends Migration
{
    public function up()
    {
        // Update ENUM values for status column
        $this->forge->modifyColumn('pemesanan', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending_payment', 'payment_confirmed', 'payment_rejected', 'processing', 'shipped', 'completed', 'cancelled'],
                'default'    => 'pending_payment',
            ]
        ]);
        
        // Update existing records
        $this->db->table('pemesanan')
            ->where('status', 'diproses')
            ->update(['status' => 'processing']);
            
        $this->db->table('pemesanan')
            ->where('status', 'dikirim')
            ->update(['status' => 'shipped']);
            
        $this->db->table('pemesanan')
            ->where('status', 'selesai')
            ->update(['status' => 'completed']);
            
        $this->db->table('pemesanan')
            ->where('status', 'dibatalkan')
            ->update(['status' => 'cancelled']);
    }

    public function down()
    {
        // Revert back to old status
        $this->db->table('pemesanan')
            ->where('status', 'pending_payment')
            ->update(['status' => 'diproses']);
            
        $this->db->table('pemesanan')
            ->where('status', 'processing')
            ->update(['status' => 'diproses']);
            
        $this->db->table('pemesanan')
            ->where('status', 'shipped')
            ->update(['status' => 'dikirim']);
            
        $this->db->table('pemesanan')
            ->where('status', 'completed')
            ->update(['status' => 'selesai']);
            
        $this->db->table('pemesanan')
            ->where('status', 'cancelled')
            ->update(['status' => 'dibatalkan']);
            
        $this->forge->modifyColumn('pemesanan', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['diproses', 'dikirim', 'selesai', 'dibatalkan'],
                'default'    => 'diproses',
            ]
        ]);
    }
}
