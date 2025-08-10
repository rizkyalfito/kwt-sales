<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger my-4" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Form Input Produk</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('produk/update/') . $this->data['product']['id'] ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label for="produk" class="form-label">Nama Produk</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        id="produk"
                                        placeholder="Masukkan nama produk"
                                        name="produk"
                                        value="<?= $this->data['product']['nama_produk'] ?>"
                                        required
                                >
                            </div>
                            <div class="mb-2">
                                <label for="kategori" class="form-label">Nama Kategori</label>
                                <select name="kategori" id="kategori" class="form-select">
                                    <?php foreach ($this->data['categories'] as $category) : ?>
                                        <option
                                            value="<?= $category['nama_kategori'] ?>"
                                            <?= $this->data['product']['nama_kategori'] === $category['nama_kategori'] ? 'selected' : '' ?>
                                        >
                                            <?= $category['nama_kategori'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="stok" class="form-label">Stok</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        id="stok"
                                        placeholder="Masukkan stok produk"
                                        name="stok"
                                        required
                                        value="<?= $this->data['product']['stok'] ?>"
                                >
                            </div>
                            <div class="mb-2">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        id="satuan"
                                        placeholder="Masukkan satuan produk"
                                        name="satuan"
                                        required
                                        value="<?= $this->data['product']['satuan'] ?>"
                                >
                            </div>
                            <div class="mb-2">
                                <label for="harga" class="form-label">Harga</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        id="harga"
                                        placeholder="Masukkan harga produk"
                                        name="harga"
                                        required
                                        value="<?= $this->data['product']['harga'] ?>"
                                >
                            </div>
                            <div class="mb-2">
                                <label for="detail" class="form-label">Detail</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        id="detail"
                                        placeholder="Masukkan detail produk"
                                        name="detail"
                                        required
                                        value="<?= $this->data['product']['detail'] ?>"
                                >
                            </div>
                            <div class="mb-4">
                                <label for="gambar" class="form-label">Gambar Produk <span class="text-danger">(biarkan kosong jika tidak diubah)</span></label>
                                <input type="file" class="form-control" id="gambar" placeholder="Masukkan detail produk" name="gambar" accept=".jpg,.png,.jpeg,.webp">
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>