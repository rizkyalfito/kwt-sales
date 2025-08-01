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
        // Validasi input status (jika perlu)
        $allowedStatus = ['selesai', 'dibatalkan', 'dikirim'];
        if (!in_array($status, $allowedStatus)) {
            return $this->response->setJSON([
                'error' => 'Status tidak valid.'
            ])->setStatusCode(400);
        }

        // Ambil data total per bulan untuk status tertentu
        $builder = $this->db->table('pemesanan');
        $builder->select("DATE_FORMAT(tanggal_pesan, '%Y-%m') as bulan, SUM(total_harga) as total");
        $builder->where('status', $status);
        $builder->groupBy('bulan');
        $builder->orderBy('bulan', 'ASC');

        $result = $builder->get()->getResult();

        // Format hasil ke dalam mapping bulan => total
        $salesData = [];
        foreach ($result as $row) {
            $salesData[$row->bulan] = (float) $row->total;
        }

        // Generate bulan 1-12 untuk tahun berjalan
        $year = date('Y');
        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan = sprintf('%s-%02d', $year, $i);
            $labels[] = $bulan;
            $data[] = $salesData[$bulan] ?? 0;
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
