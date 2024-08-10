<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get("/login", "Auth::index");

$routes->get("/buku", "Buku::index");

// Tambah Buku
$routes->get("/buku/tambah", "Buku::tambah");
$routes->post("/buku/tambah-buku", "Buku::tambahBuku");

// Edit Buku
$routes->get("/buku/edit/(:any)", "Buku::edit/$1");
$routes->post("/buku/edit-buku/(:any)", "Buku::editBuku/$1");

// Detail Buku
$routes->get("/buku/(:any)", "Buku::detail/$1");

// Hapus Buku
$routes->delete("/buku/(:num)", "Buku::delete/$1");

// Search Buku
$routes->post('buku/search', 'Buku::search');
