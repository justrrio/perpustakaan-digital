<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes Home
$routes->get('/', 'Home::index');

// Routes Auth
$routes->group('auth', function ($routes) {
    $routes->get("login", "Auth::login");
    $routes->post("login-submit", "Auth::loginSubmit");
    $routes->get("register", "Auth::register");
    $routes->post("register-submit", "Auth::registerSubmit");
});

// Routes Buku
$routes->group('buku', function ($routes) {
    $routes->get("/", "Buku::index");

    // Tambah Buku
    $routes->get("tambah", "Buku::tambah");
    $routes->post("tambah-buku", "Buku::tambahBuku");

    // Edit Buku
    $routes->get("edit/(:any)", "Buku::edit/$1");
    $routes->post("edit-buku/(:any)", "Buku::editBuku/$1");

    // Detail Buku
    $routes->get("(:any)", "Buku::detail/$1");

    // Hapus Buku
    $routes->delete("(:num)", "Buku::delete/$1");

    // Search Buku
    $routes->post('search', 'Buku::search');
});

// Routes Kategori
$routes->group('kategori', function ($routes) {
    $routes->get("/", "Kategori::index");
});
