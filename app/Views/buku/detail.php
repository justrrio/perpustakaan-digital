<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="card mb-3" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="/assets/<?= $buku['cover'] ?>" class="img-fluid rounded-start" alt="Cover Buku">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h3 class="card-title"><?= $buku['judul']; ?></h3>
                <p class="btn btn-secondary">Productivty<?= $buku['id_kategori']; ?></p>
                <p class="card-text"><?= $buku['deskripsi']; ?></p>
                <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>