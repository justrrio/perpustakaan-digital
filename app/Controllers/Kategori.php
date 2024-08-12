<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelBuku;

class Kategori extends BaseController
{
    public function __construct()
    {
        $this->modelKategori = new ModelKategori();
        $this->modelBuku = new ModelBuku();

        $this->idUser = session()->get("id_user");
        $this->role = session()->get("role");
    }

    public function index()
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }

        // Kategori untuk Admin
        if ($this->role == "admin") {
            $kategori = $this->modelKategori->getKategori();
        } else {
            $kategori = $this->modelKategori->getKategori(session()->get("id_user"));
        }
        $jumlahBukuKategori = $this->modelBuku->getJumlahBukuKategori();

        $data = [
            'title' => "Daftar Kategori",
            'totalKategori' => $this->modelKategori->countAll(),
            'kategori' => $kategori,
            'jumlahBukuKategori' => $jumlahBukuKategori,
            'currentPage' => 'kategori'
        ];
        return view('kategori/index', $data);
    }

    public function tambah()
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }

        $data = [
            'title' => "Tambah Kategori",
            'validation' => session()->getFlashdata('validation'),
            'currentPage' => "kategori"
        ];

        return view("kategori/tambah", $data);
    }

    public function tambahKategori()
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }

        // Aturan Validasi
        $validationRules = [
            'nama-kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama kategori harus diisi.',
                    'is_unique' => 'Nama kategori sudah ada.'
                ]
            ],
        ];

        // Jika validasi gagal, kembalikan ke halaman tambah dengan input dan pesan error
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors(); // Mengambil array error
            session()->setFlashdata('validation', $validationErrors); // Simpan array error
            return redirect()->to('/kategori/tambah')->withInput();
        }

        $this->modelKategori->save([
            "id_user" => intval($this->request->getVar("id-user")),
            "nama" => $this->request->getVar("nama-kategori")
        ]);

        session()->setFlashdata("message", "Data kategori baru <strong>berhasil</strong> ditambahkan!");

        return redirect()->to("/kategori");
    }

    public function edit($namaKategori)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }
        $kategori = $this->modelKategori->getKategoriByNama($namaKategori);

        $data = [
            'title' => "Form Ubah Kategori",
            'validation' => session()->getFlashdata('validation'),
            'kategori' => $kategori,
            'currentPage' => "kategori"
        ];

        return view("kategori/edit", $data);
    }

    public function editKategori($namaKategori)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }
        $kategoriLama = $this->modelKategori->getKategoriByNama($namaKategori);

        if (!$kategoriLama) {
            session()->setFlashdata('message', 'Nama kategori tidak ditemukan!');
            return redirect()->to('/kategori');
        }

        // Aturan Validasi
        $validationRules = [
            'nama-kategori' => [
                'rules' => 'required|is_unique[kategori.nama]',
                'errors' => [
                    'required' => 'Nama kategori harus diisi.',
                    'is_unique' => 'Nama kategori sudah ada.'
                ]
            ],
        ];

        // Jika validasi gagal, kembalikan ke halaman edit dengan input dan pesan error
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors(); // Mengambil array error
            session()->setFlashdata('validation', $validationErrors); // Simpan array error
            return redirect()->to('/kategori/edit/' . $kategoriLama['nama'])->withInput();
        }

        // Simpan perubahan ke database
        $this->modelKategori->update($kategoriLama['id_kategori'], [
            "nama" => $this->request->getVar("nama-kategori"),
        ]);

        session()->setFlashdata("message", "Nama kategori <strong>berhasil</strong> diubah!");

        return redirect()->to("/kategori");
    }

    public function delete($id_kategori)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }
        $kategori = $this->modelKategori->find($id_kategori);

        if ($kategori) {
            // Hapus data kategori dari database
            $this->modelKategori->delete($id_kategori);

            // Set flashdata untuk pesan sukses
            session()->setFlashdata('message', 'Nama kategori <strong>berhasil</strong> dihapus!');
        } else {
            // Set flashdata untuk pesan error jika data tidak ditemukan
            session()->setFlashdata('message', 'Nama kategori tidak ditemukan!');
        }

        // Redirect kembali ke halaman daftar kategori
        return redirect()->to("/kategori");
    }
}
