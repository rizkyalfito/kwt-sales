<h2 class="mb-4 text-center">Lupa Password</h2>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mb-3" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= base_url('forgot-password') ?>">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda" name="email" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>
    <div class="d-flex flex-column mt-3 text-center">
        <a href="<?= base_url('/login') ?>">Kembali ke Login</a>
        <a href="<?= base_url('/') ?>">Kembali ke Beranda</a>
    </div>
</form>
