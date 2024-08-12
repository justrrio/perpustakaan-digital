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
            "validation" => session()->getFlashdata('validation')
        ];

        return view('auth/login', $data);
    }

    public function loginSubmit()
    {
        helper(['form', 'url']);

        // Validation rules
        $validationRules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Format email tidak valid.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password minimal 8 karakter.'
                ]
            ],
        ];

        if ($this->validate($validationRules)) {
            $modelUser = new ModelUser();
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $user = $modelUser->where('email', $email)->first();

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Set session
                    $sessionData = [
                        'id_user' => $user['id_user'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'isLoggedIn' => true
                    ];

                    session()->set($sessionData);
                    return redirect()->to(base_url("/buku"));
                } else {
                    session()->setFlashdata('validation', ['password' => 'Password is incorrect']);
                }
            } else {
                session()->setFlashdata('validation', ['email' => 'Email not found']);
            }
        } else {
            session()->setFlashdata('validation', $this->validator->getErrors());
        }

        return redirect()->to(base_url("/login"))->withInput();
    }

    public function register()
    {
        $data = [
            'title' => "Halaman Register",
            'validation' => session()->getFlashdata('validation')
        ];

        return view('auth/register', $data);
    }

    public function registerSubmit()
    {
        helper(['form', 'url']);

        $validationRules = [
            'username' => [
                'rules' => 'required|min_length[5]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'min_length' => 'Username minimal 5 karakter.',
                    'max_length' => 'Username maksimal 20 karakter.',
                    'is_unique' => 'Username sudah terdaftar.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password minimal 8 karakter.'
                ]
            ],
            'confirm-password' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok dengan password.'
                ]
            ]
        ];

        if ($this->validate($validationRules)) {
            $modelUser = new ModelUser();

            $dataAkun = [
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role' => 'user'
            ];

            $modelUser->save($dataAkun);
            session()->setFlashdata('message', 'Akun <strong>berhasil</strong> dibuat!');
            return redirect()->to('/login');
        } else {
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('validation', $validationErrors);
            return redirect()->to('/register')->withInput();
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
