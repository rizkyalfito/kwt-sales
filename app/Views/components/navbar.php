<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" href="<?= base_url('/') ?>">
      <span class="text-success">KWT</span> Store
    </a>
    
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link px-3" href="<?= base_url('/') ?>">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 smart-nav" href="<?= base_url('/#produk') ?>" onclick="navigateToSection('produk')">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 smart-nav" href="<?= base_url('/#kontak') ?>" onclick="navigateToSection('kontak')">Kontak</a>
        </li>
      </ul>
      
      <ul class="navbar-nav">
        <?php if (session()->get('isLoggedIn')): ?>
          <!-- Icon Keranjang untuk user yang login -->
          <li class="nav-item">
            <a class="nav-link position-relative px-3" href="<?= base_url('/produk-public') ?>" title="Keranjang Belanja">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
              </svg>
            </a>
          </li>
          
          <!-- Dropdown User Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle px-3" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= session()->get('nama') ?? 'Akun' ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if (session()->get('level') === 'admin'): ?>
                <li><a class="dropdown-item" href="<?= base_url('/dashboard') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer2 me-2" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.5 13 8 13c-1.5 0-3.309.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                        </svg>
                        Dashboard
                    </a></li>
                <?php else : ?>
                  <li><a class="dropdown-item" href="<?= base_url('/riwayat-pemesanan') ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history me-2" viewBox="0 0 16 16">
                              <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.885.354.756-.524zM.5 8a.5.5 0 0 1-.5-.5V5.6a.5.5 0 0 1 .5-.5L2 5.1a.5.5 0 0 1 .5.5v.769l.354-.354a.5.5 0 0 1 .707.708L2.707 7.5H3.5a.5.5 0 0 1 0 1H.5z"/>
                              <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                              <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                          </svg>
                          Riwayat Pesanan
                      </a>
                  </li>
                <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?= base_url('/logout') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right me-2" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
                Logout
              </a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Tombol Login untuk user yang belum login -->
          <li class="nav-item">
            <a class="btn btn-outline-success px-4" href="<?= base_url('/login') ?>">Masuk</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script>
function navigateToSection(sectionId) {
    const currentPath = window.location.pathname;
    const baseUrl = '<?= base_url() ?>';
    
    // Jika sudah di halaman home
    if (currentPath === '/' || currentPath === '') {
        // Scroll ke section
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
        return false; // Prevent default link behavior
    } else {
        // Jika di halaman lain, redirect ke home dengan hash
        window.location.href = baseUrl + '/#' + sectionId;
        return false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle hash navigation ketika halaman home dimuat dengan hash
    if (window.location.hash && (window.location.pathname === '/' || window.location.pathname === '')) {
        const targetId = window.location.hash.substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            // Delay scroll untuk memastikan halaman sudah fully loaded
            setTimeout(() => {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 500); // Increase delay
        }
    }
    
    // Active section tracking hanya di halaman home
    if (window.location.pathname === '/' || window.location.pathname === '') {
        const sections = document.querySelectorAll('[id="produk"], [id="kategori"], [id="pemesanan"], [id="kontak"]');
        const navLinks = document.querySelectorAll('.smart-nav');
        
        function updateActiveNav() {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (window.pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                const linkHref = link.getAttribute('href');
                if (linkHref.includes('#' + current)) {
                    link.classList.add('active');
                }
            });
        }
        
        window.addEventListener('scroll', updateActiveNav);
        updateActiveNav();
    }
});
</script>

<style>
.navbar {
  padding: 1rem 0;
  transition: all 0.3s ease;
}

.navbar-brand {
  color: #2c3e50 !important;
}

.navbar-brand:hover {
  color: #27ae60 !important;
}

.nav-link {
  color: #6c757d !important;
  font-weight: 500;
  transition: all 0.3s ease;
  position: relative;
}

.nav-link:hover {
  color: #27ae60 !important;
}

.nav-link::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 50%;
  background-color: #27ae60;
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.nav-link:hover::after,
.nav-link.active::after {
  width: 80%;
}

/* Cart icon styling */
.nav-link svg {
  transition: all 0.3s ease;
}

.nav-link:hover svg {
  color: #27ae60 !important;
  transform: scale(1.1);
}

/* Badge styling */


/* Button styling */
.btn-outline-success {
  border-color: #27ae60;
  color: #27ae60;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn-outline-success:hover {
  background-color: #27ae60;
  border-color: #27ae60;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(39, 174, 96, 0.2);
}

/* Dropdown styling */
.dropdown-menu {
  border: none;
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  border-radius: 8px;
  padding: 0.5rem 0;
}

.dropdown-item {
  padding: 0.5rem 1.5rem;
  transition: all 0.3s ease;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
  color: #27ae60;
}

.dropdown-item.text-danger:hover {
  background-color: #f8f9fa;
  color: #dc3545 !important;
}

/* Mobile responsive */
@media (max-width: 991.98px) {
  .navbar-nav.mx-auto {
    margin: 1rem 0 !important;
  }
  
  .nav-link {
    padding: 0.5rem 1rem !important;
  }
  
  .btn-outline-success {
    margin-top: 0.5rem;
    width: 100%;
  }
}

/* Active state untuk navigation */
.nav-link.active {
  color: #27ae60 !important;
  font-weight: 600;
}
</style>
</style>