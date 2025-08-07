<?php

namespace Config;

class SidebarMenu
{
    public static $menuItems = [
        [
            'title' => 'Home',
            'icon'  => 'fas fa-house',
            'url'   => '/',
            'isAdmin' => true,
        ],
        [
            'title' => 'Dashboard',
            'icon'  => 'fas fa-tachometer-alt',
            'url'   => '/dashboard',
            'isAdmin' => false,
        ],
        [
            'title' => 'Kategori Produk',
            'icon'  => 'fas fa-list',
            'url'   => '/kategori',
            'isAdmin' => true,
        ],
        [
            'title' => 'Data Produk',
            'icon'  => 'fas fa-box',
            'url'   => '/produk',
            'isAdmin' => true,
        ],
        [
            'title' => 'Kelola Pesanan',
            'icon'  => 'fas fa-cart-shopping',
            'url'   => '/pesanan',
            'isAdmin' => true,
        ],
        [
            'title' => 'Laporan Penjualan',
            'icon'  => 'fas fa-chart-line',
            'url'   => '/laporan',
            'isAdmin' => true,
        ],
        [
            'title' => 'Kontak',
            'icon'  => 'fas fa-address-book',
            'url'   => '/kontak',
            'isAdmin' => true,
        ],
        [
            'title' => 'Logout',
            'icon'  => 'fas fa-sign-out-alt',
            'url'   => '/logout',
            'isAdmin' => false
        ],
    ];
}
