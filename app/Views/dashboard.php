<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container my-4">
    <div class="row g-3">
        <!-- Total Kategori -->
        <div class="col-sm-6 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-tags fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Total Kategori</h6>
                        <h4 class="mb-0"><?= $this->data['totalCategories'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="col-sm-6 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-box-open fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Total Produk</h6>
                        <h4 class="mb-0"><?= $this->data['totalProducts'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="col-sm-6 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-shopping-cart fa-2x text-danger"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Total Pesanan</h6>
                        <h4 class="mb-0"><?= $this->data['totalBooks'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Penjualan Selesai -->
    <div class="card my-4">
        <div class="card-header">
            <h5 class="mb-0">Penjualan per Bulan (Status: Selesai)</h5>
        </div>
        <div class="card-body">
            <canvas id="penjualanSelesaiChart" height="100"></canvas>
            <div id="errorSelesai" class="alert alert-danger d-none" role="alert"></div>
        </div>
    </div>

    <!-- Chart Penjualan Dibatalkan -->
    <div class="card my-4">
        <div class="card-header">
            <h5 class="mb-0">Penjualan per Bulan (Status: Dibatalkan)</h5>
        </div>
        <div class="card-body">
            <canvas id="penjualanDibatalkanChart" height="100"></canvas>
            <div id="errorDibatalkan" class="alert alert-danger d-none" role="alert"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctxSelesai = document.getElementById('penjualanSelesaiChart').getContext('2d');
        const ctxDibatalkan = document.getElementById('penjualanDibatalkanChart').getContext('2d');

        // Function untuk membuat chart dengan info lengkap
        function createSalesChart(context, data, title, color = 'rgba(40, 167, 69, 0.6)') {
            return new Chart(context, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: data.data,
                        backgroundColor: color,
                        borderColor: color.replace('0.6', '1'),
                        borderWidth: 1,
                        // Simpan data jumlah pesanan untuk tooltip
                        countData: data.countData
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: title
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const nilai = context.raw.toLocaleString('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    });
                                    const jumlah = context.dataset.countData[context.dataIndex];
                                    return [
                                        `Total Nilai: ${nilai}`,
                                        `Jumlah Pesanan: ${jumlah} pesanan`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(value);
                                }
                            },
                            title: {
                                display: true,
                                text: 'Total Penjualan (Rp)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    }
                }
            });
        }

        // Function untuk handle error
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.classList.remove('d-none');
        }

        // Load chart penjualan selesai
        fetch("<?= base_url('/pesanan/sales-chart/selesai') ?>")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(result => {
                if (result.error) {
                    throw new Error(result.error);
                }
                createSalesChart(
                    ctxSelesai, 
                    result, 
                    'Total Penjualan "Selesai" per Bulan', 
                    'rgba(40, 167, 69, 0.6)'    // Hijau untuk selesai
                );
            })
            .catch(error => {
                console.error('Gagal memuat data chart selesai:', error);
                showError('errorSelesai', 'Gagal memuat data penjualan selesai: ' + error.message);
            });

        // Load chart penjualan dibatalkan
        fetch("<?= base_url('/pesanan/sales-chart/dibatalkan') ?>")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(result => {
                if (result.error) {
                    throw new Error(result.error);
                }
                createSalesChart(
                    ctxDibatalkan, 
                    result, 
                    'Total Penjualan "Dibatalkan" per Bulan', 
                    'rgba(220, 53, 69, 0.6)'    // Merah untuk dibatalkan
                );
            })
            .catch(error => {
                console.error('Gagal memuat data chart dibatalkan:', error);
                showError('errorDibatalkan', 'Gagal memuat data penjualan dibatalkan: ' + error.message);
            });
    });
</script>
<?= $this->endSection() ?>