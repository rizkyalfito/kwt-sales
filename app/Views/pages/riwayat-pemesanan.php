<section id="riwayat-pesanan" class="py-5  min-vh-100">
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
                        <option value="pending">Pending</option>
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
                        <h5 class="fw-bold text-primary mb-1">12</h5>
                        <p class="text-muted mb-0">Total Pesanan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-success-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle text-success fs-1 mb-3"></i>
                        <h5 class="fw-bold text-success mb-1">8</h5>
                        <p class="text-muted mb-0">Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-warning-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-clock text-warning fs-1 mb-3"></i>
                        <h5 class="fw-bold text-warning mb-1">3</h5>
                        <p class="text-muted mb-0">Diproses</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-danger-subtle h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-x-circle text-danger fs-1 mb-3"></i>
                        <h5 class="fw-bold text-danger mb-1">1</h5>
                        <p class="text-muted mb-0">Dibatalkan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="row g-4" id="ordersList">
            <!-- Order 1 -->
            <div class="col-lg-6" data-status="selesai">
                <div class="card h-100 shadow-sm border-0 order-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title fw-bold mb-1">Tomat - 1kg</h5>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>05 Mei 2025
                                </small>
                            </div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>Selesai
                            </span>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Total Harga</small>
                                <span class="fw-bold text-success fs-5">Rp 15.000</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Pembayaran</small>
                                <span class="fw-medium">Sudah dibayar</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Alamat Pengiriman</small>
                            <p class="mb-0 text-sm">Jl. Merdeka No. 123, Bekasi Timur</p>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-pill flex-fill" onclick="viewOrderDetail('order-1')">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </button>
                            <button class="btn btn-success btn-sm rounded-pill flex-fill">
                                <i class="bi bi-arrow-repeat me-1"></i>Pesan Lagi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order 2 -->
            <div class="col-lg-6" data-status="selesai">
                <div class="card h-100 shadow-sm border-0 order-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title fw-bold mb-1">Bayam - 5 ikat</h5>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>05 Mei 2025
                                </small>
                            </div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>Selesai
                            </span>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Total Harga</small>
                                <span class="fw-bold text-success fs-5">Rp 25.000</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Pembayaran</small>
                                <span class="fw-medium">Sudah dibayar</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Alamat Pengiriman</small>
                            <p class="mb-0 text-sm">Jl. Sudirman No. 456, Bekasi Selatan</p>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-pill flex-fill" onclick="viewOrderDetail('order-2')">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </button>
                            <button class="btn btn-success btn-sm rounded-pill flex-fill">
                                <i class="bi bi-arrow-repeat me-1"></i>Pesan Lagi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order 3 -->
            <div class="col-lg-6" data-status="diproses">
                <div class="card h-100 shadow-sm border-0 order-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title fw-bold mb-1">Kangkung - 3 ikat</h5>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>10 Mei 2025
                                </small>
                            </div>
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                <i class="bi bi-clock me-1"></i>Diproses
                            </span>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Total Harga</small>
                                <span class="fw-bold text-success fs-5">Rp 12.000</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Pembayaran</small>
                                <span class="fw-medium">Menunggu</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Alamat Pengiriman</small>
                            <p class="mb-0 text-sm">Jl. Ahmad Yani No. 789, Bekasi Utara</p>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-pill flex-fill" onclick="viewOrderDetail('order-3')">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </button>
                            <button class="btn btn-outline-danger btn-sm rounded-pill flex-fill">
                                <i class="bi bi-x-circle me-1"></i>Batalkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order 4 -->
            <div class="col-lg-6" data-status="pending">
                <div class="card h-100 shadow-sm border-0 order-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title fw-bold mb-1">Cabai - 0.5 kg</h5>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>15 Mei 2025
                                </small>
                            </div>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                <i class="bi bi-hourglass-split me-1"></i>Pending
                            </span>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Total Harga</small>
                                <span class="fw-bold text-success fs-5">Rp 10.000</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Pembayaran</small>
                                <span class="fw-medium">Belum bayar</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Alamat Pengiriman</small>
                            <p class="mb-0 text-sm">Jl. Veteran No. 321, Bekasi Barat</p>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-pill flex-fill" onclick="viewOrderDetail('order-4')">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </button>
                            <button class="btn btn-primary btn-sm rounded-pill flex-fill">
                                <i class="bi bi-credit-card me-1"></i>Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div class="text-center py-5" id="emptyState" style="display: none;">
            <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">Tidak ada pesanan ditemukan</h4>
            <p class="text-muted">Coba ubah filter pencarian atau buat pesanan baru</p>
            <a href="<?= base_url('pemesanan') ?>" class="btn btn-success rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Baru
            </a>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-5">
            <button class="btn btn-outline-primary btn-lg px-5 rounded-pill" id="loadMoreBtn">
                <i class="bi bi-arrow-down-circle me-2"></i>Muat Lebih Banyak
            </button>
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
                <!-- Content will be loaded dynamically -->
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

