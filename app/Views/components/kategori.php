<section id="kategori" class="py-5 bg-white mb-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-3">Kategori Produk</h2>
            </div>
            <div class="col-lg-4">
                <!-- Search -->
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari kategori...">
                </div>
            </div>
        </div>

        <!-- Category Grid -->
        <div class="row g-4 justify-content-center">
            <!-- Category 1 - Sayuran -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 category-card">
                    <div class="card-body text-center p-4">
                        <!-- Placeholder Image -->
                        <div class="category-img-placeholder bg-white rounded shadow-sm mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 150px; height: 120px; border: 2px solid #dee2e6; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-muted fs-3"></i>
                            </div>
                            <!-- X lines for placeholder -->
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 120">
                                <line x1="15" y1="15" x2="135" y2="105" stroke="#6c757d" stroke-width="1"/>
                                <line x1="135" y1="15" x2="15" y2="105" stroke="#6c757d" stroke-width="1"/>
                            </svg>
                        </div>
                        
                        <h4 class="fw-bold mb-3 text-success">Sayuran</h4>
                        <p class="text-muted mb-4">Bayam, kangkung, terong, dll</p>
                        
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Produk
                        </button>
                    </div>
                </div>
            </div>

            <!-- Category 2 - Buah-buahan -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 category-card">
                    <div class="card-body text-center p-4">
                        <!-- Placeholder Image -->
                        <div class="category-img-placeholder bg-white rounded shadow-sm mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 150px; height: 120px; border: 2px solid #dee2e6; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-muted fs-3"></i>
                            </div>
                            <!-- X lines for placeholder -->
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 120">
                                <line x1="15" y1="15" x2="135" y2="105" stroke="#6c757d" stroke-width="1"/>
                                <line x1="135" y1="15" x2="15" y2="105" stroke="#6c757d" stroke-width="1"/>
                            </svg>
                        </div>
                        
                        <h4 class="fw-bold mb-3 text-success">Buah-buahan</h4>
                        <p class="text-muted mb-4">Tomat, jeruk, timun suri, dll</p>
                        
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Produk
                        </button>
                    </div>
                </div>
            </div>

            <!-- Category 3 - Lainnya -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 category-card">
                    <div class="card-body text-center p-4">
                        <!-- Placeholder Image -->
                        <div class="category-img-placeholder bg-white rounded shadow-sm mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 150px; height: 120px; border: 2px solid #dee2e6; position: relative;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-image text-muted fs-3"></i>
                            </div>
                            <!-- X lines for placeholder -->
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 120">
                                <line x1="15" y1="15" x2="135" y2="105" stroke="#6c757d" stroke-width="1"/>
                                <line x1="135" y1="15" x2="15" y2="105" stroke="#6c757d" stroke-width="1"/>
                            </svg>
                        </div>
                        
                        <h4 class="fw-bold mb-3 text-success">Lainnya</h4>
                        <p class="text-muted mb-4">Bibit, kompos, pupuk, dll</p>
                        
                        <button class="btn btn-outline-success w-100 rounded-pill">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="alert border-0 rounded-4" role="alert" style="background-color: #145a32; color: white;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-pencil-square me-3 fs-4"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Klik card kategori untuk melihat daftar produk yang tersedia</h5>
                            <p class="mb-0">Temukan produk pertanian berkualitas sesuai kebutuhan Anda dengan mudah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.category-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.category-img-placeholder {
    transition: all 0.3s ease;
}

.category-card:hover .category-img-placeholder {
    transform: scale(1.05);
    border-color: #28a745 !important;
}

.category-card:hover h4 {
    transform: scale(1.05);
}

.btn-outline-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}



@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem !important;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
    }
    
    .category-img-placeholder {
        width: 120px !important;
        height: 100px !important;
    }
}
</style>