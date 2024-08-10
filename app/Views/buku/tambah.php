<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="mb-3">
                <h1>Form Tambah Buku</h1>
                <a href="<?= base_url("/buku") ?>">Kembali ke halaman buku.</a>
            </div>
            <form action="<?= base_url("/buku/tambah-buku"); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Tulis judul buku Anda disini..." autofocus>
                </div>
                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select class="form-select" aria-label="Default select example" name="id_kategori">
                        <option selected>-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= $k['id_kategori'] ?>"><?= ucwords($k['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="file-buku" class="form-label">File Buku</label>
                    <input class="form-control" type="file" id="file-buku" name="file-buku">
                </div>
                <div class="mb-3">
                    <label for="cover" class="form-label">Cover Buku</label>
                    <input class="form-control" type="file" id="cover" name="cover">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>