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

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'produk'        => 'required|numeric',
        'jumlah'        => 'required|numeric|greater_than[0]',
        'total_harga'   => 'required|numeric',
    ];
    protected $validationMessages   = [
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

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Simpan data pemesanan
     */
    public function simpanPemesanan($data)
    {
        // Generate nomor pemesanan unik
        $data['pemesanan'] = $this->generateNomorPemesanan();
        $data['tanggal_pesan'] = date('Y-m-d');
        $data['status'] = 'diproses';
        
        return $this->insert($data);
    }

    /**
     * Generate nomor pemesanan unik
     */
    private function generateNomorPemesanan()
    {
        $lastOrder = $this->orderBy('id', 'DESC')->first();
        $lastNumber = $lastOrder ? $lastOrder['pemesanan'] : 0;
        return $lastNumber + 1;
    }

    /**
     * Ambil data pemesanan dengan detail produk
     */
    public function getPemesananWithProduk($id = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, pr.nama_produk, pr.harga as harga_satuan, pr.nama_kategori');
        $builder->join('produk pr', 'pr.id = p.produk', 'left');
        
        if ($id !== null) {
            $builder->where('p.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->orderBy('p.id', 'DESC')->get()->getResultArray();
    }

    /**
     * Update status pemesanan
     */
    public function updateStatus($id, $status)
    {
        $allowedStatus = ['diproses', 'dikirim', 'selesai', 'dibatalkan'];
        
        if (!in_array($status, $allowedStatus)) {
            return false;
        }
        
        return $this->update($id, ['status' => $status]);
    }
}