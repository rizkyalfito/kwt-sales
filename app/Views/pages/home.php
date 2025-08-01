<!-- Main Content -->
<main role="main">
    <!-- Hero Section -->
        <?= $this->include('components/hero') ?>

    <!-- Produk Section -->
        <?= $this->include('components/produk') ?>

    <!-- Kategori Section -->
        <?= $this->include('components/kategori', ['categories' => $categories]) ?>

    <!-- Pemesanan Section -->
        <?= $this->include('components/pemesanan') ?>

    <!-- Kontak Section -->
        <?= $this->include('components/kontak') ?>

</main>

<script>
    // Script ini ditambahkan di halaman home untuk tracking active section
document.addEventListener('DOMContentLoaded', function() {
    // Hanya jalankan di halaman home
    if (window.location.pathname === '/' || window.location.pathname === '') {
        
        const sections = document.querySelectorAll('section[id], div[id]');
        const navLinks = document.querySelectorAll('.smart-nav');
        
        // Function untuk update active nav link
        function updateActiveNav() {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (window.pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-section') === current) {
                    link.classList.add('active');
                }
            });
        }
        
        // Update on scroll
        window.addEventListener('scroll', updateActiveNav);
        
        // Update on page load
        updateActiveNav();
    }
});

// Function untuk handle redirect dengan hash dari halaman lain
function navigateToSection(sectionId) {
    if (window.location.pathname !== '/' && window.location.pathname !== '') {
        // Redirect ke home dengan hash
        window.location.href = `/${sectionId}`;
    } else {
        // Scroll ke section
        const element = document.getElementById(sectionId.replace('#', ''));
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
}
</script>