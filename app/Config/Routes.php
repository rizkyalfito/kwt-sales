<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/produk', 'Produk::index');
$routes->get('/kategori', 'Kategori::index');
$routes->get('/pesan', 'Pesan::index');
$routes->get('/laporan', 'Laporan::index');
$routes->get('/kontak', 'Kontak::index');
