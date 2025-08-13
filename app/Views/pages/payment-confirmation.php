<section id="payment-confirmation" class="py-5 bg-light">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-dark mb-2">Konfirmasi Pembayaran</h2>
                <p class="text-muted">Silakan lakukan pembayaran dan upload bukti transfer</p>
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

        <!-- Payment Info -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nomor Pesanan:</strong> #<?= $pesanan['pemesanan'] ?></p>
                                <p><strong>Produk:</strong> <?= esc($pesanan['nama_produk']) ?></p>
                                <p><strong>Jumlah:</strong> <?= $pesanan['jumlah'] ?> <?= strtoupper($pesanan['satuan']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Pembayaran:</strong></p>
                                <h4 class="text-primary">Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Transfer Info -->
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Transfer ke Rekening</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Bank:</strong> BRI</p>
                                <p><strong>Nomor Rekening:</strong> 5004-01-027459-53-8</p>
                                <p><strong>Atas Nama:</strong> KELOMPOK WANITA TANI</p>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                    <small>
                        <strong>Catatan:</strong><br>
                        - Pastikan jumlah transfer sesuai dengan total pembayaran<br>
                        - Simpan bukti transfer sebagai bukti pembayaran<br>
                        - Upload bukti transfer dalam format JPG, PNG, atau PDF
                    </small>
                </div>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Upload Bukti Transfer</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/payment/submit') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="order_id" value="<?= $pesanan['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Bukti Transfer <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*,.pdf" required>
                        <small class="text-muted">Format: JPG, PNG, PDF (max 2MB)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan Tambahan (Opsional)</label>
                        <textarea class="form-control" name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-upload"></i> Upload & Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
                </div>
            </div>
        </div>
    </div>
</section>
