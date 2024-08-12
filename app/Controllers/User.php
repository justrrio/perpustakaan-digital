<?php

namespace App\Controllers;

use App\Models\ModelUser;

class User extends BaseController
{
    public function __construct()
    {
        $this->modelUser = new ModelUser();
        $this->idUser = session()->get("id_user");
        $this->role = session()->get("role");
    }

    public function index()
    {
        if (!isset($this->idUser) || !isset($this->role)) {
            return redirect()->to(base_url('/login'));
        }
        $user = $this->modelUser->getUser();

        $data = [
            'title' => "Daftar Kategori",
            'user' => $user,
            'currentPage' => 'user'
        ];
        return view('user/index', $data);
    }

    public function delete($idUser)
    {
        if (!isset($this->idUser)) {
            return redirect()->to(base_url('/login'));
        }

        $user = $this->modelUser->find($idUser);

        if ($user) {
            $this->modelUser->delete($idUser);
            session()->setFlashdata('message', 'Akun <strong>berhasil</strong> dihapus!');
        } else {
            session()->setFlashdata('message', 'Akun tidak ditemukan!');
        }

        return redirect()->to("/user");
    }
}
