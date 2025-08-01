<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/produk-public', 'ProdukPublic::index');
$routes->get('/produk-public/cari', 'ProdukPublic::cari');


$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/pemesanan', 'Pemesanan::index');
    $routes->post('/pemesanan/submit', 'Pemesanan::submitOrder');
    $routes->get('/riwayat-pemesanan', 'RiwayatPemesanan::index');
    $routes->get('/riwayat-pemesanan/detail/(:num)', 'RiwayatPemesanan::detail/$1');
    $routes->post('/riwayat-pemesanan/batalkan/(:num)', 'RiwayatPemesanan::batalkan/$1');
});


$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('/login', 'Auth::login');
    $routes->post('login', 'Auth::postLogin');
    $routes->get('/register', 'Auth::register');
});

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/logout', 'Auth::logout');
    $routes->get('/dashboard', 'Dashboard::index');

    $routes->get('/kategori', 'Kategori::index');
    $routes->get('/kategori/tambah', 'Kategori::new');
    $routes->post('/kategori/simpan', 'Kategori::save');
    $routes->get('/kategori/ubah/(:num)', 'Kategori::edit/$1');
    $routes->post('/kategori/update/(:num)', 'Kategori::update/$1');
    $routes->get('/kategori/hapus/(:num)', 'Kategori::delete/$1');

    $routes->get('/produk', 'Produk::index');
    $routes->get('/produk/tambah', 'Produk::new');
    $routes->post('/produk/simpan', 'Produk::save');
    $routes->get('/produk/ubah/(:num)', 'Produk::edit/$1');
    $routes->post('/produk/update/(:num)', 'Produk::update/$1');
    $routes->get('/produk/hapus/(:num)', 'Produk::delete/$1');

    $routes->get('/kontak', 'Kontak::index');
    $routes->get('/kontak/tambah', 'Kontak::new');
    $routes->post('/kontak/simpan', 'Kontak::save');
    $routes->get('/kontak/ubah/(:num)', 'Kontak::edit/$1');
    $routes->post('/kontak/update/(:num)', 'Kontak::update/$1');

    $routes->get('/pesan', 'Pesan::index');
    $routes->get('/laporan', 'Laporan::index');
});