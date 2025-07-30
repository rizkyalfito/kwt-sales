<section id="pemesanan" class="py-5 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold text-dark mb-3">Pesan Sekarang</h2>
                <p class="lead text-muted">Silakan isi form pemesanan di bawah ini untuk memesan produk hasil pertanian segar</p>
            </div>
        </div>

        <!-- Order Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <form id="orderForm">
                            <!-- Product Selection -->
                            <div class="mb-4">
                                <label for="productSelect" class="form-label fw-bold text-dark mb-3">
                                    <i class="bi bi-basket me-2 text-success"></i>Pilih Produk
                                </label>
                                <div class="position-relative">
                                    <select class="form-select form-select-lg border-2 rounded-3" id="productSelect" required>
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
                                                        <option value="<?= $produk['nama_produk'] ?>" 
                                                                data-id="<?= $produk['id'] ?>"
                                                                data-price="<?= $produk['harga'] ?>" 
                                                                data-unit="<?= $unit ?>" 
                                                                data-stock="<?= $produk['stok'] ?>"
                                                                <?= $isSelected ?>>
                                                            <?= esc($produk['nama_produk']) ?> - Rp <?= number_format($produk['harga'], 0, ',', '.') ?>/<?= $unit ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </optgroup>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <!-- Fallback static options -->
                                            <optgroup label="Sayuran">
                                                <option value="kangkung" data-price="4000" data-unit="ikat" data-stock="20">Kangkung - Rp 4.000/ikat</option>
                                                <option value="bayam" data-price="5000" data-unit="ikat" data-stock="20">Bayam - Rp 5.000/ikat</option>
                                                <option value="terong" data-price="6000" data-unit="kg" data-stock="12">Terong - Rp 6.000/kg</option>
                                            </optgroup>
                                            <optgroup label="Buah-buahan">
                                                <option value="tomat" data-price="8000" data-unit="kg" data-stock="15">Tomat - Rp 8.000/kg</option>
                                                <option value="cabai" data-price="20000" data-unit="kg" data-stock="10">Cabai - Rp 20.000/kg</option>
                                            </optgroup>
                                            <optgroup label="Bumbu">
                                                <option value="bawang-merah" data-price="25000" data-unit="kg" data-stock="8">Bawang Merah - Rp 25.000/kg</option>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                    <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                        <i class="bi bi-chevron-down text-muted"></i>
                                    </div>
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
                                    <input type="number" class="form-control text-center border-2" id="quantity" value="1" min="1" required>
                                    <button class="btn btn-outline-secondary" type="button" id="increaseBtn">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <span class="input-group-text bg-light border-2" id="unitDisplay">unit</span>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="row g-4 mb-4">
                                <div class="col-12">
                                    <label for="address" class="form-label fw-bold text-dark mb-3">
                                        <i class="bi bi-geo-alt me-2 text-success"></i>Alamat Lengkap
                                    </label>
                                    <textarea class="form-control border-2 rounded-3" id="address" rows="3" placeholder="Masukkan alamat lengkap untuk pengiriman" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-bold text-dark mb-3">
                                        <i class="bi bi-telephone me-2 text-success"></i>Nomor Telepon
                                    </label>
                                    <input type="tel" class="form-control form-control-lg border-2 rounded-3" id="phone" placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold text-dark mb-3">
                                        <i class="bi bi-person me-2 text-success"></i>Nama Lengkap
                                    </label>
                                    <input type="text" class="form-control form-control-lg border-2 rounded-3" id="name" placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <label for="notes" class="form-label fw-bold text-dark mb-3">
                                    <i class="bi bi-chat-dots me-2 text-success"></i>Catatan Tambahan
                                </label>
                                <textarea class="form-control border-2 rounded-3" id="notes" rows="3" placeholder="Catatan khusus untuk pesanan Anda (opsional)"></textarea>
                            </div>

                            <!-- Admin Contact -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="adminContact" checked>
                                <label class="form-check-label text-muted" for="adminContact">
                                    Saya setuju dihubungi oleh admin untuk proses selanjutnya
                                </label>
                            </div>

                            <!-- Order Summary -->
                            <div class="bg-success-subtle p-4 rounded-3 mb-4" id="orderSummary" style="display: none;">
                                <h6 class="fw-bold text-success mb-3">
                                    <i class="bi bi-check-circle me-2"></i>Ringkasan Pesanan
                                </h6>
                                <div class="row g-2">
                                    <div class="col-6"><span class="text-muted">Produk:</span></div>
                                    <div class="col-6"><span id="summaryProduct">-</span></div>
                                    <div class="col-6"><span class="text-muted">Jumlah:</span></div>
                                    <div class="col-6"><span id="summaryQuantity">-</span></div>
                                    <div class="col-6"><span class="text-muted">Total Harga:</span></div>
                                    <div class="col-6"><span class="fw-bold text-success" id="summaryTotal">Rp 0</span></div>
                                </div>
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

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem !important;
    }
    
    .card-body {
        padding: 2rem !important;
    }
}

