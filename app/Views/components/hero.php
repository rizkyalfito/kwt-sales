<section id="beranda" class="hero-section position-relative overflow-hidden my-5" style="border-radius:20px; padding: 40px; height: 70vh; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    
    <!-- Decorative Elements -->
    <div class="position-absolute top-0 end-0 opacity-10">
        <div class="bg-success rounded-circle" style="width: 200px; height: 200px; transform: translate(100px, -100px);"></div>
    </div>
    <div class="position-absolute bottom-0 start-0 opacity-5">
        <div class="bg-warning rounded-circle" style="width: 200px; height: 200px; transform: translate(-50px, 50px);"></div>
    </div>

    <div class="container h-100">
        <div class="row h-100 align-items-center">
            
            <!-- Main Content -->
            <div class="col-lg-6 col-md-8 mx-auto text-center position-relative z-3">
                <div class="hero-content">
                    <!-- Badge -->
                    <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-pill mb-4">
                        <i class="bi bi-leaf me-2"></i>Kelompok Wanita Tani
                    </span>
                    
                    <!-- Main Heading -->
                    <h1 class="display-6 fw-bold text-dark mb-2 lh-1">
                        Hasil Pertanian
                        <span class="text-success">Berkualitas</span>
                        Langsung dari Petani
                    </h1>
                    
                    <!-- Subtitle -->
                    <p class="display-8 lead text-muted mb-4 fs-5" style="max-width: 1000px; margin: 0 auto;">
                        Platform digital yang menghubungkan Kelompok Wanita Tani dengan konsumen untuk menyediakan produk pertanian segar, sehat, dan berkualitas tinggi
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">
                        <a href="#produk" class="btn btn-success btn-lg px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-basket3 me-2"></i>Jelajahi Produk
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- Bottom Wave -->
    <div class="position-absolute bottom-0 start-0 w-100">
        <svg viewBox="0 0 1200 120" style="height: 60px;" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L50 105C100 90 200 60 300 45C400 30 500 30 600 37.5C700 45 800 60 900 67.5C1000 75 1100 75 1150 75L1200 75V120H1150C1100 120 1000 120 900 120C800 120 700 120 600 120C500 120 400 120 300 120C200 120 100 120 50 120H0Z" fill="white" fill-opacity="0.1"/>
        </svg>
    </div>
    
</section>

<style>
.hero-section {
    position: relative;
}

.hero-content {
    animation: fadeInUp 1s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.feature-item {
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 60vh !important;
    }
    
    .display-3 {
        font-size: 2.5rem !important;
    }
}
</style>