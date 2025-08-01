<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_kategori'];

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
    protected $validationRules = [
        'nama_kategori' => 'required|min_length[2]|max_length[35]|is_unique[kategori.nama_kategori,id,{id}]'
    ];
    
    protected $validationMessages = [
        'nama_kategori' => [
            'required'    => 'Nama kategori harus diisi',
            'min_length'  => 'Nama kategori minimal 2 karakter',
            'max_length'  => 'Nama kategori maksimal 35 karakter',
            'is_unique'   => 'Nama kategori sudah ada'
        ]
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

    public function getCategoriesWithProductCount()
    {
        return $this->select('kategori.*, COUNT(produk.id) as product_count')
                    ->join('produk', 'produk.kategori_id = kategori.id', 'left')
                    ->groupBy('kategori.id')
                    ->findAll();
    }

    public function getCategoryWithProductCount($id)
    {
        return $this->select('kategori.*, COUNT(produk.id) as product_count')
                    ->join('produk', 'produk.kategori_id = kategori.id', 'left')
                    ->where('kategori.id', $id)
                    ->groupBy('kategori.id')
                    ->first();
    }

    public function hasProducts($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('produk');
        $count = $builder->where('kategori_id', $id)->countAllResults();
        
        return $count > 0;
    }

    public function getActiveCategories()
    {
        return $this->select('kategori.*')
                    ->join('produk', 'produk.kategori_id = kategori.id', 'inner')
                    ->groupBy('kategori.id')
                    ->findAll();
    }

    public function searchCategories($keyword)
    {
        return $this->like('nama_kategori', $keyword)->findAll();
    }
}