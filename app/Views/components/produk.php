<section id="produk" class="py-5 bg-white mb-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-3">Data Produk</h2>
                <p class="lead text-muted">Berikut adalah daftar produk hasil pertanian yang tersedia :</p>
            </div>
            <div class="col-lg-4">
                <!-- Search and Filter Form -->
                <form action="<?= base_url('produk/cari') ?>" method="GET">
                    <div class="d-flex gap-2 flex-wrap">
                        <div class="flex-fill">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="keyword" class="form-control border-start-0" 
                                       placeholder="Cari produk..." value="<?= isset($keyword) ? esc($keyword) : '' ?>">
                            </div>
                        </div>
                        <select name="kategori" class="form-select" style="max-width: 150px;" onchange="this.form.submit()">
                            <option value="">Semua kategori</option>
                            <option value="Sayur" <?= (isset($kategori) && $kategori == 'Sayur') ? 'selected' : '' ?>>Sayur</option>
                            <option value="Buah" <?= (isset($kategori) && $kategori == 'Buah') ? 'selected' : '' ?>>Buah</option>
                            <option value="Bumbu" <?= (isset($kategori) && $kategori == 'Bumbu') ? 'selected' : '' ?>>Bumbu</option>
                        </select>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
                                <?php if (!empty($item['gambar']) && file_exists(WRITEPATH . '../public/uploads/produk/' . $item['gambar'])): ?>
                                    <img src="<?= base_url('uploads/produk/' . $item['gambar']) ?>" 
                                         alt="<?= esc($item['nama_produk']) ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 180px; max-width: 180px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="placeholder-img bg-secondary-subtle rounded" style="width: 150px; height: 150px; position: relative;">
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            <i class="bi bi-image text-secondary fs-1"></i>
                                        </div>
                                        <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" viewBox="0 0 150 150">
                                            <line x1="20" y1="20" x2="130" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                            <line x1="130" y1="20" x2="20" y2="130" stroke="#6c757d" stroke-width="1" opacity="0.3"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-2"><?= esc($item['nama_produk']) ?></h5>
                                <div class="mb-2">
                                    <?php $badgeColor = $produkModel->getBadgeColor($item['nama_kategori']); ?>
                                    <span class="badge bg-<?= $badgeColor ?>-subtle text-<?= $badgeColor ?> rounded-pill">
                                        <?= esc(strtolower($item['nama_kategori'])) ?>
                                    </span>
                                </div>
                                <p class="text-muted mb-2">
                                    <strong>Harga:</strong> <?= $produkModel->formatRupiah($item['harga']) ?>
                                    <?php if (stripos($item['nama_kategori'], 'sayur') !== false): ?>
                                        /ikat
                                    <?php else: ?>
                                        /kg
                                    <?php endif; ?>
                                </p>
                                <p class="text-muted mb-3">
                                    <strong>Stok:</strong> <?= esc($item['stok']) ?>
                                    <?php if (stripos($item['nama_kategori'], 'sayur') !== false): ?>
                                        ikat
                                    <?php else: ?>
                                        kg
                                    <?php endif; ?>
                                </p>
                                <?php if (!empty($item['detail'])): ?>
                                    <p class="text-muted small mb-3"><?= esc($item['detail']) ?></p>
                                <?php endif; ?>
                                
                                <?php if ($item['stok'] > 0): ?>
                                    <button class="btn btn-outline-success w-100 rounded-pill">
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
                <?php endforeach; ?>
            </div>

            <!-- Load More Button (jika diperlukan untuk pagination) -->
            <div class="text-center mt-5">
                <button class="btn btn-success btn-lg px-5 rounded-pill">
                    <i class="bi bi-arrow-clockwise me-2"></i>Muat Produk Lainnya
                </button>
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
                            <?php if (isset($keyword) || isset($kategori)): ?>
                                Maaf, tidak ada produk yang sesuai dengan pencarian Anda.
                            <?php else: ?>
                                Saat ini belum ada produk yang tersedia di sistem.
                            <?php endif; ?>
                        </p>
                        
                        <?php if (isset($keyword) || isset($kategori)): ?>
                            <a href="<?= base_url('produk') ?>" class="btn btn-outline-success rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i>Lihat Semua Produk
                            </a>
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

/* Styling untuk no products state */
.bi-basket {
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem !important;
    }
    
    .product-card:hover {
        transform: none;
    }
    
    .bi-basket {
        font-size: 3rem !important;
    }
}
</style>