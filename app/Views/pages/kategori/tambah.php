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
                        <h4>Form Input Kategori</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('kategori/simpan') ?>" method="post">
                            <div>
                                <label for="kategori" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="kategori" placeholder="Masukkan nama kategori" name="kategori" required>
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