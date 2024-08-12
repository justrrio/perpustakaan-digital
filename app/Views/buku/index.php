<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between mb-2 judul-page-buku">
    <p>List Data <span>Buku</span></p>
    <p>Selamat datang, <span id="nama-user"><?= session()->get("username"); ?></span></p>
</div>
<div class="container-export-buku">
    <button id="export-pdf" class="btn btn-danger fs-5 me-4" onclick="exportPDF()">
        <i class="fa fa-upload fs-5 me-2" aria-hidden="true"></i>
        Export Data to PDF
    </button>
    <button id="export-csv" class="btn btn-success fs-5" onclick="exportCSV()">
        <i class="fa fa-upload fs-5 me-2" aria-hidden="true"></i>
        Export Data to CSV
    </button>
</div>

<!-- Proses URL -->
<?php
$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';

// Cek apakah URL tersedia
if (!empty($url)) {
    // Memecah URL menjadi segmen
    $segments = explode('/', trim($url, '/')); // Trim menghilangkan leading/trailing slashes

    // Ambil segmen kedua dari belakang (untuk filter)
    $filter = (count($segments) >= 2) ? $segments[count($segments) - 2] : "";

    // Ambil segmen ketiga dari belakang (untuk isFilter)
    $isFilter = (count($segments) >= 3) ? $segments[count($segments) - 3] : "";
} else {
    $filter = "";
    $isFilter = "";
}
?>

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

<?php if (session()->get("role") == "admin") : ?>
    <div class="container-jumlah-user">
        <div class="title-jumlah-user">
            <h5>Jumlah User</h5>
        </div>
        <div class="content-jumlah-user">
            <h2><?= $totalUser; ?></h2>
            <i class="fa fa-users icon-jumlah-user" aria-hidden="true"></i>
        </div>
    </div>
