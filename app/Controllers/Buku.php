<?php

namespace App\Controllers;

use App\Models\ModelBuku;

class Buku extends BaseController
{
    public function __construct()
    {
        $this->modelBuku = new ModelBuku();
    }

    public function index()
    {
        $buku = $this->modelBuku->getBuku();

        $data = [
            'title' => "Daftar Buku",
            'buku' => $buku,
        ];

        return view("buku/index", $data);
    }

    public function detail($slug)
    {
        $buku = $this->modelBuku->getBuku($slug);

        $data = [
            'title' => "Daftar Buku",
            'buku' => $buku,
        ];

        return view("buku/detail", $data);
    }
}
