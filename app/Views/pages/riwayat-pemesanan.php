<section id="riwayat-pesanan" class="py-5 min-vh-100">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-3">Riwayat Pesanan</h2>
                <p class="lead text-muted">Lihat daftar pesanan yang telah Anda buat sebelumnya</p>
            </div>
            <div class="col-lg-4">
                <!-- Filter and Search -->
                <div class="d-flex gap-2 flex-wrap">
                    <div class="flex-fill">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari pesanan..." id="searchInput">
                        </div>
                    </div>
                    <select class="form-select" style="max-width: 180px;" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="pending_payment">Menunggu Pembayaran</option>
                        <option value="payment_confirmed">Pembayaran Dikonfirmasi</option>
                        <option value="payment_rejected">Pembayaran Ditolak</option>
                        <option value="processing">Sedang Diproses</option>
                        <option value="shipped">Dikirim</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-primary-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check text-primary fs-1 mb-3"></i>
                        <h5 class="fw-bold text-primary mb-1"><?= $statistik['total'] ?></h5>
                        <p class="text-muted mb-0">Total Pesanan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-warning-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-hourglass-split text-warning fs-1 mb-3"></i>
                        <h5 class="fw-bold text-warning mb-1"><?= $statistik['pending_payment'] + $statistik['processing'] + $statistik['shipped'] ?></h5>
                        <p class="text-muted mb-0">Sedang Berjalan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-success-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle text-success fs-1 mb-3"></i>
                        <h5 class="fw-bold text-success mb-1"><?= $statistik['completed'] ?></h5>
                        <p class="text-muted mb-0">Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-danger-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-x-circle text-danger fs-1 mb-3"></i>
                        <h5 class="fw-bold text-danger mb-1"><?= $statistik['cancelled'] ?></h5>
                        <p class="text-muted mb-0">Dibatalkan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="row g-4" id="ordersList">
            <?php if (!empty($riwayatPemesanan)): ?>
                <?php foreach ($riwayatPemesanan as $pesanan): ?>
                    <?php
                    $statusConfig = getStatusConfig($pesanan['status']);
                    $unit = (stripos($pesanan['nama_kategori'], 'sayur') !== false) ? 'ikat' : 'kg';
                    ?>
                    
                    <div class="col-lg-6" data-status="<?= $pesanan['status'] ?>">
                        <div class="card h-100 shadow-sm border-0 order-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-1"><?= esc($pesanan['nama_produk']) ?> - <?= $pesanan['jumlah'] ?> <?= $unit ?></h5> &nbsp;
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i><?= date('d M Y', strtotime($pesanan['tanggal_pesan'])) ?>
                                        </small>
                                    </div>
                                    <span class="badge <?= $statusConfig['badge'] ?> rounded-pill px-3 py-2">
                                        <i class="<?= $statusConfig['icon'] ?> me-1"></i><?= $statusConfig['label'] ?>
                                    </span>
                                </div>
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Total Harga</small>
                                        <span class="fw-bold text-success fs-5">Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">No. Pesanan</small>
                                        <span class="fw-medium">#<?= $pesanan['pemesanan'] ?></span>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm rounded-pill flex-fill" onclick="viewOrderDetail(<?= $pesanan['id'] ?>)">
                                        <i class="bi bi-eye me-1"></i>Lihat Detail
                                    </button>
                                    
                                    <?php if ($pesanan['status'] === 'pending_payment'): ?>
                                        <a href="<?= base_url('/payment/confirm/' . $pesanan['id']) ?>" class="btn btn-warning btn-sm rounded-pill flex-fill">
                                            <i class="bi bi-credit-card me-1"></i>Bayar Sekarang
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm rounded-pill flex-fill" onclick="batalkanPesanan(<?= $pesanan['id'] ?>)">
                                            <i class="bi bi-x-circle me-1"></i>Batalkan
                                        </button>
                                    <?php elseif (in_array($pesanan['status'], ['processing', 'payment_confirmed'])): ?>
                                        <button class="btn btn-outline-danger btn-sm rounded-pill flex-fill" onclick="batalkanPesanan(<?= $pesanan['id'] ?>)">
                                            <i class="bi bi-x-circle me-1"></i>Batalkan
                                        </button>
                                    <?php elseif ($pesanan['status'] === 'completed'): ?>
                                        <button class="btn btn-success btn-sm rounded-pill flex-fill" onclick="pesanLagi(<?= $pesanan['produk'] ?>)">
                                            <i class="bi bi-arrow-repeat me-1"></i>Pesan Lagi
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <!-- Status Progress for active orders -->
                                <?php if (in_array($pesanan['status'], ['pending_payment', 'payment_confirmed', 'processing', 'shipped'])): ?>
                                    <div class="mt-3">
                                        <small class="text-muted d-block mb-2">Progress Pesanan:</small>
                                        <div class="progress" style="height: 6px;">
                                            <?php 
                                            $progress = getOrderProgress($pesanan['status']);
                                            ?>
                                            <div class="progress-bar bg-<?= $statusConfig['color'] ?>" style="width: <?= $progress ?>%"></div>
                                        </div>
                                        <small class="text-muted mt-1"><?= $progress ?>% selesai</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <!-- Empty state jika tidak ada pesanan -->
            <?php if (empty($riwayatPemesanan)): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mt-3">Belum ada riwayat pesanan</h4>
                        <p class="text-muted">Anda belum pernah membuat pesanan. Mulai berbelanja sekarang!</p>
                        <a href="<?= base_url('pemesanan') ?>" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Baru
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Empty State for filtered results -->
        <div class="text-center py-5" id="emptyState" style="display: none;">
            <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">Tidak ada pesanan ditemukan</h4>
            <p class="text-muted">Coba ubah filter pencarian atau buat pesanan baru</p>
            <a href="<?= base_url('pemesanan') ?>" class="btn btn-success rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Baru
            </a>
        </div>
    </div>
