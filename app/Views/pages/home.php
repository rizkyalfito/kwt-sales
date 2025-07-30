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