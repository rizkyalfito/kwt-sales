<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pemesanan',
        'user',
        'produk',
        'jumlah',
        'total_harga',
        'tanggal_pesan',
        'status',
        'alasan_pembatalan',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [
        'user'          => 'required|numeric',
        'produk'        => 'required|numeric',
        'jumlah'        => 'required|numeric|greater_than[0]',
        'total_harga'   => 'required|numeric',
    ];
    
    protected $validationMessages   = [
        'user' => [
            'required' => 'User ID harus ada',
            'numeric'  => 'User ID tidak valid'
        ],
        'produk' => [
            'required' => 'Produk harus dipilih',
            'numeric'  => 'ID produk tidak valid'
        ],
        'jumlah' => [
            'required'      => 'Jumlah harus diisi',
            'numeric'       => 'Jumlah harus berupa angka',
            'greater_than'  => 'Jumlah minimal 1'
        ],
        'total_harga' => [
            'required' => 'Total harga harus diisi',
            'numeric'  => 'Total harga tidak valid'
        ],
    ];
    
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function simpanPemesanan($data)
    {
        // Generate nomor pemesanan
        $data['pemesanan'] = $this->generateNomorPemesanan();
        
        // Set tanggal pesan
        $data['tanggal_pesan'] = date('Y-m-d');
        
        // Set status default berdasarkan metode pembayaran
        if (isset($data['metode_pembayaran']) && $data['metode_pembayaran'] === 'transfer') {
            $data['status'] = 'pending_payment';
            $data['status_pembayaran'] = 'belum_bayar';
        } else {
            $data['status'] = 'processing';
            $data['status_pembayaran'] = 'lunas'; // COD considered as paid
        }
        
        // Log data sebelum insert
        log_message('info', 'Inserting order data: ' . json_encode($data));
        
        // Insert data menggunakan method bawaan CodeIgniter
        $result = $this->insert($data);
        
        if ($result) {
            log_message('info', 'Order inserted successfully with ID: ' . $this->getInsertID());
        } else {
            log_message('error', 'Failed to insert order: ' . json_encode($this->errors()));
        }
        
        return $result;
    }

    private function generateNomorPemesanan()
    {
        // Ambil nomor pemesanan terakhir berdasarkan ID terbesar
        $lastOrder = $this->orderBy('id', 'DESC')->first();
        
        if ($lastOrder) {
            // Jika sudah ada pesanan, increment dari nomor pemesanan terakhir
            $lastNumber = intval($lastOrder['pemesanan']);
            return $lastNumber + 1;
        }
        
        // Jika belum ada pesanan sama sekali, mulai dari 1001
        return 1001;
    }

    public function getPemesananWithProduk($id = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, pr.nama_produk, pr.harga as harga_satuan, pr.nama_kategori, u.nama as nama_user');
        $builder->join('produk pr', 'pr.id = p.produk', 'left');
        $builder->join('users u', 'u.id = p.user', 'left');
        
        if ($id !== null) {
            $builder->where('p.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->orderBy('p.id', 'DESC')->get()->getResultArray();
    }

    public function getPemesananWithProdukWithFilter($id = null, $month = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, pr.nama_produk, pr.harga as harga_satuan, pr.nama_kategori, u.nama as nama_user');
        $builder->join('produk pr', 'pr.id = p.produk', 'left');
        $builder->join('users u', 'u.id = p.user', 'left');

        if ($id !== null) {
            $builder->where('p.id', $id);
            return $builder->get()->getRowArray();
        }

        if ($month !== null) {
            // pastikan format $month adalah YYYY-MM
            $builder->like('DATE_FORMAT(p.tanggal_pesan, "%Y-%m")', $month);
        }

        return $builder->orderBy('p.id', 'DESC')->get()->getResultArray();
    }

    public function updateStatus($id, $status)
    {
        $allowedStatus = ['pending_payment', 'payment_confirmed', 'payment_rejected', 'processing', 'shipped', 'completed', 'cancelled'];
        
        if (!in_array($status, $allowedStatus)) {
            log_message('error', "Invalid status update attempt: $status for order ID: $id");
            return false;
        }
        
        $updateData = ['status' => $status];
        
        // Auto-update payment status based on order status
        switch($status) {
            case 'payment_confirmed':
            case 'processing':
            case 'shipped':
            case 'completed':
                $updateData['status_pembayaran'] = 'terkonfirmasi';
                break;
            case 'payment_rejected':
                $updateData['status_pembayaran'] = 'gagal';
                break;
            case 'cancelled':
                // Keep existing payment status for cancelled orders
                break;
        }
        
        $result = $this->update($id, $updateData);
        
        if ($result) {
            log_message('info', "Status updated successfully for order ID: $id to status: $status");
        } else {
            log_message('error', "Failed to update status for order ID: $id to status: $status");
        }
        
        return $result;
    }

    public function getRiwayatPemesananByUser($userId)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, pr.nama_produk, pr.nama_kategori');
        $builder->join('produk pr', 'pr.id = p.produk', 'left');
        $builder->where('p.user', $userId);
        $builder->orderBy('p.id', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    public function getStatistikPemesanan($userId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('status, COUNT(*) as jumlah');
        $builder->where('user', $userId);
        $builder->groupBy('status');
        
        $result = $builder->get()->getResultArray();

        // Initialize with all possible statuses
        $stats = [
            'total' => 0,
            'pending_payment' => 0,
            'payment_confirmed' => 0,
            'payment_rejected' => 0,
            'processing' => 0,
            'shipped' => 0,
            'completed' => 0,
            'cancelled' => 0,
            // Legacy compatibility mappings
            'pending' => 0,
            'diproses' => 0,
            'selesai' => 0,
            'dibatalkan' => 0
        ];
        
        foreach ($result as $row) {
            $status = $row['status'];
            $jumlah = $row['jumlah'];
            
            // Set actual status count
            if (array_key_exists($status, $stats)) {
                $stats[$status] = $jumlah;
                $stats['total'] += $jumlah;
            }
            
            // Legacy mapping for backward compatibility
            switch($status) {
                case 'pending_payment':
                case 'payment_confirmed':
                case 'payment_rejected':
                    $stats['pending'] += $jumlah;
                    break;
                case 'processing':
                case 'shipped':
                    $stats['diproses'] += $jumlah;
                    break;
                case 'completed':
                    $stats['selesai'] += $jumlah;
                    break;
                case 'cancelled':
                    $stats['dibatalkan'] += $jumlah;
                    break;
                // Handle legacy statuses if they still exist
                case 'diproses':
                    $stats['processing'] += $jumlah;
                    $stats['diproses'] += $jumlah;
                    break;
                case 'selesai':
                    $stats['completed'] += $jumlah;
                    $stats['selesai'] += $jumlah;
                    break;
                case 'dibatalkan':
                    $stats['cancelled'] += $jumlah;
                    $stats['dibatalkan'] += $jumlah;
                    break;
            }
        }
        
        return $stats;
    }

    public function getDetailPemesanan($id, $userId)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, pr.nama_produk, pr.nama_kategori, pr.harga as harga_satuan, u.nama as nama_user, u.alamat, u.email');
        $builder->join('produk pr', 'pr.id = p.produk', 'left');
        $builder->join('users u', 'u.id = p.user', 'left');
        $builder->where('p.id', $id);
        $builder->where('p.user', $userId);
        
        return $builder->get()->getRowArray();
    }

    public function getPemesananByIdAndUser($id, $userId)
    {
        return $this->where(['id' => $id, 'user' => $userId])->first();
    }

    // Method untuk update payment status
    public function updatePaymentStatus($id, $paymentStatus, $buktiPembayaran = null)
    {
        $allowedPaymentStatus = ['belum_bayar', 'pending', 'terkonfirmasi', 'ditolak'];
        
        if (!in_array($paymentStatus, $allowedPaymentStatus)) {
            log_message('error', "Invalid payment status update attempt: $paymentStatus for order ID: $id");
            return false;
        }
        
        $updateData = ['status_pembayaran' => $paymentStatus];
        
        if ($buktiPembayaran) {
            $updateData['bukti_pembayaran'] = $buktiPembayaran;
        }
        
        // Auto-update order status based on payment status
        switch($paymentStatus) {
            case 'terkonfirmasi':
                $updateData['status'] = 'processing';
                break;
            case 'ditolak':
                $updateData['status'] = 'payment_rejected';
                break;
        }
        
        $result = $this->update($id, $updateData);
        
        if ($result) {
            log_message('info', "Payment status updated successfully for order ID: $id to status: $paymentStatus");
        } else {
            log_message('error', "Failed to update payment status for order ID: $id to status: $paymentStatus");
        }
        
        return $result;
    }

    // Method untuk mendapatkan pesanan berdasarkan status pembayaran
    public function getPemesananByPaymentStatus($paymentStatus, $limit = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, pr.nama_produk, pr.nama_kategori, u.nama as nama_user');
        $builder->join('produk pr', 'pr.id = p.produk', 'left');
        $builder->join('users u', 'u.id = p.user', 'left');
        $builder->where('p.status_pembayaran', $paymentStatus);
        $builder->orderBy('p.id', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }
}