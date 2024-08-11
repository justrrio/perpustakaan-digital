<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>
<div class="mb-2 judul-page-buku">
    <p>Info Detail <span>Buku</span></p>
    <a class="btn btn-primary p-2 fs-6" href="<?= base_url("/buku"); ?>">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <span class="ms-2" style="color: white;">Kembali</span>
    </a>
</div>

<div class="wrapper-detail d-flex">
    <div class="container-cover">
        <img src="/uploads/cover/<?= $buku['cover'] ?>" alt="" class="cover-detail">
    </div>
    <div class="container-detail">
        <h1 class="fs-1"><?= $buku['judul']; ?></h1>
        <p class="badge text-bg-warning p-2 fs-6"><?= ucwords($buku['nama_kategori']); ?></p>
        <p class="card-text"><?= $buku['deskripsi']; ?></p>
        <a href="<?= base_url('/uploads/file-buku/' . $buku['file_buku']) ?>" class="btn btn-success d-block" download style="width: 200px;">
            <i class="fa fa-download" aria-hidden="true"></i>
            Download File Buku
        </a>
    </div>
</div>

<?= $this->endSection(); ?>