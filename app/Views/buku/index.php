<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between mb-2 judul-page-buku">
    <p>List Data <span>Buku</span></p>
</div>

<div class="container-jumlah-buku">
    <div class="title-jumlah-buku">
        <h5>Jumlah Buku</h5>
    </div>
    <div class="content-jumlah-buku">
        <h2><?= $totalBuku; ?></h2>
        <i class="fa fa-book icon-jumlah-buku" aria-hidden="true"></i>
    </div>
</div>

<div class="container-jumlah-kategori">
    <div class="title-jumlah-kategori">
        <h5>Jumlah Kategori</h5>
    </div>
    <div class="content-jumlah-kategori">
        <h2><?= $totalKategori; ?></h2>
        <i class="fa fa-layer-group icon-jumlah-kategori" aria-hidden="true"></i>
    </div>
</div>

<div class="container-jumlah-user">
    <div class="title-jumlah-user">
        <h5>Jumlah User</h5>
    </div>
    <div class="content-jumlah-user">
        <h2><?= $totalUser; ?></h2>
        <i class="fa fa-users icon-jumlah-user" aria-hidden="true"></i>
    </div>
</div>

<?php
// if (session()->get("role")) {
//     dd(session()->get("role"));
// }
?>


<div class="container-data-buku">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="container-wrapper-buku">
        <div class="d-flex align-items-center" style="width: 50%; margin-top: 30px;">
            <!-- Tambah buku -->
            <div class="d-flex align-items-center">
                <a href="<?= base_url("buku/tambah") ?>" class="btn btn-primary fs-5">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Tambah Data Buku
                </a>
            </div>
            <!-- Dropdown untuk filter kategori -->
            <div class="ms-3 dropdown">
                <button class="btn btn-warning dropdown-toggle fs-5" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Kategori
                </button>
                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item fs-5" data-id="" href="#">Semua Kategori</a></li>
                    <?php if (isset($kategori) && is_array($kategori)) : ?>
                        <?php foreach ($kategori as $k) : ?>
                            <li><a class="dropdown-item fs-5" data-id="<?= $k['id_kategori'] ?>" href="#"><?= ucwords($k['nama']) ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div style="width: 50%;">
            <!-- Input untuk pencarian -->
            <div class="input-group">
                <input type="text" class="form-control fs-5" id="searchInput" placeholder="Cari judul atau kategori buku..." aria-label="Cari">
                <button class="btn btn-outline-secondary fs-5" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>

    <!-- Tabel buku -->
    <table class="table table-hover align-middle fs-5" style="width:100%; margin-top: 30px;">
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
                                <div class="modal-content p-2">
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Event listener for the modal
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget

            // Retrieve data
            var judul = button.getAttribute('data-judul')
            var id = button.getAttribute('data-id')

            // Update modal text
            var modalJudul = exampleModal.querySelector('.modal-judul-buku')
            modalJudul.textContent = judul

            // Update form action
            var deleteForm = document.getElementById('deleteForm')
            deleteForm.setAttribute('action', '<?= base_url("buku/"); ?>' + id)
        })

        // Live search function
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            fetchBooks(this.value, selectedCategoryId);
        });

        // Function to fetch books with AJAX
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

        // Get the dropdown button and menu items
        const dropdownButton = document.getElementById('categoryDropdown');
        const dropdownItems = document.querySelectorAll('.dropdown-item');

        // Initialize the selected category ID
        let selectedCategoryId = '';

        // Add click event listener to each dropdown item
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior

                // Update the dropdown button text
                dropdownButton.textContent = this.textContent;

                // Filter books based on selected category
                selectedCategoryId = this.getAttribute('data-id');
                fetchBooks(searchInput.value, selectedCategoryId);
            });
        });
    })
</script>

<?= $this->endSection(); ?>