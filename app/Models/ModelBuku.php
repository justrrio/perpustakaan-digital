<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBuku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    protected $useSoftDeletes = true; // Enable soft deletes
    protected $allowedFields = ['judul', 'id_kategori', 'id_user', 'jumlah', 'file_buku', 'cover', 'deskripsi', 'slug'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getBuku($role, $userId, $bukuId = false)
    {
        $this->select('buku.*, kategori.nama as nama_kategori, kategori.id_kategori as id_kategori, users.username, users.role');
        $this->join('kategori', 'buku.id_kategori = kategori.id_kategori');
        $this->join('users', 'buku.id_user = users.id_user');

        if ($bukuId == false) {
            if ($role == 'admin') {
                return $this->where('buku.deleted_at', null)->get()->getResultArray();
            } else {
                return $this->where(['buku.deleted_at' => null, 'buku.id_user' => $userId])->get()->getResultArray();
            }
        }

        return $this->where(['id_buku' => $bukuId, 'buku.deleted_at' => null])->first();
    }

    public function getJumlahBukuKategori()
    {
        // Start building the query from the kategori table
        $this->select('kategori.id_kategori AS id_kategori, kategori.nama AS kategori, COUNT(b.id_buku) AS jumlah_buku');
        $this->from('kategori');

        // Alias the buku table as b
        $this->join('buku b', 'b.id_kategori = kategori.id_kategori AND b.deleted_at IS NULL', 'left');

        // Exclude deleted categories
        $this->where('kategori.deleted_at IS NULL');

        // Group by id_kategori and nama
        $this->groupBy('kategori.id_kategori, kategori.nama');

        return $this->get()->getResultArray();
    }




    public function getBukuWithCategoryCount($role, $userId, $bukuId = false)
    {
        $this->select('buku.*, kategori.nama AS nama_kategori, kategori.id_kategori AS id_kategori, users.username, users.role, COUNT(b2.id_buku) AS jumlah_buku_per_kategori');
        $this->join('kategori', 'buku.id_kategori = kategori.id_kategori');
        $this->join('users', 'buku.id_user = users.id_user');
        $this->join('buku b2', 'buku.id_kategori = b2.id_kategori AND b2.deleted_at IS NULL', 'left'); // Self-join to count books per category

        if ($bukuId === false) {
            if ($role === 'admin') {
                $this->where('buku.deleted_at', null);
            } else {
                $this->where(['buku.deleted_at' => null, 'buku.id_user' => $userId]);
            }
        } else {
            $this->where(['buku.id_buku' => $bukuId, 'buku.deleted_at' => null]);
        }

        $this->groupBy('buku.id_buku'); // Group by book ID to get details for each book


        return $this->get()->getResultArray();
    }
}
