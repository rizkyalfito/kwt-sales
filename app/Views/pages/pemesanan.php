<section id="pemesanan" class="py-5 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold text-dark mb-3">Pesan Sekarang</h2>
                <p class="lead text-muted">Silakan isi form pemesanan di bawah ini untuk memesan produk hasil pertanian segar</p>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Order Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <form id="orderForm" action="<?= base_url('/pemesanan/submit') ?>" method="POST">
                            <?= csrf_field() ?>
                            
                            <!-- Product Selection -->
                            <div class="mb-4">
                                <label for="productSelect" class="form-label fw-bold text-dark mb-3">
                                    <i class="bi bi-basket me-2 text-success"></i>Pilih Produk
                                </label>
                                <div class="position-relative">
                                    <select class="form-select form-select-lg border-2 rounded-3" id="productSelect" name="product" required>
                                        <option value="">Pilih nama produk</option>
                                        
                                        <!-- Generate options from database -->
                                        <?php if (!empty($produkByKategori)): ?>
                                            <?php foreach ($produkByKategori as $kategori => $produkList): ?>
                                                <optgroup label="<?= esc(ucfirst($kategori)) ?>">
                                                    <?php foreach ($produkList as $produk): ?>
                                                        <?php 
                                                        $unit = (stripos($produk['nama_kategori'], 'sayur') !== false) ? 'ikat' : 'kg';
                                                        $isSelected = (isset($selectedProductId) && $selectedProductId == $produk['id']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $produk['id'] ?>" 
                                                                data-price="<?= $produk['harga'] ?>" 
                                                                data-unit="<?= $unit ?>" 
                                                                data-stock="<?= $produk['stok'] ?>"
                                                                data-name="<?= esc($produk['nama_produk']) ?>"
                                                                <?= $isSelected ?>>
                                                            <?= esc($produk['nama_produk']) ?> - Rp <?= number_format($produk['harga'], 0, ',', '.') ?>/<?= $unit ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </optgroup>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                
                                <!-- Product Info Display -->
                                <div id="productInfo" class="mt-3 p-3 bg-light rounded-3" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Harga Satuan</small>
                                            <span class="fw-bold text-success" id="priceDisplay">-</span>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Stok Tersedia</small>
                                            <span class="fw-bold text-primary" id="stockDisplay">-</span>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Total Harga</small>
                                            <span class="fw-bold text-dark fs-5" id="totalPrice">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="mb-4">
                                <label for="quantity" class="form-label fw-bold text-dark mb-3">
                                    <i class="bi bi-plus-circle me-2 text-success"></i>Jumlah
                                </label>
                                <div class="input-group input-group-lg">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseBtn">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control text-center border-2" id="quantity" name="quantity" value="<?= old('quantity', 1) ?>" min="1" required>
                                    <button class="btn btn-outline-secondary" type="button" id="increaseBtn">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <span class="input-group-text bg-light border-2" id="unitDisplay">unit</span>
                                </div>
                            </div>

                            <!-- Customer Information from Session -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="bi bi-person-check me-2 text-success"></i>Informasi Pemesan
                                </h6>
                                <div class="bg-light p-3 rounded-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Nama Pemesan</small>
                                            <span class="fw-bold"><?= esc($userNama ?? 'User') ?></span>
                                        </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Alamat Lengkap</small>
                                    <textarea class="form-control" name="alamat" rows="3" required><?= esc($userAlamat ?? '') ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Nomor Telepon</small>
                                    <input type="text" class="form-control" name="nomor_telepon" placeholder="Masukkan nomor telepon" required>
                                </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Data diambil dari profil akun Anda. Untuk mengubah, silakan edit profil.
                                    </small>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <label for="notes" class="form-label fw-bold text-dark mb-3">
                                    <i class="bi bi-chat-dots me-2 text-success"></i>Catatan Tambahan
                                </label>
                                <textarea class="form-control border-2 rounded-3" id="notes" name="notes" rows="3" placeholder="Catatan khusus untuk pesanan Anda (opsional)"><?= old('notes') ?></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill py-3">
                                    <i class="bi bi-send me-2"></i>Kirim Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-control:focus, .form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.form-control, .form-select {
    transition: all 0.3s ease;
}

.form-control:hover, .form-select:hover {
    border-color: #198754;
}

.btn-outline-secondary {
    border-color: #dee2e6;
}

.btn-outline-secondary:hover {
    background-color: #198754;
    border-color: #198754;
    color: white;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('productSelect');
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');
    const productInfo = document.getElementById('productInfo');
    const priceDisplay = document.getElementById('priceDisplay');
    const stockDisplay = document.getElementById('stockDisplay');
    const totalPrice = document.getElementById('totalPrice');
    const unitDisplay = document.getElementById('unitDisplay');

    let currentPrice = 0;
    let currentUnit = '';
    let currentStock = 0;

    // Product selection change
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            currentPrice = parseInt(selectedOption.dataset.price);
            currentUnit = selectedOption.dataset.unit;
            currentStock = parseInt(selectedOption.dataset.stock);
            
            priceDisplay.textContent = `Rp ${currentPrice.toLocaleString('id-ID')}/${currentUnit}`;
            stockDisplay.textContent = `${currentStock} ${currentUnit}`;
            unitDisplay.textContent = currentUnit;
            
            quantityInput.max = currentStock;
            quantityInput.value = 1;
            
            productInfo.style.display = 'block';
            updateTotal();
        } else {
            productInfo.style.display = 'none';
            currentPrice = 0;
            currentUnit = '';
            currentStock = 0;
        }
    });

    // Quantity controls
    decreaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
        }
    });

    increaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < currentStock) {
            quantityInput.value = currentValue + 1;
            updateTotal();
        }
    });

    quantityInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        if (value > currentStock) {
            this.value = currentStock;
        } else if (value < 1) {
            this.value = 1;
        }
        updateTotal();
    });

    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const total = currentPrice * quantity;
        totalPrice.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    // Trigger change event on page load if product is pre-selected
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }
});
</script>