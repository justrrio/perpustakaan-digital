<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get("/buku", "Buku::index");
$routes->get("/buku/(:segment)", "Buku::detail/$1");

$routes->get("/login", "Auth::index");
