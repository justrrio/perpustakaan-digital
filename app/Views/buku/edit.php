<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>
<div class="mb-2 judul-page-buku">
    <p>Ubah Data <span>Buku</span></p>
    <a class="btn btn-primary p-2 fs-6" href="<?= base_url("/buku"); ?>">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <span class="ms-2" style="color: white;">Kembali</span>
    </a>
</div>

<div class="container-ubah">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <h1>Form</h1>
    </div>

    <!-- FORM EDIT -->
    <form action="<?= base_url('/buku/edit-buku/' . $buku['id_buku']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="id-buku" value="<?= $buku['id_buku']; ?>">

        <!-- JUDUL BUKU -->
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control <?= (isset($validation['judul'])) ? 'is-invalid' : '' ?>" id="judul" name="judul" placeholder="Tulis judul buku Anda disini..." autofocus value="<?= old('judul', $buku['judul']); ?>">

            <!-- Pesan kesalahan untuk judul buku -->
            <?php if (isset($validation['judul'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['judul']; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- KATEGORI BUKU -->
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>

            <!-- Dropdown untuk memilih kategori buku -->
            <select class="form-select <?= (isset($validation['id_kategori'])) ? 'is-invalid' : '' ?>" name="id_kategori">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $k) : ?>
                    <option value="<?= $k['id_kategori'] ?>" <?= (old('id_kategori', $buku['id_kategori']) == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= ucwords($k['nama']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Pesan kesalahan untuk pemilihan kategori -->
            <?php if (isset($validation['id_kategori'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['id_kategori']; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- JUMLAH -->
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control <?= (isset($validation['jumlah'])) ? 'is-invalid' : '' ?>" id="jumlah" name="jumlah" placeholder="Jumlah buku" min="0" value="<?= old('jumlah', $buku['jumlah']); ?>">

            <!-- Pesan kesalahan untuk jumlah -->
            <?php if (isset($validation['jumlah'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['jumlah']; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- FILE BUKU -->
        <div class="mb-3">
            <label for="file-buku" class="form-label">File Buku</label>
            <input class="form-control <?= (isset($validation['file-buku'])) ? 'is-invalid' : '' ?>" type="file" id="file-buku" name="file-buku">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah file buku.</small>

            <!-- Pratinjau file buku -->
            <?php if (!empty($buku['file_buku'])) : ?>
                <div class="mt-2">
                    <a href="<?= base_url('/uploads/file-buku/' . $buku['file_buku']); ?>" target="_blank" class="btn btn-link">Lihat File Buku Saat Ini</a>
                </div>
            <?php endif; ?>

            <!-- Pesan kesalahan untuk file buku -->
            <?php if (isset($validation['file-buku'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['file-buku']; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- COVER BUKU -->
        <div class="mb-3">
            <label for="cover" class="form-label">Cover Buku</label>
            <input class="form-control <?= (isset($validation['cover'])) ? 'is-invalid' : '' ?>" type="file" id="cover" name="cover">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah cover.</small>

            <!-- Preview Cover -->
            <?php if (!empty($buku['cover'])) : ?>
                <div class="mt-2">
                    <img src="<?= base_url('/uploads/cover/' . $buku['cover']); ?>" alt="Cover Saat Ini" class="img-thumbnail" width="150">
                </div>
            <?php endif; ?>

            <!-- Pesan kesalahan untuk cover -->
            <?php if (isset($validation['cover'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['cover']; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- DESKRIPSI BUKU -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control <?= (isset($validation['deskripsi'])) ? 'is-invalid' : '' ?>" id="deskripsi" rows="3" name="deskripsi"><?= old('deskripsi', $buku['deskripsi']); ?></textarea>

            <!-- Pesan kesalahan untuk deskripsi -->
            <?php if (isset($validation['deskripsi'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation['deskripsi']; ?>
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