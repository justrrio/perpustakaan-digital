<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBuku extends Model
{
    protected $table = "buku";
    protected $id = "id_buku";
    protected $useTimestamps = true;
    protected $allowedFields = ['cover', 'judul', 'id_kategori', 'deskripsi', 'jumlah', 'file_path', 'slug'];

    public function getBuku($slug = false)
    {
        $this->select('buku.*, kategori.nama as nama_kategori');
        $this->join('kategori', 'buku.id_kategori = kategori.id_kategori');

        if ($slug == false) {
            return $this->get()->getResultArray();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
