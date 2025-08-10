<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Kategori</h3>
                <div class="card-tools">
                    <a href="<?= base_url('produk/tambah') ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table id="tableProduk" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Nama Kategori</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Detail</th>
                            <th>Gambar</th>
                            <th>Total Terjual</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($this->data['products'] as $product) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $product['nama_produk'] ?></td>
                                <td><?= $product['nama_kategori'] ?></td>
                                <td><?= $product['stok'] ?></td>
                                <td><?= $product['satuan'] ?></td>
                                <td><?= $product['harga'] ?></td>
                                <td><?= $product['detail'] ?></td>
                                <td>
                                    <img width="52" height="52" src="<?= base_url('assets/image/product/') . $product['gambar'] ?>" alt="<?= $product['nama_produk'] ?>">
                                </td>
                                <td><?= $product['total_terjual'] ?></td>
                                <td>
                                    <a href="<?= base_url('produk/ubah/' . $product['id']) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('produk/hapus/' . $product['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#tableProduk').DataTable();
    });
</script>
<?= $this->endSection() ?>