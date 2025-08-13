<h2 class="mb-4 text-center">Reset Password</h2>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger mb-3" role="alert">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="<?= site_url('/reset-password') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="token" value="<?= esc($token) ?>">
    
    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" class="form-control" id="password" name="password" 
               placeholder="Masukkan password baru" minlength="6" required>
    </div>
    
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
               placeholder="Konfirmasi password baru" minlength="6" required>
    </div>
    
    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    
    <div class="d-flex flex-column mt-3 text-center">
        <a href="<?= site_url('/login') ?>">Kembali ke Login</a>
    </div>
</form>
