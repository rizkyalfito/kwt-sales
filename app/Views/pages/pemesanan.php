<section id="pemesanan" class="py-5 bg-light">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-dark mb-2">Form Pemesanan</h2>
                <p class="text-muted">Silakan isi form pemesanan produk pertanian segar</p>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <form action="<?= base_url('/pemesanan/submit') ?>" method="POST">
                            <?= csrf_field() ?>
                            
                            <!-- Pilih Produk -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Produk</label>
                                <select class="form-select" id="productSelect" name="product" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php if (!empty($produkByKategori)): ?>
                                        <?php foreach ($produkByKategori as $kategori => $produkList): ?>
                                            <optgroup label="<?= esc(ucfirst($kategori)) ?>">
                                                <?php foreach ($produkList as $produk): ?>
                                                    <?php 
                                                    $unit = strtoupper($produk['satuan']);
                                                    $isSelected = (isset($selectedProductId) && $selectedProductId == $produk['id']) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?= $produk['id'] ?>" 
                                                            data-price="<?= $produk['harga'] ?>" 
                                                            data-unit="<?= $unit ?>" 
                                                            data-stock="<?= $produk['stok'] ?>"
                                                            <?= $isSelected ?>>
                                                        <?= esc($produk['nama_produk']) ?> - Rp <?= number_format($produk['harga'], 0, ',', '.') ?>/<?= $unit ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Info Produk -->
                            <div id="productInfo" class="mb-3 p-3 bg-light rounded" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted">Harga Satuan:</small><br>
                                        <span class="fw-bold text-success" id="priceDisplay">-</span>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Stok:</small><br>
                                        <span class="fw-bold text-primary" id="stockDisplay">-</span>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Total Harga:</small><br>
                                        <span class="fw-bold text-dark" id="totalPrice">Rp 0</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Jumlah -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseBtn">-</button>
                                    <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" required>
                                    <button class="btn btn-outline-secondary" type="button" id="increaseBtn">+</button>
                                    <span class="input-group-text" id="unitDisplay">unit</span>
                                </div>
                            </div>

                            <!-- Data Pemesan -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Pemesan</label>
                                <input type="text" class="form-control" value="<?= esc($userNama ?? '') ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required><?= old('alamat', $userAlamat ?? '') ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="nomor_telepon" placeholder="08xxxxxxxxxx" value="<?= old('nomor_telepon') ?>" required>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="cod" value="cod" checked>
                                            <label class="form-check-label" for="cod">
                                                <i class="fas fa-money-bill-wave"></i> COD (Bayar di Tempat)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="transfer" value="transfer">
                                            <label class="form-check-label" for="transfer">
                                                <i class="fas fa-credit-card"></i> Transfer Bank
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Bukti Pembayaran (untuk transfer) -->
                            <div class="mb-4" id="uploadSection" style="display: none;">
                                <label class="form-label fw-bold">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*,.pdf">
                                <small class="text-muted">Format: JPG, PNG, PDF (max 2MB)</small>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg" id="submitBtn" disabled>
                                    Kirim Pesanan
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
    .form-control:focus:invalid,
    .form-select:focus:invalid,
    input:focus:invalid,
    select:focus:invalid,
    textarea:focus:invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
    }
    
    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
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
    const submitBtn = document.getElementById('submitBtn');

    let currentPrice = 0;
    let currentUnit = '';
    let currentStock = 0;

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
            submitBtn.disabled = false;
            updateTotal();
        } else {
            productInfo.style.display = 'none';
            submitBtn.disabled = true;
            currentPrice = 0;
            currentUnit = '';
            currentStock = 0;
        }
    });

    // Quantity controls
    decreaseBtn.addEventListener('click', function() {
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            updateTotal();
        }
    });

    increaseBtn.addEventListener('click', function() {
        if (parseInt(quantityInput.value) < currentStock) {
            quantityInput.value = parseInt(quantityInput.value) + 1;
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

    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }

    // Form validation for empty inputs
    const form = document.querySelector('form');
    const requiredInputs = form.querySelectorAll('[required]');
    
    function validateInput(input) {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            input.style.borderColor = '#dc3545';
            return false;
        } else {
            input.classList.remove('is-invalid');
            input.style.borderColor = '';
            return true;
        }
    }
    
    function validateAllInputs() {
        let isValid = true;
        requiredInputs.forEach(input => {
            if (!validateInput(input)) {
                isValid = false;
            }
        });
        return isValid;
    }
    
    // Real-time validation on blur
    requiredInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(this);
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                validateInput(this);
            }
        });
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateAllInputs()) {
            e.preventDefault();
            // Focus on first invalid input
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
            }
        }
    });
    
    // Also validate on form attempt
    submitBtn.addEventListener('click', function(e) {
        if (!validateAllInputs()) {
            e.preventDefault();
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
            }
        }
    });
});
</script>
