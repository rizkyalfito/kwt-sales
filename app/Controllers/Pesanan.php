<?php

namespace App\Controllers;

use App\Models\PemesananModel;
use CodeIgniter\Controller;
use Config\Database;

class Pesanan extends Controller
{
    public function __construct()
    {
        $this->db = Database::connect();
        $this->session = session();
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $bookings = $this->pemesananModel->getPemesananWithProduk();

        $sidebarMenu = \Config\SidebarMenu::$menuItems;
        $data = [
            'title' => 'Kelola Pesanan',
            'sidebarMenu' => $sidebarMenu,
            'bookings' => $bookings,
        ];
        return view('pages/pesanan', $data);
    }

    public function updateStatusPesanan($status, $id)
    {
        $this->db->transStart();

        $updateStatus = $this->pemesananModel->updateStatus($id, $status);

        if ($updateStatus) {
            $this->db->transComplete();
            return redirect()->to('/pesanan')->with('success', 'Status Pesanan Berhasil Diubah');
        } else {
            $this->db->transRollBack();
            return redirect()->to('/pesanan')->with('error', 'Status Pesanan Gagal Diubah');
        }
    }

    public function getSalesPerMonth($status)
    {
        // Mapping status dari frontend ke database
        $statusMapping = [
            'selesai' => ['completed', 'selesai'], // Coba kedua status
            'dibatalkan' => ['cancelled', 'dibatalkan'], // Coba kedua status
            'dikirim' => ['shipped', 'dikirim'],
            'diproses' => ['processing', 'diproses']
        ];

        // Cek apakah status valid
        if (!array_key_exists($status, $statusMapping)) {
            return $this->response->setJSON([
                'error' => 'Status tidak valid.',
                'labels' => [],
                'data' => [],
                'countData' => []
            ])->setStatusCode(400);
        }

        $dbStatuses = $statusMapping[$status];

        try {
            // Query untuk mendapatkan data penjualan per bulan (nilai & jumlah)
            $builder = $this->db->table('pemesanan');
            $builder->select("MONTH(tanggal_pesan) as bulan_num, YEAR(tanggal_pesan) as tahun, SUM(total_harga) as total, COUNT(*) as jumlah_pesanan");
            $builder->whereIn('status', $dbStatuses);
            $builder->where('YEAR(tanggal_pesan)', date('Y')); // Hanya tahun ini
            $builder->groupBy('YEAR(tanggal_pesan), MONTH(tanggal_pesan)');
            $builder->orderBy('tahun ASC, bulan_num ASC');

            $result = $builder->get()->getResult();

            // Mapping nama bulan dalam bahasa Indonesia
            $namaBulan = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];

            // Siapkan data untuk chart
            $salesData = [];
            $countData = [];
            foreach ($result as $row) {
                $salesData[$row->bulan_num] = (float) $row->total;
                $countData[$row->bulan_num] = (int) $row->jumlah_pesanan;
            }

            // Generate semua bulan (1-12) dengan data 0 jika tidak ada
            $labels = [];
            $data = [];
            $counts = [];

            for ($i = 1; $i <= 12; $i++) {
                $labels[] = $namaBulan[$i];
                $data[] = $salesData[$i] ?? 0;
                $counts[] = $countData[$i] ?? 0;
            }

            return $this->response->setJSON([
                'labels' => $labels,
                'data' => $data,
                'countData' => $counts
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting sales data: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan saat mengambil data.',
                'labels' => [],
                'data' => [],
                'countData' => []
            ])->setStatusCode(500);
        }
    }

    public function updatePengiriman($id)
    {
        $data = $this->request->getPost();
        
        // Validasi data
        $rules = [
            'pengirim_nama' => 'permit_empty|string|max_length[100]',
            'pengirim_kontak' => 'permit_empty|string|max_length[20]',
            'pengirim_alamat' => 'permit_empty|string',
            'kendaraan_plat_nomor' => 'permit_empty|string|max_length[20]',
            'kendaraan_jenis' => 'permit_empty|string|max_length[50]',
            'kendaraan_merk' => 'permit_empty|string|max_length[50]',
            'ekspedisi_nama' => 'permit_empty|in_list[jne,jnt,sicepat,tiki,pos,lainnya]',
            'ekspedisi_resi' => 'permit_empty|string|max_length[50]',
            'tanggal_pengiriman' => 'permit_empty|valid_date',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(', ', $this->validator->getErrors()));
        }
        
        // Siapkan data update
        $updateData = [
            'pengirim_nama' => $data['pengirim_nama'] ?? null,
            'pengirim_kontak' => $data['pengirim_kontak'] ?? null,
            'pengirim_alamat' => $data['pengirim_alamat'] ?? null,
            'kendaraan_plat_nomor' => $data['kendaraan_plat_nomor'] ?? null,
            'kendaraan_jenis' => $data['kendaraan_jenis'] ?? null,
            'kendaraan_merk' => $data['kendaraan_merk'] ?? null,
            'ekspedisi_nama' => $data['ekspedisi_nama'] ?? null,
            'ekspedisi_resi' => $data['ekspedisi_resi'] ?? null,
            'tanggal_pengiriman' => $data['tanggal_pengiriman'] ?? null,
        ];
        
        // Hapus jenis_pengiriman dari data karena tidak ada di database
        unset($updateData['jenis_pengiriman']);
        
        $result = $this->pemesananModel->update($id, $updateData);
        
        if ($result) {
            return redirect()->to('/pesanan')->with('success', 'Informasi pengiriman berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui informasi pengiriman');
        }
    }
}