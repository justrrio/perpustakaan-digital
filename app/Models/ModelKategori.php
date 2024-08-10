<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table = "kategori";
    protected $id = "id_kategori";
    protected $useTimestamps = true;

    public function getKategori()
    {
        return $this->findAll();
    }
}
