<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table = "kategori";
    protected $primaryKey = "id_kategori";
    protected $useTimestamps = true;
    protected $allowedFields = ['id_user', 'nama'];
    protected $useSoftDeletes = true; // Enable soft deletes
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getKategori($userId = false)
    {
        // Untuk Admin
        if (!$userId) {
            return $this->where("kategori.deleted_at", null)->get()->getResultArray();
        }

        return $this->where(['id_user' => $userId, 'kategori.deleted_at' => null])->get()->getResultArray();
    }

    public function getKategoriByNama($namaKategori = false)
    {
        return $this->where(['nama' => $namaKategori, 'kategori.deleted_at' => null])->first();
    }
}
