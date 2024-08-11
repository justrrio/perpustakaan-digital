<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>

<div class="mb-2 judul-page-buku">
    <p>List Kategori <span>Buku</span></p>
</div>

<div class="container-kategori">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container-wrapper-buku">
        <div class="d-flex align-items-center" style="width: 50%; margin-top: 30px;">
            <!-- Tambah kategori -->
            <div class="d-flex align-items-center">
                <a href="<?= base_url("kategori/tambah") ?>" class="btn btn-primary fs-5">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Tambah Kategori
                </a>
            </div>
        </div>
        <div style="width: 50%;">
            <!-- Input untuk pencarian -->
            <div class="input-group">
                <input type="text" class="form-control fs-5" id="searchInput" placeholder="Cari kategori buku..." aria-label="Cari">
                <button class="btn btn-outline-secondary fs-5" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>

    <!-- TABEL KATEGORI -->
    <table class="table table-hover align-middle fs-5" style="width:100%; margin-top: 30px;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="kategoriTable">
            <?php $no = 1; ?>
            <?php foreach ($kategori as $k) : ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= ucwords($k['nama']); ?></td>
                    <td>
                        <!-- Button Edit -->
                        <a href="<?= base_url("kategori/edit/" . $k['nama']) ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Kategori">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" data-nama-kategori="<?= ucwords($k['nama']); ?>" data-id="<?= $k['id_kategori']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Kategori">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                    <?php $no++; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header">
                <p class="modal-title fs-5">Apakah Anda yakin untuk menghapus data kategori <strong style="color: #FF4C4C" class="modal-judul-buku"></strong>?</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Event listener for the modal
        var exampleModal = document.getElementById('exampleModal');
        exampleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;

            // Retrieve data
            var namaKategori = button.getAttribute('data-nama-kategori');
            var id = button.getAttribute('data-id');

            // Update modal text
            var modalJudul = exampleModal.querySelector('.modal-judul-buku');
            modalJudul.textContent = namaKategori;

            // Update form action
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', '<?= base_url("kategori/"); ?>' + id);
        });

        // Live search function
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            const rows = document.querySelectorAll('#kategoriTable tr');

            rows.forEach(row => {
                const kategori = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (kategori.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>