</section>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function getStatusConfig($status) {
    $configs = [
        'pending_payment' => [
            'label' => 'Menunggu Pembayaran',
            'badge' => 'bg-warning-subtle text-warning',
            'icon' => 'bi-credit-card',
            'color' => 'warning'
        ],
        'payment_confirmed' => [
            'label' => 'Pembayaran Dikonfirmasi',
            'badge' => 'bg-info-subtle text-info',
            'icon' => 'bi-check-circle',
            'color' => 'info'
        ],
        'payment_rejected' => [
            'label' => 'Pembayaran Ditolak',
            'badge' => 'bg-danger-subtle text-danger',
            'icon' => 'bi-x-circle',
            'color' => 'danger'
        ],
        'processing' => [
            'label' => 'Sedang Diproses',
            'badge' => 'bg-primary-subtle text-primary',
            'icon' => 'bi-gear',
            'color' => 'primary'
        ],
        'shipped' => [
            'label' => 'Dikirim',
            'badge' => 'bg-info-subtle text-info',
            'icon' => 'bi-truck',
            'color' => 'info'
        ],
        'completed' => [
            'label' => 'Selesai',
            'badge' => 'bg-success-subtle text-success',
            'icon' => 'bi-check-circle-fill',
            'color' => 'success'
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'badge' => 'bg-danger-subtle text-danger',
            'icon' => 'bi-x-circle-fill',
            'color' => 'danger'
        ]
    ];
    
    return $configs[$status] ?? [
        'label' => ucfirst($status),
        'badge' => 'bg-secondary-subtle text-secondary',
        'icon' => 'bi-hourglass-split',
        'color' => 'secondary'
    ];
}

function getOrderProgress($status) {
    $progress = [
        'pending_payment' => 10,
        'payment_confirmed' => 25,
        'processing' => 50,
        'shipped' => 80,
        'completed' => 100
    ];
    
    return $progress[$status] ?? 0;
}
?>

<style>
.order-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.btn-sm {
    font-size: 0.8rem;
}

.form-control:focus, .form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.3s ease;
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem !important;
    }
    
    .order-card:hover {
        transform: none;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
    }
    
    .d-flex.gap-2 .btn {
        margin-bottom: 0.5rem;
    }
}

.timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 8px;
    top: 24px;
    width: 2px;
    height: 20px;
    background-color: #28a745;
}

.timeline-item i {
    font-size: 1.2rem;
    z-index: 1;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

.btn-warning:hover {
    background-color: #ffca2c;
    border-color: #ffc720;
    color: #000;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const ordersList = document.getElementById('ordersList');
    const emptyState = document.getElementById('emptyState');

    function filterOrders() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilterValue = statusFilter.value;
        const orders = ordersList.querySelectorAll('.col-lg-6');
        let visibleCount = 0;

        orders.forEach(order => {
            const title = order.querySelector('.card-title').textContent.toLowerCase();
            const status = order.dataset.status;
            
            const matchesSearch = title.includes(searchTerm);
            const matchesStatus = !statusFilterValue || status === statusFilterValue;
            
            if (matchesSearch && matchesStatus) {
                order.style.display = 'block';
                visibleCount++;
            } else {
                order.style.display = 'none';
            }
        });

        if (visibleCount === 0 && (searchTerm || statusFilterValue)) {
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
        }
    }

    searchInput.addEventListener('input', filterOrders);
    statusFilter.addEventListener('change', filterOrders);
});

