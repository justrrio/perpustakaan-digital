<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table = "kategori";
    protected $primaryKey = "id_kategori";
    protected $useTimestamps = true;
    protected $allowedFields = ['nama'];

    public function getKategori($namaKategori = false)
    {
        if ($namaKategori == false) {
            return $this->findAll();
        }

        return $this->where(['nama' => $namaKategori])->first();
    }
}
