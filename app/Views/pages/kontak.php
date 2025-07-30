<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Kontak</h3>
                <?php if (!count($this->data['contacts']) > 0) : ?>
                    <div class="card-tools">
                        <a href="<?= base_url('kontak/tambah') ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Kontak
                        </a>
                    </div>
                <?php endif; ?>
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
                    <table id="tableKontak" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor WhatsApp</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($this->data['contacts'] as $contact) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $contact['no_wa'] ?></td>
                                <td><?= $contact['email'] ?></td>
                                <td><?= $contact['alamat'] ?></td>
                                <td>
                                    <a href="<?= base_url('kontak/ubah/' . $contact['id']) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
<!--                                    <a href="--><?php //= base_url('kontak/hapus/' . $contact['id']) ?><!--" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')">-->
<!--                                        <i class="fas fa-trash"></i>-->
<!--                                    </a>-->
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
        $('#tableKontak').DataTable();
    });
</script>
<?= $this->endSection() ?>