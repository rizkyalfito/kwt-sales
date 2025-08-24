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
                            <th>Info Pengiriman</th>
                            <th>Alasan Pembatalan</th>
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
                                <td><?= $booking['jumlah'] ?> <?= $booking['satuan'] ?></td>
                                <td>Rp. <?= number_format($booking['total_harga']) ?></td>
                                <td><?= $booking['tanggal_pesan'] ?></td>
                                <td><?= strtoupper($booking['metode_pembayaran']) ?></td>
                                <td>
                                    <?php if ($booking['bukti_pembayaran']) : ?>
                                        <img style="cursor: pointer" onclick="window.open('<?= base_url('/') . $booking['bukti_pembayaran'] ?>')" width="52" height="52" src="<?= base_url('/') . $booking['bukti_pembayaran'] ?>" alt="<?= $booking['nama_user'] ?>">
                                    <?php else : ?>
                                        COD
                                    <?php endif; ?>
                                </td>
                                <td><?= strtoupper(str_replace('_', ' ', $booking['status'])) ?></td>
                                <td>
                                    <?php if ($booking['ekspedisi_nama'] || $booking['kendaraan_plat_nomor']) : ?>
                                        <span class="badge badge-success">Sudah Diisi</span>
                                    <?php else : ?>
                                        <span class="badge badge-warning">Belum Diisi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($booking['alasan_pembatalan']) : ?>
                                        <?= $booking['alasan_pembatalan'] ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>

                                    <?php if ($booking['status'] !== 'cancelled') : ?>
                                        <button type="button" class="btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#modalDetail<?= $booking['id'] ?>">
                                            Detail
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($booking['status'] === 'payment_confirmed') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/processing/') . $booking['id'] ?>" class="btn btn-info btn-sm">
                                            Proses
                                        </a>
                                        <a href="<?= base_url('pesanan/ubah/status/payment_rejected/') . $booking['id'] ?>" class="btn btn-danger btn-sm">
                                            Tolak Pembayaran
                                        </a>
                                    <?php elseif ($booking['status'] === 'processing') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/shipped/') . $booking['id'] ?>" class="btn btn-warning btn-sm mb-1">
                                            Kirim
                                        </a>
                                        <a href="<?= base_url('pesanan/ubah/status/cancelled/') . $booking['id'] ?>" class="btn btn-danger btn-sm mb-1">
                                            Batalkan
                                        </a>
                                    <?php elseif ($booking['status'] === 'shipped') : ?>
                                        <a href="<?= base_url('pesanan/ubah/status/completed/') . $booking['id'] ?>" class="btn btn-warning btn-sm">
                                            Selesai
                                        </a>
                                    <?php elseif ($booking['status'] === 'payment_rejected') : ?>
                                        <span class="badge text-bg-danger">Pembayaran Ditolak</span>
                                    <?php elseif ($booking['status'] === 'cancelled') : ?>
                                        <?php if ($booking['status_pembatalan'] === 'ditolak') : ?>
                                            <span class="badge text-bg-danger">Dibatalkan</span>
                                        <?php elseif ($booking['status_pembatalan'] !== 'dikonfirmasi' && $booking['status_pembatalan'] !== 'ditolak') : ?>
                                            <a href="<?= base_url('pesanan/ubah/status/pembatalan/dikonfirmasi/') . $booking['id'] ?>" class="btn btn-warning btn-sm mb-2">
                                                ACC Pembatalan
                                            </a>
                                            <a href="<?= base_url('pesanan/ubah/status/pembatalan/ditolak/') . $booking['id'] ?>" class="btn btn-danger btn-sm">
                                                Tolak Pembatalan
                                            </a>
                                        <?php else : ?>
                                            <span class="badge text-bg-danger">
                                                Dibatalkan
                                            </span>
                                        <?php endif; ?>
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

