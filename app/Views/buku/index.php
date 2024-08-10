<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between mb-2">
    <h3>List Buku</h3>
    <a href="<?= base_url("buku/tambah") ?>" class="btn btn-primary">Tambah Data Buku</a>
</div>

<?php if (session()->getFlashdata("message")) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sukses!</strong> <?= session()->getFlashdata("message"); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<table class="table table-striped table-hover align-middle" style="width:100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Cover</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($buku as $b) : ?>
            <tr>
                <td><?= $no; ?></td>
                <td><img src="/uploads/cover/<?= $b['cover'] ?>" class="cover" alt="Cover Buku"></td>
                <td><?= $b['judul']; ?></td>
                <td><?= ucwords($b['nama_kategori']); ?></td>
                <td><?= $b['jumlah']; ?></td>
                <td>
                    <a href="<?= base_url("buku/" . $b['slug']) ?>" class="btn btn-success">Detail</a>
                </td>
                <?php $no++; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>