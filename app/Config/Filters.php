<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'                  => CSRF::class,
        'toolbar'               => DebugToolbar::class,
        'honeypot'              => Honeypot::class,
        'invalidchars'          => InvalidChars::class,
        'secureheaders'         => SecureHeaders::class,
        'filterAdmin'           => \App\Filters\FilterAdmin::class,
        'filterUser'            => \App\Filters\FilterUser::class,
        'filterUserPurchasing'  => \App\Filters\FilterUserPurchasing::class,
        'filterUserGudangBB'    => \App\Filters\FilterUserGudangBB::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            'filterAdmin' => [
                'except' => ['home/*', 'login/*', '/']
            ],
            'filterUser' => [
                'except' => ['home/*', 'login/*', '/']
            ],
            'filterUserPurchasing' => [
                'except' => ['home/*', 'login/*', '/']
            ],
            'filterUserGudangBB' => [
                'except' => ['home/*', 'login/*', '/']
            ]
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
            'filterAdmin' => [
                'except' => ['/', 'home/*', 'main/*', 'profil/*', 'levels/*', 'users/*', 'wilayah/*', 'lowongan/*', 'soal/*', 'psikotest/*', 'kategori/*', 'subkategori/*', 'satuan/*', 'barang/*', 'pembelian/*', 'penerimaan/*', 'pemakaian/*', 'suplier/*', 'biodataktp/*', 'pengembalian/*', 'finger/*', 'hrbagian/*', 'hrjabatan/*', 'hrjeniskaryawan/*', 'hrjenispkwt/*', 'hrstruktur/*', 'hrpelamar/*', 'pengingat/*', 'perbaikan/*',]
            ],
            'filterUser' => [
                'except' => ['/', 'home/*', 'main/*', 'profil/*', 'wilayah/*', 'lowongan/*',  'psikotest/*', 'perbaikan/index', 'perbaikan/listdata', 'perbaikan/formtambah', 'perbaikan/simpan',]
            ],
            'filterUserPurchasing' => [
                'except' => ['/', 'home/*', 'main/*', 'profil/*', 'wilayah/*', 'lowongan/*',  'psikotest/*', 'perbaikan/index', 'perbaikan/listdata', 'perbaikan/formtambah', 'perbaikan/simpan', 'kategori/*', 'subkategori/*', 'satuan/*', 'barang/*', 'pembelian/*', 'penerimaan/*', 'pemakaian/*', 'suplier/*', 'biodataktp/*', 'pengembalian/*',]
            ],
            'filterUserGudangBB' => [
                'except' => ['/', 'home/*', 'main/*', 'profil/*', 'wilayah/*', 'lowongan/*',  'psikotest/*', 'perbaikan/index', 'perbaikan/listdata', 'perbaikan/formtambah', 'perbaikan/simpan', 'barang/*', 'penerimaan/*', 'pemakaian/*', 'biodataktp/*', 'pengembalian/*',]
            ],
            'toolbar',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
