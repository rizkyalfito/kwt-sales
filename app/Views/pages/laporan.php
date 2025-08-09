<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="get" action="<?= base_url('laporan') ?>">
                    <div class="input-group">
                        <input
                                type="month"
                                class="form-control"
                                name="month"
                                value="<?= esc($this->data['selectedMonth'] ?? date('Y-m')) ?>"
                                max="<?= date('Y-m') ?>"
                                aria-label="Filter Bulan"
                                aria-describedby="basic-addon2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </form>
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
                    <table id="tableLaporan" class="table table-bordered table-striped">
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
                                <td><?= strtoupper(str_replace('_', ' ', $booking['status'])) ?></td>
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
        $('#tableLaporan').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-primary'
                }
            ]
        });
    });
</script>
<?= $this->endSection() ?>


