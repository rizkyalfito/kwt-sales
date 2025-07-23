<section id="produk" class="py-5 bg-white mb-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-3">Data Produk</h2>
                <p class="lead text-muted">Berikut adalah daftar produk hasil pertanian yang tersedia :</p>
            </div>
            <div class="col-lg-4">
                <!-- Search and Filter -->
                <div class="d-flex gap-2 flex-wrap">
                    <div class="flex-fill">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari produk...">
                        </div>
                    </div>
                    <select class="form-select" style="max-width: 150px;">
                        <option>Pilih kategori</option>
                        <option>Sayur</option>
                        <option>Buah</option>
                        <option>Bumbu</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row g-4">
            <!-- Product 1 - Kangkung -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <div class="placeholder-img bg-secondary-subtle rounded" style="width: 150px; height: 150px; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                            <!-- X lines for placeholder -->
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 150">
                                <line x1="20" y1="20" x2="130" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                <line x1="130" y1="20" x2="20" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">Kangkung</h5>
                        <div class="mb-2">
                            <span class="badge bg-success-subtle text-success rounded-pill">sayur</span>
                        </div>
                        <p class="text-muted mb-2"><strong>Harga:</strong> Rp 4.000/ikat</p>
                        <p class="text-muted mb-3"><strong>Stok:</strong> 20 ikat</p>
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 2 - Bayam -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <div class="placeholder-img bg-secondary-subtle rounded" style="width: 150px; height: 150px; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 150">
                                <line x1="20" y1="20" x2="130" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                <line x1="130" y1="20" x2="20" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">Bayam</h5>
                        <div class="mb-2">
                            <span class="badge bg-success-subtle text-success rounded-pill">sayur</span>
                        </div>
                        <p class="text-muted mb-2"><strong>Harga:</strong> Rp 5.000/ikat</p>
                        <p class="text-muted mb-3"><strong>Stok:</strong> 20 ikat</p>
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 3 - Cabai -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <div class="placeholder-img bg-secondary-subtle rounded" style="width: 150px; height: 150px; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 150">
                                <line x1="20" y1="20" x2="130" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                <line x1="130" y1="20" x2="20" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">Cabai</h5>
                        <div class="mb-2">
                            <span class="badge bg-danger-subtle text-danger rounded-pill">buah</span>
                        </div>
                        <p class="text-muted mb-2"><strong>Harga:</strong> Rp 20.000/kg</p>
                        <p class="text-muted mb-3"><strong>Stok:</strong> 10 kg</p>
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 4 - Tomat -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <div class="placeholder-img bg-secondary-subtle rounded" style="width: 150px; height: 150px; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 150">
                                <line x1="20" y1="20" x2="130" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                <line x1="130" y1="20" x2="20" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">Tomat</h5>
                        <div class="mb-2">
                            <span class="badge bg-danger-subtle text-danger rounded-pill">buah</span>
                        </div>
                        <p class="text-muted mb-2"><strong>Harga:</strong> Rp 8.000/kg</p>
                        <p class="text-muted mb-3"><strong>Stok:</strong> 15 kg</p>
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 5 - Terong -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <div class="placeholder-img bg-secondary-subtle rounded" style="width: 150px; height: 150px; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 150">
                                <line x1="20" y1="20" x2="130" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                <line x1="130" y1="20" x2="20" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">Terong</h5>
                        <div class="mb-2">
                            <span class="badge bg-success-subtle text-success rounded-pill">sayur</span>
                        </div>
                        <p class="text-muted mb-2"><strong>Harga:</strong> Rp 6.000/kg</p>
                        <p class="text-muted mb-3"><strong>Stok:</strong> 12 kg</p>
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 6 - Bawang Merah -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <div class="placeholder-img bg-secondary-subtle rounded" style="width: 150px; height: 150px; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 150">
                                <line x1="20" y1="20" x2="130" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                <line x1="130" y1="20" x2="20" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">Bawang Merah</h5>
                        <div class="mb-2">
                            <span class="badge bg-warning-subtle text-warning rounded-pill">bumbu</span>
                        </div>
                        <p class="text-muted mb-2"><strong>Harga:</strong> Rp 25.000/kg</p>
                        <p class="text-muted mb-3"><strong>Stok:</strong> 8 kg</p>
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-5">
            <button class="btn btn-success btn-lg px-5 rounded-pill">
                <i class="bi bi-arrow-clockwise me-2"></i>Muat Produk Lainnya
            </button>
        </div>
    </div>
</section>

<style>
.product-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
}

.placeholder-img {
    transition: all 0.3s ease;
}

.product-card:hover .placeholder-img {
    transform: scale(1.05);
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.btn-outline-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem !important;
    }
    
    .product-card:hover {
        transform: none;
    }
}
</style>