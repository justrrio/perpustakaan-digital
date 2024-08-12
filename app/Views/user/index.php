<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>

<div class="mb-2 judul-page-buku">
    <p>List Data <span>User</span></p>
</div>

<div class="container-user">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container-wrapper-buku">
        <div style="width: 50%;">
            <!-- Input untuk pencarian -->
            <div class="input-group">
                <input type="text" class="form-control fs-5" id="searchInput" placeholder="Cari nama user..." aria-label="Cari">
                <button class="btn btn-outline-secondary fs-5" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>

    <!-- TABEL KATEGORI -->
    <table class="table table-hover align-middle fs-5" style="width:100%; margin-top: 30px;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="kategoriTable">
            <?php $no = 1; ?>
            <?php foreach ($user as $u) : ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= ucwords($u['username']); ?></td>
                    <td><?= ucwords($u['email']); ?></td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" data-nama-user="<?= ucwords($u['username']); ?>" data-id="<?= $u['id_user']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus User">
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
            var namaUser = button.getAttribute('data-nama-user');
            var id = button.getAttribute('data-id');

            // Update modal text
            var modalJudul = exampleModal.querySelector('.modal-judul-buku');
            modalJudul.textContent = namaUser;

            // Update form action
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', '<?= base_url("user/"); ?>' + id);
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