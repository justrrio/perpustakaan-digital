<?php

namespace App\Controllers;

use App\Models\ModelBuku;
use App\Models\ModelKategori;
use App\Models\ModelUser;

class Buku extends BaseController
{
    public function __construct()
    {

        $this->modelBuku = new ModelBuku();
        $this->modelKategori = new ModelKategori();
        $this->modelUser = new ModelUser();

        $this->role = session()->get("role");
        $this->idUser = session()->get("id_user");
    }

    public function index()
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }

        $buku = $this->modelBuku->getBuku($this->role, $this->idUser);
        $kategori = $this->modelKategori->getKategori(session()->get("id_user"));

        $totalKategori = $this->modelKategori
            ->where('id_user', session()->get("id_user"))
            ->countAllResults();

        if ($this->role != "admin") {
            $totalBuku = $this->modelBuku
                ->where('id_user', session()->get("id_user"))
                ->countAllResults();
        } else {
            $totalBuku = $this->modelBuku->countAll();
        }

        $data = [
            'title' => "Daftar Buku",
            'kategori' => $kategori,
            'totalBuku' => $totalBuku,
            'totalKategori' => $totalKategori,
            'totalUser' => $this->modelUser->countAll(),
            'buku' => $buku,
            'currentPage' => 'buku'
        ];

        return view("buku/index", $data);
    }

    public function detail($idBuku)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }
        $buku = $this->modelBuku->getBuku($this->role, $this->idUser, $idBuku);

        if (empty($buku)) {
            echo "<h1> Contoh </h1>";
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul buku tidak ditemukan.");
        }

        $data = [
            'title' => "Detail Buku",
            'buku' => $buku,
            'currentPage' => "buku"
        ];

        return view("buku/detail", $data);
    }

    public function tambah()
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }

        $kategori = $this->modelKategori->getKategori(session()->get("id_user"));
        $data = [
            'title' => "Tambah Buku",
            'kategori' => $kategori,
            'validation' => session()->getFlashdata('validation'),
            'currentPage' => "buku"
        ];

        return view("buku/tambah", $data);
    }

    public function tambahBuku()
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }
        // Aturan Validasi
        $validationRules = [
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required|checkJudul',
                'errors' => [
                    'required' => 'Judul buku harus diisi.',
                    'checkJudul' => 'Judul buku sudah ada.'
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Kategori harus dipilih.',
                    'integer' => 'Kategori tidak valid.'
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah buku harus diisi.',
                    'integer' => 'Jumlah harus berupa angka.'
                ]
            ],
            'file-buku' => [
                'label' => 'File Buku',
                'rules' => 'uploaded[file-buku]|mime_in[file-buku,application/pdf]',
                'errors' => [
                    'uploaded' => 'File buku harus diunggah.',
                    'mime_in' => 'File buku harus berupa PDF.'
                ]
            ],
            'cover' => [
                'label' => 'Cover',
                'rules' => 'uploaded[cover]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Cover buku harus diunggah.',
                    'is_image' => 'Cover buku harus berupa gambar.',
                    'mime_in' => 'Cover buku harus berupa file JPG, JPEG, atau PNG.'
                ]
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi buku harus diisi.'
                ]
            ]
        ];

        // Validate the input data
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('validation', $validationErrors);
            return redirect()->to('/buku/tambah')->withInput();
        }

        // Process file uploads and save to the database
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

        $this->modelBuku->save([
            "judul" => $this->request->getVar("judul"),
            "id_user" => $this->request->getVar("id_user"),
            "id_kategori" => intval($this->request->getVar("id_kategori")),
            "jumlah" => $this->request->getVar("jumlah"),
            "file_buku" => $namaFileBuku,
            "cover" => $namaFileCover,
            "deskripsi" => $this->request->getVar("deskripsi"),
            "user_id" => $this->idUser, // Ensure the user_id is saved
        ]);

        session()->setFlashdata("message", "Data buku <strong>berhasil</strong> ditambahkan!");
        return redirect()->to("/buku");
    }

    public function delete($id_buku)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }
        $buku = $this->modelBuku->find($id_buku);

        if ($buku) {
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

    public function edit($idBuku)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }

        $buku = $this->modelBuku->getBuku($this->role, $this->idUser, $idBuku);
        $kategori = $this->modelKategori->getKategori(session()->get("id_user"));

        $data = [
            'title' => "Form Ubah Buku",
            'validation' => session()->getFlashdata('validation'),
            'kategori' => $kategori,
            'buku' => $buku,
            'currentPage' => "buku"
        ];

        return view("buku/edit", $data);
    }

    public function editBuku($id_buku)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }
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
            return redirect()->to('/buku/edit/' . $bukuLama['id_buku'])->withInput();
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

        // Simpan perubahan ke database
        $this->modelBuku->update($id_buku, [
            "judul" => $this->request->getVar("judul"),
            "id_kategori" => intval($this->request->getVar("id_kategori")),
            "jumlah" => $this->request->getVar("jumlah"),
            "file_buku" => $namaFileBuku,
            "cover" => $namaFileCover,
            "deskripsi" => $this->request->getVar("deskripsi"),
        ]);

        session()->setFlashdata("message", "Data buku <strong>berhasil</strong> diubah!");

        return redirect()->to("/buku");
    }

    public function filter($namaKategori, $idKategori)
    {
        $kategori = $this->modelBuku
            ->select('buku.*, kategori.nama as nama_kategori, users.username, users.role')
            ->join('kategori', 'buku.id_kategori = kategori.id_kategori')
            ->join('users', 'buku.id_user = users.id_user');

        if (session()->get('role') !== 'admin') {
            // If the user is not an admin, filter by user ID
            $kategori->where('buku.id_user', session()->get('id_user'));
            $kategori->where('buku.id_kategori', $idKategori);
        }
        // dd($kategori->findAll());

        // Apply search keyword filter
        if (!empty($namaKategori)) {
            $kategori->groupStart()
                ->like('judul', $namaKategori)
                ->orLike('kategori.nama', $namaKategori)
                ->groupEnd();
        }

        // Get filtered book data
        $buku = $kategori->findAll();
        $kategori = $this->modelKategori->getKategori(session()->get("id_user"));

        $totalKategori = $this->modelKategori
            ->where('id_user', session()->get("id_user"))
            ->countAllResults();

        $totalBuku = $this->modelBuku
            ->where('id_user', session()->get("id_user"))
            ->countAllResults();

        $data = [
            'title' => "Daftar Buku",
            'kategori' => $kategori,
            'totalBuku' => $totalBuku,
            'totalKategori' => $totalKategori,
            'totalUser' => $this->modelUser->countAll(),
            'buku' => $buku,
            'currentPage' => 'buku'
        ];

        return view("buku/index", $data);
    }
}
