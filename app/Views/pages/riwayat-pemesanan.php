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
                    <select class="form-select" style="max-width: 150px;" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
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
                <div class="card border-0 bg-success-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle text-success fs-1 mb-3"></i>
                        <h5 class="fw-bold text-success mb-1"><?= $statistik['selesai'] ?></h5>
                        <p class="text-muted mb-0">Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-warning-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-clock text-warning fs-1 mb-3"></i>
                        <h5 class="fw-bold text-warning mb-1"><?= $statistik['diproses'] ?></h5>
                        <p class="text-muted mb-0">Diproses</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-danger-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-x-circle text-danger fs-1 mb-3"></i>
                        <h5 class="fw-bold text-danger mb-1"><?= $statistik['dibatalkan'] ?></h5>
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
                    $statusBadge = '';
                    $statusIcon = '';
                    switch ($pesanan['status']) {
                        case 'selesai':
                            $statusBadge = 'bg-success-subtle text-success';
                            $statusIcon = 'bi-check-circle';
                            break;
                        case 'diproses':
                            $statusBadge = 'bg-warning-subtle text-warning';
                            $statusIcon = 'bi-clock';
                            break;
                        case 'dibatalkan':
                            $statusBadge = 'bg-danger-subtle text-danger';
                            $statusIcon = 'bi-x-circle';
                            break;
                        default:
                            $statusBadge = 'bg-secondary-subtle text-secondary';
                            $statusIcon = 'bi-hourglass-split';
                    }
                    
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
                                    <span class="badge <?= $statusBadge ?> rounded-pill px-3 py-2">
                                        <i class="<?= $statusIcon ?> me-1"></i><?= ucfirst($pesanan['status']) ?>
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
                                    
                                    <?php if ($pesanan['status'] === 'diproses'): ?>
                                        <button class="btn btn-outline-danger btn-sm rounded-pill flex-fill" onclick="batalkanPesanan(<?= $pesanan['id'] ?>)">
                                            <i class="bi bi-x-circle me-1"></i>Batalkan
                                        </button>
                                    <?php elseif ($pesanan['status'] === 'selesai'): ?>
                                        <button class="btn btn-success btn-sm rounded-pill flex-fill" onclick="pesanLagi(<?= $pesanan['produk'] ?>)">
                                            <i class="bi bi-arrow-repeat me-1"></i>Pesan Lagi
                                        </button>
                                    <?php endif; ?>
                                </div>
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
                
                content.innerHTML = `
                    <div class="row g-4">
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
                                <p class="mb-2"><strong>Status:</strong> <span class="badge bg-${getStatusColor(order.status)}">${order.status}</span></p>
                                <p class="mb-0"><strong>Pemesan:</strong> ${escapeHtml(order.nama_user)}</p>
                            </div>
                        </div>
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

function getStatusColor(status) {
    switch(status) {
        case 'selesai': return 'success';
        case 'diproses': return 'warning';
        case 'dibatalkan': return 'danger';
        default: return 'secondary';
    }
}
</script>