<?php

namespace App\Controllers;

use App\Models\ModelUser;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $session;
    protected $modelUser;

    public function __construct()
    {
        $this->session = service('session');
        $this->modelUser = new ModelUser();
    }

    public function login()
    {
        $data = [
            "title" => "Halaman Login",
        ];

        return view('auth/login', $data);
    }

    public function register()
    {
        $data = [
            'title' => "Register"
        ];

        return view('auth/register', $data);
    }

    // public function login()
    // {
    //     helper(['form', 'url']);

    //     $rules = [
    //         'email' => 'required|min_length[6]|max_length[50]|valid_email',
    //         'password' => 'required|min_length[8]|max_length[255]'
    //     ];

    //     if (!$this->validate($rules)) {
    //         // Jika validasi gagal, kembalikan ke halaman login dengan errors
    //         return redirect()->to('/login')->withInput()->with('errors', $this->validator->getErrors());
    //     } else {
    //         $email = $this->request->getVar('email');
    //         $password = $this->request->getVar('password');
    //         $user = $this->modelUser->where('email', $email)->first();

    //         if (!empty($user) && password_verify($password, $user['password'])) {
    //             // Login berhasil!
    //             $this->setUserSession($user);
    //             return redirect()->to('/buku');
    //         } else {
    //             // Login gagal!
    //             $this->session->setFlashdata('error', 'Email atau Password salah');
    //             return redirect()->to('/login');
    //         }
    //     }
    // }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ];
        $this->session->set($data);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
