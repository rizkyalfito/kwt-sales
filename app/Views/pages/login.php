<h2 class="mb-4 text-center">Login</h2>
<form>
    <div class="mb-3">
        <label for="email" class="form-label">Username or Email</label>
        <input type="text" class="form-control" id="email" placeholder="Enter username or email" />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" />
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" />
        <label class="form-check-label" for="remember">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
    <div class="mt-3 text-center">
        <a href="<?= base_url('/register') ?>">Don't have an account? Register here</a>
    </div>
</form>
