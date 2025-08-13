<section id="produk" class="py-5 bg-white mb-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-3">Data Produk</h2>
                <p class="lead text-muted">Berikut adalah daftar produk hasil pertanian yang tersedia :</p>
            </div>
            <div class="col-lg-4 d-flex align-items-end">
                <!-- Button untuk lihat semua produk -->
                <a href="<?= base_url('produk-public') ?>" class="btn btn-success btn-lg rounded-pill w-100">
                    <i class="bi bi-eye me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>

        <!-- Product Grid - Auto Rotating Display (3 produk) -->
        <?php if (!empty($produk) && count($produk) > 0): ?>
            <div class="row g-4" id="produkContainer">
                <!-- Initial products akan dimuat di sini -->
                <?php
                $produkModel = new \App\Models\ProdukModel();
                // Tampilkan 3 produk pertama sebagai default
                $initialProducts = array_slice($produk, 0, 3);
                foreach ($initialProducts as $item): 
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 product-card show">
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
                                         style="max-height: 180px; max-width: 180px; object-fit: cover;">
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
                                        <i class="text-success me-2"></i>
                                        <span class="fw-bold text-success fs-5">
                                            <?= $produkModel->formatRupiah($item['harga']) ?>
                                        </span>
                                        <span class="text-muted ms-1">
                                            /<?= strtoupper($item['satuan'] ?? 'kg') ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Stock Info -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-box-seam text-info me-2"></i>
                                        <span class="text-muted fs-6">
                                            <strong>Stok:</strong> <?= esc($item['stok']) ?> <?= strtoupper($item['satuan'] ?? 'kg') ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Product Detail -->
                                <?php if (!empty($item['detail'])): ?>
                                    <div class="mb-2">
                                        <p class="text-muted mb-0">
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
                            Saat ini belum ada produk yang tersedia di sistem.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- JavaScript Data -->
<script>
// Data produk untuk JavaScript dengan path gambar yang sudah diproses
window.produkData = <?php 
if (!empty($produk)) {
    $produkModel = new \App\Models\ProdukModel();
    $processedProduk = [];
    
    foreach ($produk as $item) {
        $processedItem = $item;
        
        // Process image path
        if (!empty($item['gambar'])) {
            $imagePaths = [
                WRITEPATH . '../public/uploads/produk/' . $item['gambar'],
                WRITEPATH . '../public/assets/image/product/' . $item['gambar']
            ];
            
            $processedItem['image_url'] = '';
            foreach ($imagePaths as $path) {
                if (file_exists($path)) {
                    if (strpos($path, 'uploads/produk') !== false) {
                        $processedItem['image_url'] = base_url('uploads/produk/' . $item['gambar']);
                    } else {
                        $processedItem['image_url'] = base_url('assets/image/product/' . $item['gambar']);
                    }
                    break;
                }
            }
        }
        
        $processedProduk[] = $processedItem;
    }
    
    echo json_encode($processedProduk);
} else {
    echo json_encode([]);
}
?>;
</script>

<style>
.product-card {
    transition: all 0.5s ease;
    border-radius: 15px;
    overflow: hidden;
    opacity: 0;
    transform: translateY(20px);
}

.product-card.show {
    opacity: 1;
    transform: translateY(0);
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
}

.placeholder-img {
    transition: all 0.3s ease;
    border: 2px dashed rgba(108, 117, 125, 0.3);
}

.product-card:hover .placeholder-img {
    transform: scale(1.05);
    border-color: rgba(108, 117, 125, 0.5);
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
    border-width: 1px !important;
}

.btn-outline-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
}

/* Navigation dots styling */
.nav-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #dee2e6;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.nav-dot.active {
    background-color: #28a745;
    transform: scale(1.3);
}

.nav-dot:hover {
    background-color: #6c757d;
    transform: scale(1.1);
}

/* Fade animation */
.fade-out {
    opacity: 0;
    transform: translateY(10px);
}

.fade-in {
    opacity: 1;
    transform: translateY(0);
}

/* Styling untuk no products state */
.bi-basket {
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
}

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
    
    .nav-dot {
        width: 10px;
        height: 10px;
    }
}
</style>

