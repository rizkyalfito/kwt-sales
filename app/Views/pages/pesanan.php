<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
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
                    <table id="tablePemesanan" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pemesanan</th>
                            <th>Nama Pemesan</th>
                            <th>Nama Produk</th>
                            <th>Kuantiti</th>
                            <th>Total Harga</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($this->data['bookings'] as $booking) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $booking['pemesanan'] ?></td>
                                <td><?= $booking['nama_user'] ?></td>
                                <td><?= $booking['nama_produk'] ?></td>
                                <td><?= $booking['jumlah'] ?></td>
                                <td><?= $booking['tanggal_pesan'] ?></td>
                                <td>Rp. <?= number_format($booking['total_harga']) ?></td>
                                <td><?= $booking['status'] ?></td>
                                <td>
                                    <?php if ($booking['status'] === 'diproses') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/dikirim/') . $booking['id'] ?>" class="btn btn-warning btn-sm">
                                            Kirim
                                        </a>
                                        <a href="<?= base_url('pesanan/ubah/status/dibatalkan/') . $booking['id'] ?>" class="btn btn-danger btn-sm">
                                            Tolak
                                        </a>
                                    <?php elseif ($booking['status'] === 'dikirim') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/selesai/') . $booking['id'] ?>" class="btn btn-success btn-sm">
                                            Selesai
                                        </a>
                                    <?php elseif ($booking['status'] === 'dibatalkan') : ?>
                                        <span class="badge text-bg-danger">Dibatalkan</span>
                                    <?php elseif ($booking['status'] === 'selesai') : ?>
                                        <span class="badge text-bg-success">Selesai</span>
                                    <?php endif; ?>
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
        $('#tablePemesanan').DataTable();
    });
</script>
<?= $this->endSection() ?>