function viewOrderDetail(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
    const content = document.getElementById('orderDetailContent');
    
    modal.show();
    
    fetch(`<?= base_url('riwayat-pemesanan/detail') ?>/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const order = data.data;
                const unit = order.nama_kategori.toLowerCase().includes('sayur') ? 'ikat' : 'kg';
                const statusConfig = getStatusConfigJS(order.status);
                
                content.innerHTML = `
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="alert alert-${statusConfig.color} border-0">
                                <div class="d-flex align-items-center">
                                    <i class="${statusConfig.icon} me-2 fs-4"></i>
                                    <div>
                                        <strong>Status: ${statusConfig.label}</strong>
                                        <div class="small mt-1">
                                            ${getStatusDescription(order.status)}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Informasi Produk</h6>
                            <div class="bg-light p-3 rounded-3">
                                <p class="mb-2"><strong>Produk:</strong> ${escapeHtml(order.nama_produk)}</p>
                                <p class="mb-2"><strong>Kategori:</strong> ${escapeHtml(order.nama_kategori)}</p>
                                <p class="mb-2"><strong>Jumlah:</strong> ${order.jumlah} ${unit}</p>
                                <p class="mb-2"><strong>Harga Satuan:</strong> Rp ${parseInt(order.harga_satuan).toLocaleString('id-ID')}</p>
                                <p class="mb-0"><strong>Total:</strong> Rp ${parseInt(order.total_harga).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Informasi Pesanan</h6>
                            <div class="bg-light p-3 rounded-3">
                                <p class="mb-2"><strong>No. Pesanan:</strong> #${order.pemesanan}</p>
                                <p class="mb-2"><strong>Tanggal:</strong> ${formatDate(order.tanggal_pesan)}</p>
                                <p class="mb-2"><strong>Metode Bayar:</strong> ${order.metode_pembayaran || 'Tunai'}</p>
                                <p class="mb-0"><strong>Pemesan:</strong> ${escapeHtml(order.nama_user)}</p>
                            </div>
                        </div>
                        ${order.status === 'pending_payment' && order.metode_pembayaran === 'transfer' ? `
                        <div class="col-12">
                            <div class="text-center">
                                <a href="<?= base_url('/payment/confirm') ?>/${order.id}" class="btn btn-warning btn-lg">
                                    <i class="bi bi-credit-card me-2"></i>Lakukan Pembayaran
                                </a>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        ${data.error || 'Gagal memuat detail pesanan'}
                    </div>
                `;
            }
        })
        .catch(error => {
            content.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Terjadi kesalahan saat memuat data
                </div>
            `;
        });
}

function batalkanPesanan(orderId) {
    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
        fetch(`<?= base_url('riwayat-pemesanan/batalkan') ?>/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pesanan berhasil dibatalkan');
                location.reload();
            } else {
                alert(data.error || 'Gagal membatalkan pesanan');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat membatalkan pesanan');
        });
    }
}

function pesanLagi(productId) {
    window.location.href = `<?= base_url('pemesanan') ?>?produk=${productId}`;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
}

function getStatusConfigJS(status) {
    const configs = {
        'pending_payment': {
            label: 'Menunggu Pembayaran',
            icon: 'bi-credit-card',
            color: 'warning'
        },
        'payment_confirmed': {
            label: 'Pembayaran Dikonfirmasi',
            icon: 'bi-check-circle',
            color: 'info'
        },
        'payment_rejected': {
            label: 'Pembayaran Ditolak',
            icon: 'bi-x-circle',
            color: 'danger'
        },
        'processing': {
            label: 'Sedang Diproses',
            icon: 'bi-gear',
            color: 'primary'
        },
        'shipped': {
            label: 'Dikirim',
            icon: 'bi-truck',
            color: 'info'
        },
        'completed': {
            label: 'Selesai',
            icon: 'bi-check-circle-fill',
            color: 'success'
        },
        'cancelled': {
            label: 'Dibatalkan',
            icon: 'bi-x-circle-fill',
            color: 'danger'
        }
    };
    
    return configs[status] || {
        label: status,
        icon: 'bi-hourglass-split',
        color: 'secondary'
    };
}

function getStatusDescription(status) {
    const descriptions = {
        'pending_payment': 'Silakan lakukan pembayaran untuk melanjutkan pesanan',
        'payment_confirmed': 'Pembayaran Anda telah dikonfirmasi, pesanan akan segera diproses',
        'payment_rejected': 'Pembayaran ditolak, silakan hubungi customer service',
        'processing': 'Pesanan Anda sedang disiapkan',
        'shipped': 'Pesanan Anda sedang dalam perjalanan',
        'completed': 'Pesanan telah selesai dan diterima',
        'cancelled': 'Pesanan telah dibatalkan'
    };
    
    return descriptions[status] || 'Status pesanan';
}
</script>