<script>
// Auto Rotate Products with Sliding Window
document.addEventListener('DOMContentLoaded', function() {
    const produkData = window.produkData || [];
    const container = document.getElementById('produkContainer');
    
    if (produkData.length <= 3) {
        return; // Tidak perlu rotate jika produk <= 3
    }
    
    let currentStartIndex = 0; // Index awal dari 3 item yang ditampilkan
    const itemsPerPage = 3;
    let autoRotateInterval = null;
    let isAnimating = false;
    
    // Format rupiah function
    function formatRupiah(harga) {
        return 'Rp ' + parseInt(harga).toLocaleString('id-ID');
    }
    
    // Get badge color function
    function getBadgeColor(kategori) {
        const colors = {
            'sayur': 'success',
            'buah': 'success', 
            'bumbu': 'success',
        };
        return colors[kategori.toLowerCase()] || 'secondary';
    }
    
    // Create product card HTML
    function createProductCard(item) {
        const isVegetable = item.nama_kategori.toLowerCase().includes('sayur');
        const unit = isVegetable ? 'ikat' : 'kg';
        const badgeColor = getBadgeColor(item.nama_kategori);
        
        // Build image HTML dengan path yang sudah diproses dari PHP
        let imageHtml = '';
        if (item.image_url) {
            imageHtml = `
                <img src="${item.image_url}" 
                     alt="${item.nama_produk}" 
                     class="img-fluid rounded product-image" 
                     style="max-height: 180px; max-width: 180px; object-fit: cover;"
                     onerror="this.parentElement.innerHTML='<div class=\\'placeholder-img bg-opacity-10 rounded d-flex align-items-center justify-content-center\\' style=\\'width: 180px; height: 180px;\\'><div class=\\'text-center\\'><i class=\\'bi bi-image text-secondary fs-1 mb-2\\'></i><div class=\\'text-secondary small\\'>Tidak ada gambar</div></div></div>'">
            `;
        } else {
            imageHtml = `
                <div class="placeholder-img bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="width: 180px; height: 180px;">
                    <div class="text-center">
                        <i class="bi bi-image text-secondary fs-1 mb-2"></i>
                        <div class="text-secondary small">Tidak ada gambar</div>
                    </div>
                </div>
            `;
        }
        
        return `
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        ${imageHtml}
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <!-- Product Name -->
                        <div class="align-top">
                            <h5 class="card-title fw-bold mb-1 mr-2">${item.nama_produk}</h5>
                            <div class="mb-1 align-top">
                                <span class="badge bg-${badgeColor} bg-opacity-10 text-${badgeColor} rounded-pill px-3 py-2 border border-${badgeColor} align-top">
                                    <i class="bi bi-tag-fill me-1 align-top"></i>${item.nama_kategori}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Price Info -->
                        <div class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class=" text-success me-2"></i>
                                <span class="fw-bold text-success fs-5">
                                    ${formatRupiah(item.harga)}
                                </span>
                                <span class="text-muted ms-1">/${unit}</span>
                            </div>
                        </div>
                        
                        <!-- Stock Info -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-box-seam text-info me-2"></i>
                                <span class="text-muted fs-6">
                                    <strong>Stok:</strong> ${item.stok} ${unit}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Product Detail -->
                        ${item.detail ? `
                            <div class="mb-2">
                                <p class="text-muted mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    ${item.detail}
                                </p>
                            </div>
                        ` : ''}
                        
                        <!-- Order Button -->
                        <div class="mt-auto">
                            ${item.stok > 0 ? `
                                <button class="btn btn-outline-success w-100 rounded-pill" onclick="pesanProduk(${item.id})">
                                    <i class="bi bi-cart-plus me-2"></i>Pesan sekarang
                                </button>
                            ` : `
                                <button class="btn btn-outline-secondary w-100 rounded-pill" disabled>
                                    <i class="bi bi-x-circle me-2"></i>Stok Habis
                                </button>
                            `}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Display products dengan sliding window (selalu 3 item)
    function displayProducts(startIndex) {
        if (isAnimating) return;
        
        isAnimating = true;
        currentStartIndex = startIndex;
        
        // Get 3 consecutive products with wrapping
        const currentProducts = [];
        for (let i = 0; i < itemsPerPage; i++) {
            const index = (startIndex + i) % produkData.length;
            currentProducts.push(produkData[index]);
        }
        
        // Fade out current products
        const cards = container.querySelectorAll('.product-card');
        cards.forEach(card => {
            card.classList.add('fade-out');
            card.classList.remove('show');
        });
        
        setTimeout(() => {
            // Clear and add new products
            container.innerHTML = '';
            currentProducts.forEach((item, index) => {
                container.innerHTML += createProductCard(item);
            });
            
            // Animate new cards
            setTimeout(() => {
                const newCards = container.querySelectorAll('.product-card');
                newCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('show');
                    }, index * 100);
                });
                
                isAnimating = false;
            }, 50);
            
        }, 300);
    }
    
    // Next slide (geser 1 item)
    function nextSlide() {
        const nextIndex = (currentStartIndex + 1) % produkData.length;
        displayProducts(nextIndex);
    }
    
    // Auto rotate functions
    function startAutoRotate() {
        stopAutoRotate();
        autoRotateInterval = setInterval(() => {
            nextSlide(); // Geser 1 item setiap 10 detik
        }, 10000); // 10 seconds
    }
    
    function stopAutoRotate() {
        if (autoRotateInterval) {
            clearInterval(autoRotateInterval);
            autoRotateInterval = null;
        }
    }
    
    function resetAutoRotate() {
        startAutoRotate();
    }
    
    // Pause on hover
    container.addEventListener('mouseenter', stopAutoRotate);
    container.addEventListener('mouseleave', startAutoRotate);
    
    // Start auto rotate
    startAutoRotate();
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', stopAutoRotate);
});

// Function untuk pesan produk
function pesanProduk(productId) {
    // Tampilkan loading state
    const btn = event.target;
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';
    btn.disabled = true;
    
    // Redirect ke halaman pemesanan dengan parameter produk ID
    setTimeout(() => {
        window.location.href = `${window.location.origin}/pemesanan?produk=${productId}`;
    }, 500);
}
</script>