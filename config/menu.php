<?php

return [
    [
        'title' => 'Profil',
        'url' => '#profil',
        'icon' => 'user',
        'children' => [
            ['title' => 'Bupati', 'url' => '/profil/bupati', 'icon' => 'user-tie'],
            ['title' => 'Wakil Bupati', 'url' => '/profil/wakil-bupati', 'icon' => 'user-tie'],
            ['title' => 'Sekretaris Daerah', 'url' => '/profil/sekretaris-daerah', 'icon' => 'building'],
            ['title' => 'Pejabat Daerah', 'url' => '/profil/pejabat-daerah', 'icon' => 'user-tie'],
            ['title' => 'PPID', 'url' => '/profil/ppid', 'icon' => 'info-circle'],
            ['title' => 'Tentang OPD', 'url' => '/profil/tentang-opd', 'icon' => 'building'],
        ],
    ],
    [
        'title' => 'Jenis Informasi',
        'url' => '#informasi',
        'icon' => 'folder',
        'children' => [
            ['title' => 'Informasi Berkala', 'url' => '/informasi/berkala', 'icon' => 'calendar-alt'],
            ['title' => 'Informasi Tersedia Setiap Saat', 'url' => '/informasi/setiap-saat', 'icon' => 'clock'],
            ['title' => 'Informasi Serta Merta', 'url' => '/informasi/serta-merta', 'icon' => 'exclamation-triangle'],
            ['title' => 'Informasi Dikecualikan', 'url' => '/informasi/dikecualikan', 'icon' => 'ban'],
        ],
    ],
    [
        'title' => 'DIP',
        'url' => '#',
        'icon' => 'book',
        'children' => [
            ['title' => 'DIP ' . date('Y'), 'url' => '/dip/' . date('Y'), 'icon' => 'file-alt'],
            ['title' => 'DIP ' . (date('Y') - 1), 'url' => '/dip/' . (date('Y') - 1), 'icon' => 'file-alt'],
            ['title' => 'DIP ' . (date('Y') - 2), 'url' => '/dip/' . (date('Y') - 2), 'icon' => 'file-alt'],
        ],
    ],
    [
        'title' => 'DIP Unit',
        'url' => '/dipunit',
        'icon' => 'university',
        'children' => [],
    ],
    [
        'title' => 'Standar Layanan',
        'url' => '#layanan',
        'icon' => 'clipboard-list',
        'children' => [
            ['title' => 'Dasar Hukum', 'url' => '/standar-layanan/dasar-hukum', 'icon' => 'gavel'],
            ['title' => 'Tugas, Wewenang & Tanggung Jawab', 'url' => '/standar-layanan/tugas-wewenang', 'icon' => 'handshake'],
            ['title' => 'SOP', 'url' => '/standar-layanan/sop', 'icon' => 'file-alt'],
            ['title' => 'Maklumat Pelayanan', 'url' => '/standar-layanan/maklumat', 'icon' => 'bullhorn'],
            ['title' => 'Mekanisme & Biaya', 'url' => '/standar-layanan/mekanisme-biaya', 'icon' => 'money-bill-wave'],
        ],
    ],
    [
        'title' => 'Transparansi',
        'url' => '#',
        'icon' => 'chart-bar',
        'children' => [
            ['title' => 'Permohonan Informasi', 'url' => '/laporan/permohonan', 'icon' => 'file-signature'],
            ['title' => 'Survei', 'url' => '/laporan/survei', 'icon' => 'poll'],
            ['title' => 'Laporan PPID', 'url' => '/laporan/ppid', 'icon' => 'file-invoice'],
        ],
    ],
    ['title' => 'LHKPN', 'url' => '/lhkpn', 'icon' => 'file-invoice-dollar', 'children' => []],
    ['title' => 'PBJ', 'url' => '/pbj', 'icon' => 'shopping-cart', 'children' => []],
    ['title' => 'Login', 'url' => '/login', 'icon' => 'sign-in-alt', 'children' => []],
];