<?php endif; ?>

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
                    <?= ($isFilter == 'filter') ? $filter : "Kategori" ?>
                </button>
                <a href="<?= base_url("/buku"); ?>">
                    <i class="fa fa-refresh fs-3 ms-4 pt-2" aria-hidden="true"></i>
                </a>

                <!-- Jika Role Admin -->
                <?php if (session()->get("role") == "admin") : ?>
                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <!-- Jika ada data buku -->
                        <?php if (isset($buku) && is_array($buku)) : ?>
                            <?php
                            $displayedCategories = [];
                            foreach ($buku as $b) :
                                // Jika kategori buku belum ditampilkan, tambahkan ke dropdown
                                if (!in_array($b['nama_kategori'], $displayedCategories)) {
                                    $displayedCategories[] = $b['nama_kategori'];
                            ?>
                                    <li><a class="dropdown-item fs-5" data-id="<?= $b['id_kategori'] ?>" href="<?= base_url('/buku/filter/') . $b['nama_kategori'] . "/" . $b['id_kategori']; ?>"><?= $b['nama_kategori'] ?></a></li>
                                <?php
                                }
                            endforeach;

                            foreach ($kategori as $k) :
                                // Jika kategori belum ditampilkan dan tidak sama dengan kategori dari buku, tambahkan ke dropdown
                                if (!in_array($k['nama'], $displayedCategories)) {
                                    $displayedCategories[] = $k['nama'];
                                ?>
                                    <li><a class="dropdown-item fs-5" data-id="<?= $k['id_kategori'] ?>" href="<?= base_url('/buku/filter/') . $k['nama'] . "/" . $k['id_kategori']; ?>"><?= $k['nama'] ?></a></li>
                            <?php
                                }
                            endforeach;
                            ?>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>


                <?php if (session()->get("role") != "admin") : ?>
                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <?php if (isset($kategori) && is_array($kategori)) : ?>
                            <?php foreach ($kategori as $k) : ?>
                                <li><a class="dropdown-item fs-5" data-id="<?= $k['id_kategori'] ?>" href="<?= base_url('/buku/filter/') . $k['nama'] . "/" . $k['id_kategori']; ?>"><?= $k['nama'] ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
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
    <table id="tableMasterBuku" class="table table-hover align-middle fs-4" style="width:100%; margin-top: 30px;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Cover</th>
                <th>Judul</th>
                <?= (session()->get("role") == "admin") ? "<th>Author</th>" : "" ?>
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
                    <td><img src="/uploads/cover/<?= $b['cover'] ?>" class="cover" alt="Cover Buku" data-file-path="/uploads/cover/<?= $b['cover'] ?>"></td>
                    <td><?= $b['judul']; ?></td>
                    <?php if (session()->get("role") == "admin") : ?>
                        <td>
                            <span class="badge <?= ($b['role'] == "admin") ? 'text-bg-danger' : 'text-bg-primary' ?> p-2 fs-5">
                                <i class="fa fa-user me-2" aria-hidden="true"></i>
                                <?= $b['username']; ?>
                            </span>
                        </td>
                    <?php endif; ?>
                    <td><?= ucwords($b['nama_kategori']); ?></td>
                    <td><?= $b['jumlah']; ?></td>
                    <td>
                        <!-- Button Detail -->
                        <a href="<?= base_url("buku/" . $b['id_buku']) ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Buku">
                            <i class="fa fa-eye fs-4" aria-hidden="true"></i>
                        </a>

                        <!-- Button Edit -->
                        <a href="<?= base_url("buku/edit/" . $b['id_buku']) ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Buku">
                            <i class="fa fa-pencil fs-4" aria-hidden="true"></i>
                        </a>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" data-judul="<?= $b['judul']; ?>" data-id="<?= $b['id_buku']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Buku">
                            <i class="fa fa-trash fs-4" aria-hidden="true"></i>
                        </button>
                    </td>
                    <?php $no++; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Include jsPDF and jsPDF-AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<script>
    // Fungsi untuk melakukan live searching
    document.getElementById("searchInput").addEventListener("keyup", function() {
        var input = this.value.toLowerCase();
        var rows = document.querySelectorAll("#bukuTable tr");

        rows.forEach(function(row) {
            var judul = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
            var kategori = row.querySelector("td:nth-child(<?= (session()->get('role') == 'admin') ? '5' : '4' ?>)").textContent.toLowerCase();

            if (judul.includes(input) || kategori.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    // Untuk modal penghapusan buku
    const exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const judul = button.getAttribute('data-judul')
        const id = button.getAttribute('data-id')
        const modalTitle = exampleModal.querySelector('.modal-title')
        const formHapus = exampleModal.querySelector('#formHapus')

        modalTitle.textContent = `Hapus data buku dengan judul ${judul}`
        formHapus.setAttribute("action", `/buku/delete/${id}`)
    })

    function exportCSV() {
        // Retrieve the table header, excluding the last column for "Aksi"
        const headerCells = document.querySelectorAll("#tableMasterBuku thead th");
        const headerData = [];
        headerCells.forEach((header, index) => {
            if (index !== headerCells.length - 1) { // Skip the last header
                headerData.push(header.textContent.trim());
            }
        });

        // Start building the CSV content with headers
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += headerData.join(",") + "\r\n";

        // Retrieve the table rows
        const rows = document.querySelectorAll("#bukuTable tr");

        // Iterate through rows to construct the CSV data
        const data = [];
        rows.forEach(row => {
            const cells = row.querySelectorAll("td");
            const rowData = [];
            cells.forEach((cell, index) => {
                if (index === 1) { // Assuming the second cell contains the image
                    // Find the image and get the data-file-path attribute
                    const img = cell.querySelector("img");
                    if (img) {
                        rowData.push(img.getAttribute('data-file-path'));
                    } else {
                        rowData.push(""); // Handle case where no image is present
                    }
                } else if (index !== cells.length - 1) { // Skip the last column
                    rowData.push(cell.textContent.trim());
                }
            });
            data.push(rowData);
        });

        // Append data rows to CSV content
        data.forEach(rowArray => {
            const row = rowArray.join(",");
            csvContent += row + "\r\n";
        });

        // Create a link element for downloading
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "data.csv");

        // Append to the body and click to download
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Attach the export function to the button
    document.getElementById('export-csv').addEventListener('click', exportCSV);

    async function exportPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        // Define columns to be included in the PDF
        const columns = [];
        const headerCells = document.querySelectorAll("#tableMasterBuku thead th");
        headerCells.forEach((header, index) => {
            if (index !== headerCells.length - 1) { // Exclude the last header "Aksi"
                columns.push({
                    header: header.textContent.trim()
                });
            }
        });

        // Prepare the table data
        const rows = [];
        document.querySelectorAll("#bukuTable tr").forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll("td");
            cells.forEach((cell, index) => {
                if (index === 1) { // Image column
                    const img = cell.querySelector("img");
                    if (img) {
                        rowData.push(img.getAttribute('data-file-path'));
                    } else {
                        rowData.push("");
                    }
                } else if (index !== cells.length - 1) { // Exclude "Aksi" column
                    rowData.push(cell.textContent.trim());
                }
            });
            rows.push(rowData);
        });

        // Use autoTable to generate the table
        doc.autoTable({
            head: [columns.map(col => col.header)],
            body: rows,
            theme: 'grid',
            headStyles: {
                fillColor: [255, 0, 0]
            }, // Customize the header color if needed
            margin: {
                top: 20
            }
        });

        // Save the PDF
        doc.save('data.pdf');
    }

    // Attach the export function to the button
    document.getElementById('export-pdf').addEventListener('click', exportPDF);
</script>

<?= $this->endSection(); ?>