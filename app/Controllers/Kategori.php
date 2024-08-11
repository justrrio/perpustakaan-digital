<?php

namespace App\Controllers;

use App\Models\ModelBuku;
use App\Models\ModelKategori;
use App\Models\ModelUser;

class Kategori extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Daftar Kategori",
            'currentPage' => 'kategori'
        ];
        return view('kategori/index', $data);
    }
}
