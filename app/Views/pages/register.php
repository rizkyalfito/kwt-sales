<h2 class="mb-4 text-center">Register</h2>
<form>
    <div class="mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="full_name" placeholder="Enter full name" />
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" />
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm password" />
    </div>
    <button type="submit" class="btn btn-primary w-100">Register</button>
    <div class="mt-3 text-center">
        <a href="<?= base_url('/login') ?>">Already have an account? Login here</a>
    </div>
</form>
