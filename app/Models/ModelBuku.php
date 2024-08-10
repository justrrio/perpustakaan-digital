<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBuku extends Model
{
    protected $table = "buku";
    protected $id = "id_buku";
    protected $useTimestamps = true;

    public function getBuku($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
