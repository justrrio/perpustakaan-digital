<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-6">
                        <img src="/uploads/cover/<?= $buku['cover'] ?>" class="img-fluid rounded-start" alt="Cover Buku">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h3 class="card-title"><?= $buku['judul']; ?></h3>
                            <p class="badge text-bg-secondary p-2"><?= ucwords($buku['nama_kategori']); ?></p>
                            <p class="card-text"><?= $buku['deskripsi']; ?></p>
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                            <a href="<?= base_url('/uploads/file-buku/' . $buku['file_buku']) ?>" class="btn btn-primary d-block" download>
                                Download File Buku
                            </a>

                            <a href="<?= base_url("buku") ?>">Kembali ke daftar buku.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>