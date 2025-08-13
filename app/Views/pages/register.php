<h2 class="mb-4 text-center">Register</h2>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('/register') ?>" enctype="multipart/form-data" id="registerForm">
    <?= csrf_field() ?>
    
    <div class="mb-3">
        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
        <input type="text" 
               class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" 
               id="name" 
               placeholder="Enter full name" 
               name="name" 
               value="<?= old('name') ?>"
               required />
        <?php if (session('errors.name')): ?>
            <div class="invalid-feedback"><?= session('errors.name') ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
        <input type="text" 
               class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
               id="username" 
               placeholder="Enter username" 
               name="username" 
               value="<?= old('username') ?>"
               required />
        <?php if (session('errors.username')): ?>
            <div class="invalid-feedback"><?= session('errors.username') ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
        <input type="email" 
               class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
               id="email" 
               placeholder="Enter email" 
               name="email" 
               value="<?= old('email') ?>"
               required />
        <?php if (session('errors.email')): ?>
            <div class="invalid-feedback"><?= session('errors.email') ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
        <textarea class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" 
                  id="alamat" 
                  placeholder="Enter alamat" 
                  name="alamat" 
                  rows="3"
                  required><?= old('alamat') ?></textarea>
        <?php if (session('errors.alamat')): ?>
            <div class="invalid-feedback"><?= session('errors.alamat') ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="password" 
                   class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                   id="password" 
                   placeholder="Enter password (min. 6 characters)" 
                   name="password" 
                   minlength="6"
                   required />
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
            <?php if (session('errors.password')): ?>
                <div class="invalid-feedback"><?= session('errors.password') ?></div>
            <?php endif; ?>
        </div>
        <small class="form-text text-muted">Password minimal 6 karakter</small>
    </div>

    <div class="mb-3">
        <label for="ktp_photo" class="form-label">Foto KTP <span class="text-danger">*</span></label>
        <input type="file" 
               class="form-control <?= session('errors.ktp_photo') ? 'is-invalid' : '' ?>" 
               id="ktp_photo" 
               name="ktp_photo" 
               accept="image/jpeg,image/jpg,image/png" 
               required />
        <?php if (session('errors.ktp_photo')): ?>
            <div class="invalid-feedback"><?= session('errors.ktp_photo') ?></div>
        <?php endif; ?>
        <small class="form-text text-muted">
            <i class="fas fa-info-circle"></i> 
            Upload foto KTP dalam format JPG, JPEG, atau PNG (maksimal 2MB)
        </small>
        
        <!-- Preview Image -->
        <div id="imagePreview" class="mt-2" style="display: none;">
            <img id="preview" src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3" id="submitBtn">
        <span id="submitText">Register</span>
        <span id="submitSpinner" class="spinner-border spinner-border-sm ms-2" role="status" style="display: none;">
            <span class="visually-hidden">Loading...</span>
        </span>
    </button>

    <div class="d-flex flex-column mt-3 text-center">
        <a href="<?= base_url('/login') ?>" class="text-decoration-none mb-2">
            <i class="fas fa-sign-in-alt"></i> Sudah punya akun? Login disini
        </a>
        <a href="<?= base_url('/') ?>" class="text-decoration-none">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility - FIX UNTUK ICON MATA
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        // Toggle password type
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        // Toggle eye icon
        const icon = this.querySelector('i');
        if (type === 'password') {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
    
    // Image preview
    const ktpPhoto = document.getElementById('ktp_photo');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    
    ktpPhoto.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (2MB = 2048KB)
            if (file.size > 2048 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                this.value = '';
                imagePreview.style.display = 'none';
                return;
            }
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung! Gunakan JPG, JPEG, atau PNG');
                this.value = '';
                imagePreview.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
    
    // Form submission with loading state
    const form = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    
    form.addEventListener('submit', function(e) {
        // Disable submit button and show spinner
        submitBtn.disabled = true;
        submitText.textContent = 'Registering...';
        submitSpinner.style.display = 'inline-block';
        
        // Re-enable button after 10 seconds (fallback)
        setTimeout(function() {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                submitText.textContent = 'Register';
                submitSpinner.style.display = 'none';
            }
        }, 10000);
    });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                if (bsAlert) {
                    bsAlert.close();
                }
            } catch (e) {
                // If Bootstrap Alert fails, manually hide the alert
                alert.style.display = 'none';
            }
        }, 5000);
    });
});</script>