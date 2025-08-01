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
        $data['pemesanan'] = $this->generateNomorPemesanan();
        $data['tanggal_pesan'] = date('Y-m-d');
        $data['status'] = 'diproses';
        
        return $this->insert($data);
    }

    private function generateNomorPemesanan()
    {
        $lastOrder = $this->orderBy('id', 'DESC')->first();
        if ($lastOrder && isset($lastOrder['pemesanan'])) {
            return $lastOrder['pemesanan'] + 1;
        }
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
        $allowedStatus = ['diproses', 'dikirim', 'selesai', 'dibatalkan'];
        
        if (!in_array($status, $allowedStatus)) {
            return false;
        }
        
        return $this->update($id, ['status' => $status]);
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

        $stats = [
            'total' => 0,
            'diproses' => 0,
            'selesai' => 0,
            'dibatalkan' => 0,
            'pending' => 0
        ];
        
        foreach ($result as $row) {
            $stats[$row['status']] = $row['jumlah'];
            $stats['total'] += $row['jumlah'];
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
}