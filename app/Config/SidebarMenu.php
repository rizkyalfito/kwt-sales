<?php

namespace Config;

class SidebarMenu
{
    public static $menuItems = [
        [
            'title' => 'Dashboard',
            'icon'  => 'fas fa-tachometer-alt',
            'url'   => '/dashboard',
        ],
        [
            'title' => 'Kategori Produk',
            'icon'  => 'fas fa-list',
            'url'   => '/kategori',
        ],
        [
            'title' => 'Data Produk',
            'icon'  => 'fas fa-box',
            'url'   => '/produk',
        ],
        [
            'title' => 'Kelola Pesan',
            'icon'  => 'fas fa-envelope',
            'url'   => '/pesan',
        ],
        [
            'title' => 'Laporan Penjualan',
            'icon'  => 'fas fa-chart-line',
            'url'   => '/laporan',
        ],
        [
            'title' => 'Kontak',
            'icon'  => 'fas fa-address-book',
            'url'   => '/kontak',
        ],
        [
            'title' => 'Logout',
            'icon'  => 'fas fa-sign-out-alt',
            'url'   => '/logout',
        ],
    ];
}
