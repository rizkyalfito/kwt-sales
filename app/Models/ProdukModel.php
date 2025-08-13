<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_produk',
        'nama_kategori', 
        'stok',
        'harga',
        'detail',
        'gambar',
        'satuan'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
     * Cari produk berdasarkan keyword dan kategori
     */
    public function cariProduk($keyword = null, $kategori = null)
    {
        $builder = $this->builder();
        
        if (!empty($keyword)) {
            $builder->like('nama_produk', $keyword);
        }
        
        if (!empty($kategori) && $kategori !== 'Pilih kategori') {
            $builder->like('nama_kategori', $kategori);
        }
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Format harga ke format rupiah
     */
    public function formatRupiah($harga)
    {
        return 'Rp ' . number_format($harga, 0, ',', '.');
    }
    
    /**
     * Get badge color berdasarkan kategori
     */
    public function getBadgeColor($kategori)
    {
        $colors = [
            'sayur' => 'success',
            'buah' => 'success', 
            'bumbu' => 'success',
        ];
        
        return $colors[strtolower($kategori)] ?? 'secondary';
    }
}