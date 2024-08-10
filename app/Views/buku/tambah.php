<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="mb-3">
                <h1>Form Tambah Data Buku</h1>
                <a href="<?= base_url('/buku') ?>">Kembali ke halaman buku.</a>
            </div>

            <!-- FORM TAMBAH -->
            <form action="<?= base_url('/buku/tambah-buku'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <!-- JUDUL BUKU -->
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control <?= (isset($validation['judul'])) ? 'is-invalid' : '' ?>" id="judul" name="judul" placeholder="Tulis judul buku Anda disini..." autofocus value="<?= old('judul'); ?>">

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
                        <option selected>-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= $k['id_kategori'] ?>" <?= old('id_kategori') == $k['id_kategori'] ? 'selected' : ''; ?>>
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
                    <input type="number" class="form-control <?= (isset($validation['jumlah'])) ? 'is-invalid' : '' ?>" id="jumlah" name="jumlah" placeholder="Jumlah buku" min="0" value="<?= old('jumlah'); ?>">

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
                    <input class="form-control <?= (isset($validation['file-buku'])) ? 'is-invalid' : '' ?>" type="file" id="file-buku" name="file-buku" accept=".pdf">

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
                    <input class="form-control <?= (isset($validation['cover'])) ? 'is-invalid' : '' ?>" type="file" id="cover" name="cover" accept=".jpg,.jpeg,.png">

                    <!-- Pratinjau cover -->
                    <div class="mt-2" id="cover-preview" style="display: none;">
                        <img src="#" alt="Pratinjau Cover" class="img-thumbnail" width="150">
                    </div>

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
                    <textarea class="form-control <?= (isset($validation['deskripsi'])) ? 'is-invalid' : '' ?>" id="deskripsi" rows="3" name="deskripsi"><?= old('deskripsi'); ?></textarea>

                    <!-- Pesan kesalahan untuk deskripsi -->
                    <?php if (isset($validation['deskripsi'])) : ?>
                        <div class="invalid-feedback">
                            <?= $validation['deskripsi']; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>
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