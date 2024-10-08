<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes Home
$routes->get('/', 'Home::index');

// Routes Auth
$routes->group('/', function ($routes) {
    $routes->get("login", "Auth::login");
    $routes->post("login-submit", "Auth::loginSubmit");
    $routes->get("register", "Auth::register");
    $routes->post("register-submit", "Auth::registerSubmit");
    $routes->get("logout", "Auth::logout");
});

// Routes Buku
$routes->group('buku', function ($routes) {
    $routes->get("/", "Buku::index");

    // Tambah Buku
    $routes->get("tambah", "Buku::tambah");
    $routes->post("tambah-buku", "Buku::tambahBuku");

    // Search Buku
    $routes->post('search', 'Buku::search');
    $routes->get('filter/(:any)/(:any)', 'Buku::filter/$1/$2');

    // Edit Buku
    $routes->get("edit/(:any)", "Buku::edit/$1");
    $routes->post("edit-buku/(:any)", "Buku::editBuku/$1");

    // Detail Buku
    $routes->get("(:any)", "Buku::detail/$1");

    // Hapus Buku
    $routes->delete("(:num)", "Buku::delete/$1");
});

// Routes Kategori
$routes->group('kategori', function ($routes) {
    $routes->get("/", "Kategori::index");

    // Tambah Kategori
    $routes->get("tambah", "Kategori::tambah");
    $routes->post("tambah-kategori", "Kategori::tambahKategori");

    // Edit Kategori
    $routes->get("edit/(:any)", "Kategori::edit/$1");
    $routes->post("edit-kategori/(:any)", "Kategori::editKategori/$1");

    // Hapus Kategori
    $routes->delete("(:num)", "Kategori::delete/$1");
});

// Routes User
$routes->group('user', function ($routes) {
    $routes->get("/", "User::index");

    // Hapus User
    $routes->delete("(:num)", "User::delete/$1");

    // Search User
    $routes->post('search', 'User::search');
});
