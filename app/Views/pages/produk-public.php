<section id="produk" class="py-5 bg-white mb-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold text-dark mb-3">Data Produk</h2>
                <p class="lead text-muted">Berikut adalah daftar produk hasil pertanian yang tersedia :</p>
            </div>
            <div class="col-lg-6">
                <!-- Search and Filter Form -->
                <form action="<?= base_url('produk-public/cari') ?>" method="GET" class="d-flex flex-column gap-3">
                    <!-- Search Input -->
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" 
                               placeholder="Cari nama produk..." 
                               value="<?= isset($keyword) ? esc($keyword) : '' ?>">
                        <!-- <button class="btn btn-outline-success" type="submit">
                            <i class="bi bi-search">Cari</i>
                        </button> -->
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="text-muted mb-0" style="min-width: 100px;">Pilih Kategori:</label>
                        <select name="kategori" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua kategori</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat['nama_kategori']) ?>" 
                                            <?= (isset($kategori) && $kategori == $cat['nama_kategori']) ? 'selected' : '' ?>>
                                        <?= esc($cat['nama_kategori']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Active Filter Display -->
        <?php if (!empty($kategori) || !empty($keyword)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2 align-items-start">
                        <span class="text-muted">Filter aktif:</span>
                        <?php if (!empty($kategori)): ?>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 border border-success">
                                Kategori: <?= esc($kategori) ?>
                                <a href="<?= base_url('produk-public' . (!empty($keyword) ? '?keyword=' . urlencode($keyword) : '')) ?>" 
                                   class="text-success ms-2 text-decoration-none fw-bold">×</a>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($keyword)): ?>
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 border border-info">
                                Pencarian: "<?= esc($keyword) ?>"
                                <a href="<?= base_url('produk-public' . (!empty($kategori) ? '?kategori=' . urlencode($kategori) : '')) ?>" 
                                   class="text-info ms-2 text-decoration-none fw-bold">×</a>
                            </span>
                        <?php endif; ?>
                        <a href="<?= base_url('produk-public') ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-circle me-1"></i>Hapus semua filter
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Product Grid -->
        <?php if (!empty($produk) && count($produk) > 0): ?>
            <div class="row g-4">
                <?php 
                $produkModel = new \App\Models\ProdukModel();
                foreach ($produk as $item): 
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 product-card">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <?php 
                                // Cek multiple path untuk gambar
                                $imagePaths = [
                                    WRITEPATH . '../public/uploads/produk/' . $item['gambar'],
                                    WRITEPATH . '../public/assets/image/product/' . $item['gambar']
                                ];
                                
                                $imageFound = false;
                                $imageUrl = '';
                                
                                if (!empty($item['gambar'])) {
                                    foreach ($imagePaths as $path) {
                                        if (file_exists($path)) {
                                            $imageFound = true;
                                            if (strpos($path, 'uploads/produk') !== false) {
                                                $imageUrl = base_url('uploads/produk/' . $item['gambar']);
                                            } else {
                                                $imageUrl = base_url('assets/image/product/' . $item['gambar']);
                                            }
                                            break;
                                        }
                                    }
                                }
                                ?>
                                
                                <?php if ($imageFound): ?>
                                    <img src="<?= $imageUrl ?>" 
                                         alt="<?= esc($item['nama_produk']) ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px; max-width: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="placeholder-img bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="width: 180px; height: 180px;">
                                        <div class="text-center">
                                            <i class="bi bi-image text-secondary fs-1 mb-2"></i>
                                            <div class="text-secondary small">Tidak ada gambar</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <!-- Product Name -->
                                 <div class="align-top">
                                 <h5 class="card-title fw-bold mb-1 mr-2"><?= esc($item['nama_produk']) ?></h5>
                                  <div class="mb-1 align-top">
                                      <?php $badgeColor = $produkModel->getBadgeColor($item['nama_kategori']); ?>
                                      <span class="badge bg-<?= $badgeColor ?> bg-opacity-10 text-<?= $badgeColor ?> rounded-pill px-3 py-2 border border-<?= $badgeColor ?> align-top">
                                          <i class="bi bi-tag-fill me-1 align-top"></i><?= esc(ucfirst($item['nama_kategori'])) ?>
                                      </span>
                                  </div>
                                 </div>
                                <!-- Price Info -->
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class=" text-success me-2"></i>
                                        <span class="fw-bold text-success fs-5">
                                            <?= $produkModel->formatRupiah($item['harga']) ?>
                                        </span>
                                        <span class="text-muted ms-1">
                                            /<?= $item['satuan'] ?? 'kg' ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Stock Info -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-box-seam text-info me-2"></i>
                                        <span class="text-muted fs-6">
                                            <strong>Stok:</strong> <?= esc($item['stok']) ?>
                                            <?= $item['satuan'] ?? 'kg' ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Product Detail -->
                                <?php if (!empty($item['detail'])): ?>
                                    <div class="mb-2">
                                        <p class="text-muted  mb-0">
                                            <i class="bi bi-info-circle me-1"></i>
                                            <?= esc($item['detail']) ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Order Button -->
                                <div class="mt-auto">
                                  <?php if ($item['stok'] > 0): ?>
                                      <button class="btn btn-outline-success w-100 rounded-pill" onclick="pesanProduk(<?= $item['id'] ?>)">
                                          <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                                      </button>
                                  <?php else: ?>
                                      <button class="btn btn-outline-secondary w-100 rounded-pill" disabled>
                                          <i class="bi bi-x-circle me-2"></i>Stok Habis
                                      </button>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Load More Button (jika diperlukan untuk pagination)
            <div class="text-center mt-5">
                <button class="btn btn-outline-success btn-lg px-5 rounded-pill" onclick="loadMoreProducts()">
                    <i class="bi bi-arrow-clockwise me-2"></i>Muat Produk Lainnya
                </button>
            </div> -->
        <?php else: ?>
            <!-- No Products Found -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-basket text-muted" style="font-size: 5rem; opacity: 0.5;"></i>
                        </div>
                        <h4 class="text-muted mb-3">Tidak Ada Produk Tersedia</h4>
                        <p class="text-muted mb-4">
                            <?php if (!empty($kategori) && !empty($keyword)): ?>
                                Maaf, tidak ada produk dalam kategori "<strong><?= esc($kategori) ?></strong>" dengan kata kunci "<strong><?= esc($keyword) ?></strong>".
                            <?php elseif (!empty($kategori)): ?>
                                Maaf, tidak ada produk dalam kategori "<strong><?= esc($kategori) ?></strong>".
                            <?php elseif (!empty($keyword)): ?>
                                Maaf, tidak ada produk yang sesuai dengan pencarian "<strong><?= esc($keyword) ?></strong>".
                            <?php else: ?>
                                Saat ini belum ada produk yang tersedia di sistem.
                            <?php endif; ?>
                        </p>
                        
                        <?php if (!empty($kategori) || !empty($keyword)): ?>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <a href="<?= base_url('produk-public') ?>" class="btn btn-success rounded-pill px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Lihat Semua Produk
                                </a>
                                <?php if (!empty($kategori) && !empty($keyword)): ?>
                                    <a href="<?= base_url('produk-public?kategori=' . urlencode($kategori)) ?>" class="btn btn-outline-info rounded-pill px-4">
                                        <i class="bi bi-funnel me-2"></i>Hanya Kategori <?= esc($kategori) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.product-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.08) !important;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    border-color: rgba(40, 167, 69, 0.3) !important;
}

