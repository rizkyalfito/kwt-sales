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
                            <th>Metode Pembayaran</th>
                            <th>Bukti Pembayaran</th>
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
                                <td>Rp. <?= number_format($booking['total_harga']) ?></td>
                                <td><?= $booking['tanggal_pesan'] ?></td>
                                <td><?= strtoupper($booking['metode_pembayaran']) ?></td>
                                <td>
                                    <?php if ($booking['bukti_pembayaran']) : ?>
                                        <img width="52" height="52" src="<?= base_url('/') . $booking['bukti_pembayaran'] ?>" alt="<?= $booking['nama_user'] ?>">
                                    <?php else : ?>
                                        COD
                                    <?php endif; ?>
                                </td>
                                <td><?= strtoupper(str_replace('_', ' ', $booking['status'])) ?></td>
                                <td>
                                    <?php if ($booking['status'] === 'payment_confirmed') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/processing/') . $booking['id'] ?>" class="btn btn-info btn-sm">
                                            Prosess
                                        </a>
                                        <a href="<?= base_url('pesanan/ubah/status/payment_rejected/') . $booking['id'] ?>" class="btn btn-danger btn-sm">
                                            Tolak Pembayaran
                                        </a>
                                    <?php elseif ($booking['status'] === 'processing') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/shipped/') . $booking['id'] ?>" class="btn btn-warning btn-sm">
                                            Kirim
                                        </a>
                                        <a href="<?= base_url('pesanan/ubah/status/cancelled/') . $booking['id'] ?>" class="btn btn-danger btn-sm">
                                            Batalkan
                                        </a>
                                    <?php elseif ($booking['status'] === 'shipped') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/completed/') . $booking['id'] ?>" class="btn btn-success btn-sm">
                                            Selesai
                                        </a>
                                    <?php elseif ($booking['status'] === 'payment_rejected') : ?>
                                        <span class="badge text-bg-danger">Pembayaran Ditolak</span>
                                    <?php elseif ($booking['status'] === 'cancelled') : ?>
                                        <span class="badge text-bg-danger">Dibatalkan</span>
                                    <?php elseif ($booking['status'] === 'completed') : ?>
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


