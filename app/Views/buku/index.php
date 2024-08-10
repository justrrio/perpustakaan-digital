<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<h1>List Buku</h1>
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
                <td><img src="/assets/<?= $b['cover'] ?>" alt="Cover Buku" width="100"></td>
                <td><?= $b['judul']; ?></td>
                <td><?= $b['id_kategori']; ?></td>
                <td><?= $b['jumlah']; ?></td>
                <td>
                    <a href="<?= $b['slug'] ?>" class="btn btn-success">Detail</a>
                </td>
                <?php $no++; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>