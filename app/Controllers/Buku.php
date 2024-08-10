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
        $kategori = $this->modelKategori->getKategori();

        $data = [
            'title' => "Daftar Buku",
            'kategori' => $kategori,
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
        $data = [
            'title' => "Tambah Buku",
            'kategori' => $kategori,
            'validation' => session()->getFlashdata('validation') // Mengambil flashdata validation
        ];

        return view("buku/tambah", $data);
    }

    public function tambahBuku()
    {
        // Aturan Validasi
        $validationRules = [
            'judul' => [
                'rules' => 'required|is_unique[buku.judul]',
                'errors' => [
                    'required' => 'Judul buku harus diisi.',
                    'is_unique' => 'Judul buku sudah ada.'
                ]
            ],
            'id_kategori' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Kategori harus dipilih.',
                    'integer' => 'Kategori tidak valid.'
                ]
            ],
            'jumlah' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah buku harus diisi.',
                    'integer' => 'Jumlah harus berupa angka.'
                ]
            ],
            'file-buku' => [
                'rules' => 'uploaded[file-buku]|mime_in[file-buku,application/pdf]',
                'errors' => [
                    'uploaded' => 'File buku harus diunggah.',
                    'mime_in' => 'File buku harus berupa PDF.'
                ]
            ],
            'cover' => [
                'rules' => 'uploaded[cover]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Cover buku harus diunggah.',
                    'is_image' => 'Cover buku harus berupa gambar.',
                    'mime_in' => 'Cover buku harus berupa file JPG, JPEG, atau PNG.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi buku harus diisi.'
                ]
            ]
        ];

        // Jika validasi gagal, kembalikan ke halaman tambah dengan input dan pesan error
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors(); // Mengambil array error
            session()->setFlashdata('validation', $validationErrors); // Simpan array error
            return redirect()->to('/buku/tambah')->withInput();
        }

        // Proses upload file dan simpan ke database
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
            "file_buku" => $namaFileBuku,
            "cover" => $namaFileCover,
            "deskripsi" => $this->request->getVar("deskripsi"),
            "slug" => $slug,
        ]);

        session()->setFlashdata("message", "Data buku <strong>berhasil</strong> ditambahkan!");

        return redirect()->to("/buku");
    }

    public function delete($id_buku)
    {
        $buku = $this->modelBuku->find($id_buku);

        if ($buku) {
            // Hapus file buku dari server jika ada
            if (!empty($buku['file_buku']) && file_exists('uploads/file-buku/' . $buku['file_buku'])) {
                unlink('uploads/file-buku/' . $buku['file_buku']);
            }

            // Hapus cover buku dari server jika ada
            if (!empty($buku['cover']) && file_exists('uploads/cover/' . $buku['cover'])) {
                unlink('uploads/cover/' . $buku['cover']);
            }

            // Hapus data buku dari database
            $this->modelBuku->delete($id_buku);

            // Set flashdata untuk pesan sukses
            session()->setFlashdata('message', 'Data buku <strong>berhasil</strong> dihapus!');
        } else {
            // Set flashdata untuk pesan error jika data tidak ditemukan
            session()->setFlashdata('message', 'Data buku tidak ditemukan!');
        }

        // Redirect kembali ke halaman daftar buku
        return redirect()->to("/buku");
    }

    public function edit($slug)
    {
        $buku = $this->modelBuku->getBuku($slug);
        $kategori = $this->modelKategori->getKategori();

        $data = [
            'title' => "Form Ubah Buku",
            'validation' => session()->getFlashdata('validation'),
            'kategori' => $kategori,
            'buku' => $buku
        ];

        return view("buku/edit", $data);
    }

    public function editBuku($id_buku)
    {
        $bukuLama = $this->modelBuku->find($id_buku);

        if (!$bukuLama) {
            session()->setFlashdata('message', 'Data buku tidak ditemukan!');
            return redirect()->to('/buku');
        }

        // Aturan Validasi
        $validationRules = [
            'judul' => [
                'rules' => 'required|is_unique[buku.judul,id_buku,' . $id_buku . ']',
                'errors' => [
                    'required' => 'Judul buku harus diisi.',
                    'is_unique' => 'Judul buku sudah ada.'
                ]
            ],
            'id_kategori' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Kategori harus dipilih.',
                    'integer' => 'Kategori tidak valid.'
                ]
            ],
            'jumlah' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah buku harus diisi.',
                    'integer' => 'Jumlah harus berupa angka.'
                ]
            ],
            'file-buku' => [
                'rules' => 'mime_in[file-buku,application/pdf]',
                'errors' => [
                    'mime_in' => 'File buku harus berupa PDF.'
                ]
            ],
            'cover' => [
                'rules' => 'is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'Cover buku harus berupa gambar.',
                    'mime_in' => 'Cover buku harus berupa file JPG, JPEG, atau PNG.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi buku harus diisi.'
                ]
            ]
        ];

        // Jika validasi gagal, kembalikan ke halaman edit dengan input dan pesan error
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors(); // Mengambil array error
            session()->setFlashdata('validation', $validationErrors); // Simpan array error
            return redirect()->to('/buku/edit/' . $bukuLama['slug'])->withInput();
        }

        // Proses upload file baru dan simpan ke database
        $fileBuku = $this->request->getFile('file-buku');
        $fileCover = $this->request->getFile('cover');

        // Kelola file buku
        if ($fileBuku->isValid() && !$fileBuku->hasMoved()) {
            // Hapus file buku lama
            if (!empty($bukuLama['file_buku']) && file_exists('uploads/file-buku/' . $bukuLama['file_buku'])) {
                unlink('uploads/file-buku/' . $bukuLama['file_buku']);
            }
            // Simpan file buku baru
            $namaFileBuku = $fileBuku->getRandomName();
            $fileBuku->move('uploads/file-buku', $namaFileBuku);
        } else {
            // Gunakan file buku lama jika tidak ada yang baru
            $namaFileBuku = $bukuLama['file_buku'];
        }

        // Kelola cover buku
        if ($fileCover->isValid() && !$fileCover->hasMoved()) {
            // Hapus cover lama
            if (!empty($bukuLama['cover']) && file_exists('uploads/cover/' . $bukuLama['cover'])) {
                unlink('uploads/cover/' . $bukuLama['cover']);
            }
            // Simpan cover baru
            $namaFileCover = $fileCover->getRandomName();
            $fileCover->move('uploads/cover', $namaFileCover);
        } else {
            // Gunakan cover lama jika tidak ada yang baru
            $namaFileCover = $bukuLama['cover'];
        }

        // Slug baru jika judul berubah
        $slug = url_title($this->request->getVar("judul"), "-", true);

        // Simpan perubahan ke database
        $this->modelBuku->update($id_buku, [
            "judul" => $this->request->getVar("judul"),
            "id_kategori" => intval($this->request->getVar("id_kategori")),
            "jumlah" => $this->request->getVar("jumlah"),
            "file_buku" => $namaFileBuku,
            "cover" => $namaFileCover,
            "deskripsi" => $this->request->getVar("deskripsi"),
            "slug" => $slug,
        ]);

        session()->setFlashdata("message", "Data buku <strong>berhasil</strong> diubah!");

        return redirect()->to("/buku");
    }

    public function search()
    {
        // Mendapatkan data dari permintaan POST
        $requestData = $this->request->getJSON();
        $keyword = $requestData->keyword;
        $kategori = $requestData->kategori;

        // Menyiapkan query
        $builder = $this->modelBuku->join('kategori', 'buku.id_kategori = kategori.id_kategori');

        // Menerapkan filter pencarian
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('judul', $keyword)
                ->orLike('kategori.nama', $keyword)
                ->groupEnd();
        }

        // Menerapkan filter kategori jika dipilih
        if (!empty($kategori)) {
            $builder->where('buku.id_kategori', $kategori);
        }

        // Mendapatkan data buku beserta kategori
        $buku = $builder->select('buku.*, kategori.nama as nama_kategori')->findAll();

        // Memodifikasi nama kategori agar huruf kapital di awal kata
        foreach ($buku as &$item) {
            $item['nama_kategori'] = ucwords($item['nama_kategori']);
        }

        // Mengembalikan hasil sebagai JSON
        return $this->response->setJSON($buku);
    }
}
