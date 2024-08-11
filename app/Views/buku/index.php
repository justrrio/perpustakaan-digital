<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between mb-2">
    <h3>List Buku</h3>
    <a href="<?= base_url("buku/tambah") ?>" class="btn btn-primary">Tambah Data Buku</a>
</div>

<?php if (session()->getFlashdata("message")) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Input untuk pencarian -->
<div class="input-group mb-3">
    <input type="text" class="form-control" id="searchInput" placeholder="Cari judul atau kategori buku..." aria-label="Cari">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
</div>

<!-- Dropdown untuk filter kategori -->
<div class="mb-3">
    <select class="form-select" id="filterKategori">
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategori as $k) : ?>
            <option value="<?= $k['id_kategori'] ?>"><?= ucwords($k['nama']); ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Tabel buku -->
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
    <tbody id="bukuTable">
        <?php $no = 1; ?>
        <?php foreach ($buku as $b) : ?>
            <tr>
                <td><?= $no; ?></td>
                <td><img src="/uploads/cover/<?= $b['cover'] ?>" class="cover" alt="Cover Buku"></td>
                <td><?= $b['judul']; ?></td>
                <td><?= ucwords($b['nama_kategori']); ?></td>
                <td><?= $b['jumlah']; ?></td>
                <td>
                    <!-- Button Detail -->
                    <a href="<?= base_url("buku/" . $b['slug']) ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Buku">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>

                    <!-- Button Edit -->
                    <a href="<?= base_url("buku/edit/" . $b['slug']) ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Buku">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>

                    <!-- Button trigger modal -->
                    <!-- <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" data-judul="<?= $b['judul']; ?>" data-id="<?= $b['id_buku']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Buku">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button> -->
                    <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" data-judul="<?= $b['judul']; ?>" data-id="<?= $b['id_buku']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Buku">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title fs-5">Apakah Anda yakin untuk menghapus data buku <strong style="color: #FF4C4C" class="modal-judul-buku"></strong>?</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form id="deleteForm" action="#" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger">
                                            Saya yakin!
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </td>
                <?php $no++; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Event listener
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget

            // Ambil data
            var judul = button.getAttribute('data-judul')
            var id = button.getAttribute('data-id')

            // Update teks
            var modalJudul = exampleModal.querySelector('.modal-judul-buku')
            modalJudul.textContent = judul

            // Update form
            var deleteForm = document.getElementById('deleteForm')
            deleteForm.setAttribute('action', '<?= base_url("buku/"); ?>' + id)
        })

        // Fungsi live search
        document.getElementById('searchInput').addEventListener('input', function() {
            fetchBooks(this.value, document.getElementById('filterKategori').value);
        });

        // Fungsi filter kategori
        document.getElementById('filterKategori').addEventListener('change', function() {
            fetchBooks(document.getElementById('searchInput').value, this.value);
        });

        // Fungsi untuk mengambil data buku dengan AJAX
        function fetchBooks(keyword, kategori) {
            fetch('<?= base_url("buku/search"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
                    },
                    body: JSON.stringify({
                        keyword: keyword,
                        kategori: kategori
                    })
                })
                .then(response => response.json())
                .then(data => {
                    var bukuTable = document.getElementById('bukuTable');
                    bukuTable.innerHTML = '';

                    data.forEach(function(buku, index) {
                        var row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td><img src="/uploads/cover/${buku.cover}" class="cover" alt="Cover Buku"></td>
                            <td>${buku.judul}</td>
                            <td>${buku.nama_kategori}</td>
                            <td>${buku.jumlah}</td>
                            <td>
                                <a href="<?= base_url("buku/"); ?>${buku.slug}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Buku">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="<?= base_url("buku/edit/"); ?>${buku.slug}" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Buku">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" data-judul="${buku.judul}" data-id="${buku.id_buku}" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Buku">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                        bukuTable.insertAdjacentHTML('beforeend', row);
                    });

                    // Reinitialize tooltips
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                })
                .catch(error => console.error('Error:', error));
        }
    })
</script>

<?= $this->endSection(); ?>