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
                        <h4>Form Input Kontak</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('kontak/simpan') ?>" method="post">
                            <div class="mb-2">
                                <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                                <input type="number" class="form-control" id="whatsapp" placeholder="Masukkan nomor whatsapp" name="whatsapp" required>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan email" name="email" required>
                            </div>
                            <div class="mb-2">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" placeholder="Masukkan alamat" name="alamat" required>
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