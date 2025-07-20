<!-- Main Content -->
<main role="main">
    <!-- Hero Section -->
    <section id="beranda">
        <?= $this->include('components/hero') ?>
    </section>

    <!-- Produk Section -->
    <section id="produk" class="section-spacing">
        <?= $this->include('components/produk') ?>
    </section>

    <!-- Kategori Section -->
    <section id="kategori" class="section-spacing bg-light">
        <?= $this->include('components/kategori') ?>
    </section>

    <!-- Pemesanan Section -->
    <section id="pemesanan" class="section-spacing">
        <?= $this->include('components/pemesanan') ?>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="section-spacing bg-light">
        <?= $this->include('components/kontak') ?>
    </section>
</main>