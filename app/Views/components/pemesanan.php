<section id="pemesanan" class="py-5 bg-white mb-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold text-dark mb-3">Pemesanan Produk</h2>
            </div>
        </div>

        <!-- Order Options -->
        <div class="row g-4 justify-content-center">
            <!-- Option 1 - Pesan Sekarang -->
            <div class="col-lg-5 col-md-6">
                <div class="card h-100 shadow-sm border-2 order-card">
                    <div class="card-body text-center p-5">
                        <!-- Icon -->
                        <div class="order-icon-wrapper bg-success bg-opacity-10 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="bi bi-cart3 text-success" style="font-size: 3rem;"></i>
                        </div>
                        
                        <h3 class="fw-bold mb-3 text-dark">Pesan sekarang</h3>
                        <p class="text-muted mb-4">Langsung pesan produk yang diinginkan dengan mudah dan cepat</p>
                        
                        <a href="<?= base_url('pemesanan') ?>" class="btn btn-success btn-lg px-4 rounded-pill">
                            <i class="bi bi-cart-plus me-2"></i>Mulai Pesan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Option 2 - Riwayat Pesanan -->
            <div class="col-lg-5 col-md-6">
                <div class="card h-100 shadow-sm border-2 order-card">
                    <div class="card-body text-center p-5">
                        <!-- Icon -->
                        <div class="order-icon-wrapper bg-primary bg-opacity-10 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="bi bi-clock-history text-primary" style="font-size: 3rem;"></i>
                        </div>
                        
                        <h3 class="fw-bold mb-3 text-dark">Riwayat pesanan</h3>
                        <p class="text-muted mb-4">Lihat status dan riwayat pemesanan produk yang pernah dipesan</p>
                        
                        <a href="<?= base_url('riwayat-pemesanan') ?>" class="btn btn-primary btn-lg px-4 rounded-pill">
                            <i class="bi bi-list-ul me-2"></i>Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- How to Order Steps -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="bg-light rounded-4 p-5">
                    <h3 class="fw-bold text-center mb-4">Cara Pemesanan</h3>
                    <div class="row g-4">
                        <!-- Step 1 -->
                        <div class="col-lg-3 col-md-6 text-center">
                            <div class="step-number bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fw-bold fs-4">1</span>
                            </div>
                            <h5 class="fw-bold mb-2">Pilih Produk</h5>
                            <p class="text-muted small">Browse dan pilih produk yang Anda inginkan dari katalog</p>
                        </div>
                        
                        <!-- Step 2 -->
                        <div class="col-lg-3 col-md-6 text-center">
                            <div class="step-number bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fw-bold fs-4">2</span>
                            </div>
                            <h5 class="fw-bold mb-2">Isi Form</h5>
                            <p class="text-muted small">Lengkapi informasi pemesanan dan data pengiriman</p>
                        </div>
                        
                        <!-- Step 3 -->
                        <div class="col-lg-3 col-md-6 text-center">
                            <div class="step-number bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fw-bold fs-4">3</span>
                            </div>
                            <h5 class="fw-bold mb-2">Konfirmasi</h5>
                            <p class="text-muted small">Konfirmasi pesanan dan tunggu balasan dari penjual</p>
                        </div>
                        
                        <!-- Step 4 -->
                        <div class="col-lg-3 col-md-6 text-center">
                            <div class="step-number bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fw-bold fs-4">4</span>
                            </div>
                            <h5 class="fw-bold mb-2">Terima Produk</h5>
                            <p class="text-muted small">Produk akan dikirim sesuai alamat yang telah diberikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info for Orders -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="border rounded-4 p-4" style="background-color: #28a745; color: white;">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h4 class="fw-bold mb-2">Butuh bantuan dalam pemesanan?</h4>
                            <p class="mb-0">Tim customer service kami siap membantu Anda 24/7 untuk proses pemesanan</p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <button class="btn btn-light btn-lg px-4 rounded-pill">
                                <a href="https://wa.me/6282112345786" style="text-decoration: none; color:black;">
                                    <i class="bi bi-telephone me-2"></i>Hubungi Kami
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.order-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
}

.order-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    border-color: #28a745 !important;
}

.order-icon-wrapper {
    transition: all 0.3s ease;
}

.order-card:hover .order-icon-wrapper {
    transform: scale(1.1);
}

.step-number {
    transition: all 0.3s ease;
}

.step-number:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem !important;
    }
    
    .order-card:hover {
        transform: translateY(-5px);
    }
    
    .order-icon-wrapper {
        width: 80px !important;
        height: 80px !important;
    }
    
    .order-icon-wrapper i {
        font-size: 2.5rem !important;
    }
}
</style>