.placeholder-img {
    transition: all 0.3s ease;
    border: 2px dashed rgba(108, 117, 125, 0.3);
}

.product-card:hover .placeholder-img {
    transform: scale(1.02);
    border-color: rgba(108, 117, 125, 0.5);
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
    border-width: 1px !important;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
}

.btn-outline-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

/* Styling untuk no products state */
.bi-basket {
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
}

/* Styling untuk active filter */
.badge a {
    font-weight: bold;
    font-size: 1.2em;
    transition: opacity 0.2s ease;
}

.badge a:hover {
    opacity: 0.7;
}

/* Card body spacing improvements */
.card-body {
    padding: 1.5rem;
}

.card-body > div:not(:last-child) {
    margin-bottom: 0.75rem;
}

/* Search form styling */
.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* Responsive design */
@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem !important;
    }
    
    .product-card:hover {
        transform: translateY(-4px);
    }
    
    .bi-basket {
        font-size: 3rem !important;
    }
    
    .col-lg-6 .form-control,
    .col-lg-6 .form-select {
        font-size: 16px; /* Prevent zoom on iOS */
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .badge {
        font-size: 0.7rem;
    }
}



@media (max-width: 576px) {
    .d-flex.gap-2.flex-wrap {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .input-group {
        margin-bottom: 1rem;
    }
}

/* Loading animation for form submission */
.form-loading {
    opacity: 0.7;
    pointer-events: none;
}

.btn-loading {
    position: relative;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    margin: auto;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
// Function untuk pesan produk
function pesanProduk(productId) {
    // Tampilkan loading state
    const btn = event.target;
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';
    btn.disabled = true;
    
    // Redirect ke halaman pemesanan dengan parameter produk ID
    setTimeout(() => {
        window.location.href = '<?= base_url() ?>pemesanan?produk=' + productId;
    }, 500);
}

// Function untuk load more products (pagination)
function loadMoreProducts() {
    const btn = event.target;
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memuat...';
    btn.disabled = true;
    
    setTimeout(() => {
        alert('Fitur load more akan segera tersedia!');
        btn.innerHTML = originalContent;
        btn.disabled = false;
    }, 1000);
}

// Auto submit form ketika kategori berubah dan form enhancements
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Tambahkan loading state saat form submit
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const searchInput = form.querySelector('input[name="keyword"]');
            
            // Jangan submit jika search kosong dan tidak ada kategori
            const kategoriSelect = form.querySelector('select[name="kategori"]');
            if (searchInput && !searchInput.value.trim() && (!kategoriSelect || !kategoriSelect.value)) {
                e.preventDefault();
                searchInput.focus();
                return;
            }
            
            // Loading state
            if (submitBtn) {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                submitBtn.disabled = true;
                
                // Reset setelah 5 detik jika belum redirect
                setTimeout(function() {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 5000);
            }
            
            // Loading state untuk form
            form.classList.add('form-loading');
        });
        
        // Enter key untuk search
        const searchInput = form.querySelector('input[name="keyword"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    form.submit();
                }
            });
            
            // Clear search dengan Escape
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    this.blur();
                }
            });
        }
    });
    
    // Smooth scroll untuk hasil pencarian
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('keyword') || urlParams.get('kategori')) {
        setTimeout(() => {
            const produkSection = document.getElementById('produk');
            if (produkSection) {
                produkSection.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }
        }, 300);
    }
    
    // Auto focus pada search input jika ada parameter pencarian
    if (urlParams.get('keyword')) {
        const searchInput = document.querySelector('input[name="keyword"]');
        if (searchInput) {
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        }
    }
});

// Debounce function untuk search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Live search (optional - uncomment untuk aktifkan)

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="keyword"]');
    if (searchInput) {
        const debouncedSearch = debounce(function() {
            if (searchInput.value.length >= 3 || searchInput.value.length === 0) {
                searchInput.closest('form').submit();
            }
        }, 500);
        
        searchInput.addEventListener('input', debouncedSearch);
    }
});
</script>