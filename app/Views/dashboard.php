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

    <div class="card my-4">
        <div class="card-header">
            <h5 class="mb-0">Total Penjualan per Bulan (Status: Selesai)</h5>
        </div>
        <div class="card-body">
            <canvas id="penjualanChart" height="100"></canvas>
        </div>
    </div>

    <div class="card my-4">
        <div class="card-header">
            <h5 class="mb-0">Total Penjualan per Bulan (Status: Dibatalkan)</h5>
        </div>
        <div class="card-body">
            <canvas id="penjualanDibatalkanChart" height="100"></canvas>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('penjualanChart').getContext('2d');
        const ctxRejected = document.getElementById('penjualanDibatalkanChart').getContext('2d');

        // Fetch data via AJAX
        fetch("<?= base_url('pesanan/sales-chart/selesai') ?>")
            .then(response => response.json())
            .then(result => {
                // Build chart
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: result.labels,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: result.data,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Total Penjualan “Selesai” per Bulan'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw.toLocaleString('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR'
                                        });
                                        return `${context.dataset.label}: ${value}`;
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
            })
            .catch(error => {
                console.error('Gagal memuat data chart:', error);
            });

        // Fetch data via AJAX
        fetch("<?= base_url('pesanan/sales-chart/dibatalkan') ?>")
            .then(response => response.json())
            .then(result => {
                // Build chart
                const chart = new Chart(ctxRejected, {
                    type: 'bar',
                    data: {
                        labels: result.labels,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: result.data,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Total Penjualan “Dibatalkan” per Bulan'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw.toLocaleString('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR'
                                        });
                                        return `${context.dataset.label}: ${value}`;
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
            })
            .catch(error => {
                console.error('Gagal memuat data chart:', error);
            });
    });
</script>
<?= $this->endSection() ?>
