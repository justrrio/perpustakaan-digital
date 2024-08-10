<?php

namespace App\Controllers;

use App\Models\ModelBuku;
use App\Models\ModelKategori;

class Buku extends BaseController
{
    public function __construct()
    {
        $this->modelBuku = new ModelBuku();
        $this->modelKategori = new ModelKategori();
    }

    public function index()
    {
        $buku = $this->modelBuku->getBuku();

        $data = [
            'title' => "Daftar Buku",
            'buku' => $buku,
        ];

        return view("buku/index", $data);
    }

    public function detail($slug)
    {
        $buku = $this->modelBuku->getBuku($slug);

        if (empty($buku)) {
            echo "<h1> Contoh </h1>";
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul buku " . $slug . " tidak ditemukan.");
        }

        $data = [
            'title' => "Detail Buku",
            'buku' => $buku,
        ];

        return view("buku/detail", $data);
    }

    public function tambah()
    {
        $kategori = $this->modelKategori->getKategori();
        // var_dump($kategori);
        // die;
        $data = [
            'title' => "Tambah Buku",
            'kategori' => $kategori,
        ];

        return view("buku/tambah", $data);
    }

    public function tambahBuku()
    {
        $fileBuku = $this->request->getFile('file-buku');
        $fileCover = $this->request->getFile('cover');

        if ($fileBuku->isValid() && !$fileBuku->hasMoved()) {
            $namaFileBuku = $fileBuku->getRandomName();
            $fileBuku->move('uploads/file-buku', $namaFileBuku);
        } else {
            $namaFileBuku = null;
        }

        if ($fileCover->isValid() && !$fileCover->hasMoved()) {
            $namaFileCover = $fileCover->getRandomName();
            $fileCover->move('uploads/cover', $namaFileCover);
        } else {
            $namaFileCover = null;
        }

        $slug = url_title($this->request->getVar("judul"), "-", true);
        $this->modelBuku->save([
            "judul" => $this->request->getVar("judul"),
            "id_kategori" => intval($this->request->getVar("id_kategori")),
            "jumlah" => $this->request->getVar("jumlah"),
            "file_buku" => $namaFileBuku, // Simpan nama file buku
            "cover" => $namaFileCover, // Simpan nama file cover
            "deskripsi" => $this->request->getVar("deskripsi"),
            "slug" => $slug,
        ]);

        session()->setFlashdata("message", "Data buku berhasil ditambahkan.");

        return redirect()->to("/buku");
    }
}
