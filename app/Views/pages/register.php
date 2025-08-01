<h2 class="mb-4 text-center">Register</h2>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= base_url('/register') ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter full name" name="name" required />
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required />
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required />
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control" id="alamat" placeholder="Enter alamat" name="alamat" required />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Register</button>
    <div class="d-flex flex-column mt-3 text-center">
        <a href="<?= base_url('/login') ?>">Sudah punya akun? Login disini</a>
        <a href="<?= base_url('/') ?>">Kembali ke Beranda</a>
    </div>
</form>