<!-- Modal untuk setiap pesanan -->
<?php foreach ($this->data['bookings'] as $booking) : ?>
<div class="modal fade" id="modalDetail<?= $booking['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel<?= $booking['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel<?= $booking['id'] ?>">Detail Pesanan #<?= $booking['pemesanan'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pesanan/update-pengiriman/' . $booking['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Data Pesanan</h6>
                            <table class="table table-sm">
                                <tr><td>ID Pemesanan</td><td>: <?= $booking['pemesanan'] ?></td></tr>
                                <tr><td>Nama Pemesan</td><td>: <?= $booking['nama_user'] ?></td></tr>
                                <tr><td>Produk</td><td>: <?= $booking['nama_produk'] ?></td></tr>
                                <tr><td>Jumlah</td><td>: <?= $booking['jumlah'] ?> <?= $booking['satuan'] ?></td></tr>
                                <tr><td>Total Harga</td><td>: Rp. <?= number_format($booking['total_harga']) ?></td></tr>
                                <tr><td>Status</td><td>: <?= strtoupper(str_replace('_', ' ', $booking['status'])) ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Informasi Pengiriman</h6>
                            
                            <div class="form-group">
                                <label>Jenis Pengiriman</label>
                                <select class="form-control jenis-pengiriman" name="jenis_pengiriman" onchange="togglePengiriman(<?= $booking['id'] ?>)">
                                    <option value="">Pilih Jenis</option>
                                    <option value="ekspedisi" <?= $booking['ekspedisi_nama'] ? 'selected' : '' ?>>Ekspedisi</option>
                                    <option value="kendaraan" <?= $booking['kendaraan_plat_nomor'] ? 'selected' : '' ?>>Kendaraan Sendiri</option>
                                </select>
                            </div>
                            
                            <div class="ekspedisi-section" id="ekspedisi-section-<?= $booking['id'] ?>" style="display: <?= $booking['ekspedisi_nama'] ? 'block' : 'none' ?>">
                                <div class="form-group">
                                    <label>Ekspedisi</label>
                                    <select class="form-control" name="ekspedisi_nama">
                                        <option value="">Pilih Ekspedisi</option>
                                        <option value="jne" <?= $booking['ekspedisi_nama'] == 'jne' ? 'selected' : '' ?>>JNE</option>
                                        <option value="jnt" <?= $booking['ekspedisi_nama'] == 'jnt' ? 'selected' : '' ?>>JNT</option>
                                        <option value="sicepat" <?= $booking['ekspedisi_nama'] == 'sicepat' ? 'selected' : '' ?>>SiCepat</option>
                                        <option value="tiki" <?= $booking['ekspedisi_nama'] == 'tiki' ? 'selected' : '' ?>>TIKI</option>
                                        <option value="pos" <?= $booking['ekspedisi_nama'] == 'pos' ? 'selected' : '' ?>>POS</option>
                                        <option value="lainnya" <?= $booking['ekspedisi_nama'] == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Resi</label>
                                    <input type="text" class="form-control" name="ekspedisi_resi" value="<?= $booking['ekspedisi_resi'] ?>">
                                </div>
                            </div>
                            
                            <div class="kendaraan-section" id="kendaraan-section-<?= $booking['id'] ?>" style="display: <?= $booking['kendaraan_plat_nomor'] ? 'block' : 'none' ?>">
                                <div class="form-group">
                                    <label>Nama Pengirim</label>
                                    <input type="text" class="form-control" name="pengirim_nama" value="<?= $booking['pengirim_nama'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kontak Pengirim</label>
                                    <input type="text" class="form-control" name="pengirim_kontak" value="<?= $booking['pengirim_kontak'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Alamat Pengirim</label>
                                    <textarea class="form-control" name="pengirim_alamat"><?= $booking['pengirim_alamat'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Plat Nomor Kendaraan</label>
                                    <input type="text" class="form-control" name="kendaraan_plat_nomor" value="<?= $booking['kendaraan_plat_nomor'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kendaraan</label>
                                    <input type="text" class="form-control" name="kendaraan_jenis" value="<?= $booking['kendaraan_jenis'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Merk Kendaraan</label>
                                    <input type="text" class="form-control" name="kendaraan_merk" value="<?= $booking['kendaraan_merk'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Tanggal Pengiriman</label>
                                <input type="datetime-local" class="form-control" name="tanggal_pengiriman" value="<?= $booking['tanggal_pengiriman'] ? date('Y-m-d\TH:i', strtotime($booking['tanggal_pengiriman'])) : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Pastikan jQuery dimuat terlebih dahulu -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JS untuk modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#tablePemesanan').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            }
        });
        
        // Debug: Log ketika modal dibuka
        $('.modal').on('show.bs.modal', function (e) {
            console.log('Modal sedang dibuka:', e.target.id);
        });
        
        // Debug: Log ketika modal ditutup
        $('.modal').on('hidden.bs.modal', function (e) {
            console.log('Modal ditutup:', e.target.id);
        });
        
        // Debug: Test button click
        $('[data-toggle="modal"]').on('click', function() {
            console.log('Button Detail diklik, target modal:', $(this).data('target'));
        });
    });

    function togglePengiriman(id) {
        const jenisPengiriman = document.querySelector(`#modalDetail${id} .jenis-pengiriman`).value;
        const ekspedisiSection = document.getElementById(`ekspedisi-section-${id}`);
        const kendaraanSection = document.getElementById(`kendaraan-section-${id}`);
        
        console.log('Toggle pengiriman untuk ID:', id, 'Jenis:', jenisPengiriman);
        
        if (jenisPengiriman === 'ekspedisi') {
            ekspedisiSection.style.display = 'block';
            kendaraanSection.style.display = 'none';
            
            // Clear kendaraan fields
            const modal = document.querySelector(`#modalDetail${id}`);
            modal.querySelector('[name="pengirim_nama"]').value = '';
            modal.querySelector('[name="pengirim_kontak"]').value = '';
            modal.querySelector('[name="pengirim_alamat"]').value = '';
            modal.querySelector('[name="kendaraan_plat_nomor"]').value = '';
            modal.querySelector('[name="kendaraan_jenis"]').value = '';
            modal.querySelector('[name="kendaraan_merk"]').value = '';
        } else if (jenisPengiriman === 'kendaraan') {
            ekspedisiSection.style.display = 'none';
            kendaraanSection.style.display = 'block';
            
            // Clear ekspedisi fields
            const modal = document.querySelector(`#modalDetail${id}`);
            modal.querySelector('[name="ekspedisi_nama"]').value = '';
            modal.querySelector('[name="ekspedisi_resi"]').value = '';
        } else {
            ekspedisiSection.style.display = 'none';
            kendaraanSection.style.display = 'none';
        }
    }

    // Alternative function untuk membuka modal jika bootstrap tidak bekerja
    function openModal(modalId) {
        console.log('Membuka modal:', modalId);
        const modal = document.getElementById(modalId);
        if (modal) {
            $(modal).modal('show');
        } else {
            console.error('Modal tidak ditemukan:', modalId);
        }
    }
</script>
<?= $this->endSection() ?>