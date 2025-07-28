<h2 class="mb-4 text-center">Login</h2>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= base_url('login') ?>">
    <div class="mb-3">
        <label for="email" class="form-label">Username</label>
        <input type="text" class="form-control" id="email" placeholder="Enter username" name="username" />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" />
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
    <div class="mt-3 text-center">
        <a href="<?= base_url('/register') ?>">Don't have an account? Register here</a>
    </div>
</form>