/* Selected product highlight */
.form-select option:checked {
    background-color: #198754;
    color: white;
}

/* Custom animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

#productInfo, #orderSummary {
    animation: fadeIn 0.3s ease-in-out;
}

/* Auto-selected product notification */
.auto-selected-notification {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 1px solid #badbcc;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 16px;
    animation: slideDown 0.5s ease-out;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
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
    const orderSummary = document.getElementById('orderSummary');
    const summaryProduct = document.getElementById('summaryProduct');
    const summaryQuantity = document.getElementById('summaryQuantity');
    const summaryTotal = document.getElementById('summaryTotal');
    const orderForm = document.getElementById('orderForm');

    let currentPrice = 0;
    let currentUnit = '';
    let currentStock = 0;

    // Check if there's a pre-selected product from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const selectedProductId = urlParams.get('produk');
    
    if (selectedProductId) {
        // Find and select the product in dropdown
        const options = productSelect.querySelectorAll('option');
        for (let option of options) {
            if (option.dataset.id === selectedProductId) {
                option.selected = true;
                
                // Show notification about auto-selection
                showAutoSelectionNotification(option.textContent.split(' - ')[0]);
                
                // Trigger change event to populate product info
                productSelect.dispatchEvent(new Event('change'));
                break;
            }
        }
    }

    function showAutoSelectionNotification(productName) {
        const notification = document.createElement('div');
        notification.className = 'auto-selected-notification';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                <span class="fw-bold text-success">Produk "${productName}" telah dipilih</span>
            </div>
            <small class="text-muted d-block mt-1">Anda dapat mengubah pilihan produk jika diperlukan</small>
        `;
        
        // Insert notification before the product selection
        const productDiv = productSelect.closest('.mb-4');
        productDiv.parentNode.insertBefore(notification, productDiv);
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.style.transition = 'opacity 0.5s ease-out';
            notification.style.opacity = '0';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 500);
        }, 5000);
    }

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
            updateSummary();
        } else {
            productInfo.style.display = 'none';
            orderSummary.style.display = 'none';
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
            updateSummary();
        }
    });

    increaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < currentStock) {
            quantityInput.value = currentValue + 1;
            updateTotal();
            updateSummary();
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
        updateSummary();
    });

    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const total = currentPrice * quantity;
        totalPrice.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    function updateSummary() {
        if (productSelect.value && quantityInput.value) {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const quantity = parseInt(quantityInput.value);
            const total = currentPrice * quantity;
            
            summaryProduct.textContent = selectedOption.text.split(' - ')[0];
            summaryQuantity.textContent = `${quantity} ${currentUnit}`;
            summaryTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            
            orderSummary.style.display = 'block';
        }
    }

    // Form submission
    orderForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        const product = productSelect.value;
        const quantity = quantityInput.value;
        const address = document.getElementById('address').value;
        const phone = document.getElementById('phone').value;
        const name = document.getElementById('name').value;
        
        if (!product || !quantity || !address || !phone || !name) {
            alert('Mohon lengkapi semua field yang diperlukan!');
            return;
        }
        
        // Success message
        alert('Pesanan berhasil dikirim! Admin akan menghubungi Anda segera.');
        
        // Reset form
        orderForm.reset();
        productInfo.style.display = 'none';
        orderSummary.style.display = 'none';
        currentPrice = 0;
        currentUnit = '';
        currentStock = 0;
        
        // Remove URL parameters after successful submission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    });
});
</script>