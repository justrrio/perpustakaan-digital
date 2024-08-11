<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>
<div class="mb-2 judul-page-buku">
    <p>Ubah Kategori <span>Buku</span></p>
    <a class="btn btn-primary p-2 fs-6" href="<?= base_url("/kategori"); ?>">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <span class="ms-2" style="color: white;">Kembali</span>
    </a>
</div>

<div class="container-ubah">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5 me-2" aria-hidden="true"></i>
            <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <h1>Form</h1>
    </div>

    <!-- FORM EDIT -->
    <form action="<?= base_url('/kategori/edit-kategori/' . $kategori['nama']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <!-- NAMA KATEGORI -->
        <div class="mb-3">
            <label for="nama-kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control <?= (isset($validation['nama-kategori'])) ? 'is-invalid' : '' ?>" id="nama-kategori" name="nama-kategori" placeholder="Tulis nama kategori buku Anda disini..." autofocus value="<?= old('nama-kategori', ucwords($kategori['nama'])); ?>">

            <!-- Pesan kesalahan untuk nama kategori buku -->
            <?php if (isset($validation['nama-kategori'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['nama-kategori']; ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save" aria-hidden="true"></i>
            <span class="ms-2">Simpan</span>
        </button>
    </form>
</div>

<?= $this->endSection(); ?>