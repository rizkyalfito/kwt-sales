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
                    <input type="text" id="searchCategory" class="form-control border-start-0" placeholder="Cari kategori...">
                </div>
            </div>
        </div>

        <!-- Category Grid -->
        <div class="row g-4 justify-content-center" id="categoryGrid">
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <div class="col-lg-4 col-md-6 category-item">
                        <div class="card h-100 shadow-sm border-0 category-card" onclick="viewProducts(<?= $category['id'] ?>)">
                            <div class="card-body text-center p-4">
                                <h4 class="fw-bold mb-3 text-success category-name"><?= esc($category['nama_kategori']) ?></h4>
                                <p class="text-muted mb-4">Produk berkualitas kategori <?= esc($category['nama_kategori']) ?></p>
                                
                                <button class="btn btn-outline-success w-100 rounded-pill">
                                    <i class="bi bi-arrow-right me-2"></i>Lihat Produk
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="row mt-4" id="noCategories">
                    <div class="col-12 text-center">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <i class="bi bi-basket mb-2 text-muted" style="font-size: 5rem; opacity: 0.5;"></i>
                            <p class="text-muted mb-4">
                            Belum ada Kategori yang tersedia.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- No Results Message -->
        <div class="row mt-4" id="noResults" style="display: none;">
            <div class="col-12 text-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-search mb-2 text-muted" style="font-size: 5rem; opacity: 0.5;"></i>
                    <p class="text-muted mb-4">
                    Tidak ada kategori yang sesuai dengan pencarian Anda.
                    </p>
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

.category-item {
    transition: opacity 0.3s ease;
}

.category-item.hidden {
    display: none;
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

<script>
// Search functionality
document.getElementById('searchCategory').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const categoryItems = document.querySelectorAll('.category-item');
    const noResults = document.getElementById('noResults');
    let visibleCount = 0;

    categoryItems.forEach(function(item) {
        const categoryName = item.querySelector('.category-name').textContent.toLowerCase();
        
        if (categoryName.includes(searchTerm)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Show/hide no results message
    if (visibleCount === 0 && searchTerm !== '') {
        noResults.style.display = 'block';
    } else {
        noResults.style.display = 'none';
    }
});

// Function to handle category click - Redirect ke halaman produk public
function viewProducts(categoryId) {
    // Redirect to products page with category filter
    window.location.href = '<?= base_url() ?>produk-public?kategori=' + categoryId;
}

// Add loading animation when category is clicked
document.querySelectorAll('.category-card').forEach(function(card) {
    card.addEventListener('click', function() {
        const button = this.querySelector('.btn');
        const originalText = button.innerHTML;
        
        button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memuat...';
        button.disabled = true;
        
        // Reset button after 3 seconds if page doesn't redirect
        setTimeout(function() {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 3000);
    });
});
</script>