.text-sm {
    font-size: 0.875rem;
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

/* Animation for filtering */
.order-card {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-out {
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const ordersList = document.getElementById('ordersList');
    const emptyState = document.getElementById('emptyState');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    // Search and Filter functionality
    function filterOrders() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const orders = ordersList.querySelectorAll('.col-lg-6');
        let visibleCount = 0;

        orders.forEach(order => {
            const title = order.querySelector('.card-title').textContent.toLowerCase();
            const status = order.dataset.status;
            
            const matchesSearch = title.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;
            
            if (matchesSearch && matchesStatus) {
                order.style.display = 'block';
                visibleCount++;
            } else {
                order.style.display = 'none';
            }
        });

        // Show/hide empty state
        if (visibleCount === 0) {
            emptyState.style.display = 'block';
            loadMoreBtn.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            loadMoreBtn.style.display = 'block';
        }
    }

    searchInput.addEventListener('input', filterOrders);
    statusFilter.addEventListener('change', filterOrders);

    // Load more functionality
    loadMoreBtn.addEventListener('click', function() {
        // Simulate loading more orders
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memuat...';
        
        setTimeout(() => {
            this.innerHTML = '<i class="bi bi-arrow-down-circle me-2"></i>Muat Lebih Banyak';
            // Here you would typically load more data from the server
        }, 1500);
    });
});

// View order detail function
function viewOrderDetail(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
    const content = document.getElementById('orderDetailContent');
    
    // Sample detail content - replace with actual data
    content.innerHTML = `
        <div class="row g-4">
            <div class="col-md-6">
                <h6 class="fw-bold mb-3">Informasi Produk</h6>
                <div class="bg-light p-3 rounded-3">
                    <p class="mb-2"><strong>Produk:</strong> Tomat</p>
                    <p class="mb-2"><strong>Jumlah:</strong> 1 kg</p>
                    <p class="mb-2"><strong>Harga Satuan:</strong> Rp 15.000</p>
                    <p class="mb-0"><strong>Total:</strong> Rp 15.000</p>
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold mb-3">Informasi Pengiriman</h6>
                <div class="bg-light p-3 rounded-3">
                    <p class="mb-2"><strong>Nama:</strong> John Doe</p>
                    <p class="mb-2"><strong>Telepon:</strong> 08123456789</p>
                    <p class="mb-0"><strong>Alamat:</strong> Jl. Merdeka No. 123, Bekasi Timur</p>
                </div>
            </div>
            <div class="col-12">
                <h6 class="fw-bold mb-3">Timeline Pesanan</h6>
                <div class="timeline">
                    <div class="timeline-item completed">
                        <i class="bi bi-check-circle text-success"></i>
                        <div class="ms-3">
                            <h6 class="mb-1">Pesanan Dibuat</h6>
                            <small class="text-muted">05 Mei 2025, 10:00</small>
                        </div>
                    </div>
                    <div class="timeline-item completed">
                        <i class="bi bi-check-circle text-success"></i>
                        <div class="ms-3">
                            <h6 class="mb-1">Pesanan Dikonfirmasi</h6>
                            <small class="text-muted">05 Mei 2025, 11:30</small>
                        </div>
                    </div>
                    <div class="timeline-item completed">
                        <i class="bi bi-check-circle text-success"></i>
                        <div class="ms-3">
                            <h6 class="mb-1">Pesanan Selesai</h6>
                            <small class="text-muted">05 Mei 2025, 14:00</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    modal.show();
}
</script>

<style>
.timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    align-items-center;
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