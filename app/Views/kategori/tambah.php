<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>

<div class="mb-2 judul-page-buku">
    <p>Tambah Kategori <span>Buku</span></p>
    <a class="btn btn-primary p-2 fs-6" href="<?= base_url("/kategori"); ?>">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <span class="ms-2" style="color: white;">Kembali</span>
    </a>
</div>

<div class="container-tambah">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <h1>Form</h1>
    </div>

    <!-- FORM TAMBAH -->
    <form action="<?= base_url('/kategori/tambah-kategori'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="id-user" value="<?= session()->get("id_user"); ?>">

        <!-- NAMA KATEGORI -->
        <div class="mb-3">
            <label for="nama-kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control <?= (isset($validation['nama-kategori'])) ? 'is-invalid' : '' ?>" id="nama-kategori" name="nama-kategori" placeholder="Tulis nama kategori Anda disini..." autofocus value="<?= old('nama-kategori'); ?>">

            <!-- Pesan kesalahan untuk judul buku -->
            <?php if (isset($validation['nama-kategori'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['nama-kategori']; ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
    </form>

</div>

<script>
    // Fungsi untuk menampilkan pratinjau cover ketika pengguna memilih file
    document.getElementById('cover').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const fileReader = new FileReader();

            // Pastikan file adalah gambar
            if (file.type.match('image.*')) {
                fileReader.onload = function(e) {
                    const imgElement = document.querySelector('#cover-preview img');
                    imgElement.src = e.target.result;
                    document.getElementById('cover-preview').style.display = 'block';
                }
                fileReader.readAsDataURL(file);
            }
        }
    });
</script>

<?= $this->endSection(); ?>