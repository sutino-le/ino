<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSP</title>

    <link href="<?= base_url() ?>/upload/logo.png" rel="icon">
    <link href="<?= base_url() ?>/upload/logo.png" rel="apple-touch-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?= base_url() ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/dropzone/min/dropzone.min.css">



    <link rel="stylesheet" href="<?= base_url() ?>/plugins/summernote/summernote-bs4.min.css">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/codemirror/codemirror.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/codemirror/theme/monokai.css">




</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">


        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="<?= base_url() ?>/upload/logo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>/main/index" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="text-white" href="<?= site_url('login/keluar') ?>"><i class="fas fa-sign-out-alt"></i>
                        Logout &nbsp;</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link">
                <img src="<?= base_url() ?>/upload/logo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RSP</span>
            </a>


            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/upload/<?= session()->ktp_foto ?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= site_url('profil/index/' . session()->iduser) ?>" class="d-block">
                            <?= session()->namauser . ' / ' . session()->levelnama ?>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <?php

                // if (session()->idlevel == 1) :
                if (session()->idlevel == 1) {

                    // HR
                    $setting = "show";
                    $levels = "show";
                    $users = "show";

                    $master_hr = "show";
                    $wilayah = "show";
                    $lowongan = "show";
                    $soal = "show";
                    $bagian = "show";
                    $jabatan = "show";
                    $jeniskaryawan = "show";
                    $jenispkwt = "show";

                    $struktur = "show";

                    $biodata = "show";
                    $biodata_ktp = "show";

                    $hrseleksi = "show";
                    $pelamar = "show";

                    // User
                    $master_test = "show";
                    $lowongandaftar = "show";
                    $psikotest = "show";
                    $perbaikan = "show";

                    // Purchasing
                    $master_barang = "show";
                    $kategori = "show";
                    $subkategori = "show";
                    $satuan = "show";
                    $barang = "show";

                    $master_po = "show";
                    $pembelian = "show";
                    $datapembelian = "show";

                    $master_ttb = "show";
                    $penerimaan = "show";

                    $master_pm = "show";
                    $pemakaian = "show";
                    $datapemakaian = "show";

                    $master_pgm = "show";
                    $pengembalian = "show";
                    $datapengembalian = "show";

                    $master_finger = "show";
                    $finger = "show";

                    $master_pengingat = "show";
                    $pengingat = "show";
                } else if (session()->idlevel == 3) {

                    // HR
                    $setting = "none";
                    $levels = "none";
                    $users = "none";

                    $master_hr = "none";
                    $wilayah = "none";
                    $lowongan = "none";
                    $soal = "none";
                    $bagian = "none";
                    $jabatan = "none";
                    $jeniskaryawan = "none";
                    $jenispkwt = "none";

                    $struktur = "none";

                    $biodata = "none";
                    $biodata_ktp = "none";

                    $hrseleksi = "none";
                    $pelamar = "none";

                    // User
                    $master_test = "show";
                    $lowongandaftar = "show";
                    $psikotest = "show";
                    $perbaikan = "show";

                    // Purchasing
                    $master_barang = "show";
                    $kategori = "show";
                    $subkategori = "show";
                    $satuan = "show";
                    $barang = "show";

                    $master_po = "show";
                    $pembelian = "show";
                    $datapembelian = "show";

                    $master_ttb = "show";
                    $penerimaan = "show";

                    $master_pm = "show";
                    $pemakaian = "show";
                    $datapemakaian = "show";

                    $master_pgm = "show";
                    $pengembalian = "show";
                    $datapengembalian = "show";

                    $master_finger = "none";
                    $finger = "none";

                    $master_pengingat = "show";
                    $pengingat = "show";
                } else if (session()->idlevel == 4) {

                    // HR
                    $setting = "none";
                    $levels = "none";
                    $users = "none";

                    $master_hr = "none";
                    $wilayah = "none";
                    $lowongan = "none";
                    $soal = "none";
                    $bagian = "none";
                    $jabatan = "none";
                    $jeniskaryawan = "none";
                    $jenispkwt = "none";

                    $struktur = "none";

                    $biodata = "none";
                    $biodata_ktp = "none";

                    $hrseleksi = "none";
                    $pelamar = "none";

                    // User
                    $master_test = "show";
                    $lowongandaftar = "show";
                    $psikotest = "show";
                    $perbaikan = "show";

                    // Purchasing
                    $master_barang = "show";
                    $kategori = "none";
                    $subkategori = "none";
                    $satuan = "none";
                    $barang = "show";

                    $master_po = "none";
                    $pembelian = "none";
                    $datapembelian = "none";

                    $master_ttb = "show";
                    $penerimaan = "show";

                    $master_pm = "show";
                    $pemakaian = "show";
                    $datapemakaian = "show";

                    $master_pgm = "show";
                    $pengembalian = "show";
                    $datapengembalian = "show";

                    $master_finger = "none";
                    $finger = "none";

                    $master_pengingat = "none";
                    $pengingat = "none";
                } else {
                    // HR
                    $setting = "none";
                    $levels = "none";
                    $users = "none";

                    $master_hr = "none";
                    $wilayah = "none";
                    $lowongan = "none";
                    $soal = "none";
                    $bagian = "none";
                    $jabatan = "none";
                    $jeniskaryawan = "none";
                    $jenispkwt = "none";

                    $struktur = "none";

                    $biodata = "none";
                    $biodata_ktp = "none";

                    $hrseleksi = "none";
                    $pelamar = "none";

                    // User
                    $master_test = "show";
                    $lowongandaftar = "show";
                    $psikotest = "show";
                    $perbaikan = "show";

                    // Purchasing
                    $master_barang = "none";
                    $kategori = "none";
                    $subkategori = "none";
                    $satuan = "none";
                    $barang = "none";

                    $master_po = "none";
                    $pembelian = "none";
                    $datapembelian = "none";

                    $master_ttb = "none";
                    $penerimaan = "none";

                    $master_pm = "none";
                    $pemakaian = "none";
                    $datapemakaian = "none";

                    $master_pgm = "none";
                    $pengembalian = "none";
                    $datapengembalian = "none";

                    $master_finger = "none";
                    $finger = "none";

                    $master_pengingat = "none";
                    $pengingat = "none";
                }
                ?>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-header">
                            <hr>HR
                        </li>

                        <!-- Setting -->
                        <li class="nav-item <?= ($menu == 'setting') ? 'menu-open' : '' ?>"
                            style="display: <?= $setting ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'setting') ? 'active' : '' ?>">
                                <i class="fas fa-cog text-info"></i>
                                <p>
                                    Setting
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $levels ?>;">
                                    <a href="<?= site_url('levels/index') ?>"
                                        class="nav-link <?= ($submenu == 'level') ? 'active' : '' ?>">
                                        <i class="fas fa-network-wired nav-icon text-info"></i>
                                        <p>Levels</p>
                                    </a>
                                </li>

                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $users ?>;">
                                    <a href="<?= site_url('users/index') ?>"
                                        class="nav-link <?= ($submenu == 'user') ? 'active' : '' ?>">
                                        <i class="fas fa-user nav-icon text-info"></i>
                                        <p>Users</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Master HR -->
                        <li class="nav-item <?= ($menu == 'masterhr') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_hr ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'masterhr') ? 'active' : '' ?>">
                                <i class="fas fa-database text-primary"></i>
                                <p>
                                    Master HR
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $wilayah ?>;">
                                    <a href="<?= site_url('wilayah/index') ?>"
                                        class="nav-link <?= ($submenu == 'wilayah') ? 'active' : '' ?>">
                                        <i class="fas fa-map-marked-alt nav-icon text-primary"></i>
                                        <p>Wilayah</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $lowongan ?>;">
                                    <a href="<?= site_url('lowongan/index') ?>"
                                        class="nav-link <?= ($submenu == 'lowongan') ? 'active' : '' ?>">
                                        <i class="fas fa-business-time nav-icon text-primary"></i>
                                        <p>Lowongan</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $soal ?>;">
                                    <a href="<?= site_url('soal/index') ?>"
                                        class="nav-link <?= ($submenu == 'soal') ? 'active' : '' ?>">
                                        <i class="fas fa-file-alt nav-icon text-primary"></i>
                                        <p>Soal</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $bagian ?>;">
                                    <a href="<?= site_url('hrbagian/index') ?>"
                                        class="nav-link <?= ($submenu == 'bagian') ? 'active' : '' ?>">
                                        <i class="fas fa-bezier-curve nav-icon text-primary"></i>
                                        <p>Bagian</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $jabatan ?>;">
                                    <a href="<?= site_url('hrjabatan/index') ?>"
                                        class="nav-link <?= ($submenu == 'jabatan') ? 'active' : '' ?>">
                                        <i class="fas fa-user-tie nav-icon text-primary"></i>
                                        <p>Jabatan</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $jeniskaryawan ?>;">
                                    <a href="<?= site_url('hrjeniskaryawan/index') ?>"
                                        class="nav-link <?= ($submenu == 'jeniskaryawan') ? 'active' : '' ?>">
                                        <i class="fas fa-users-cog nav-icon text-primary"></i>
                                        <p>Jenis Karyawan</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $jenispkwt ?>;">
                                    <a href="<?= site_url('hrjenispkwt/index') ?>"
                                        class="nav-link <?= ($submenu == 'jenispkwt') ? 'active' : '' ?>">
                                        <i class="fas fa-file-signature nav-icon text-primary"></i>
                                        <p>Jenis PKWT</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Struktur -->
                        <li class="nav-item <?= ($menu == 'struktur') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_hr ?>;">
                            <a href="<?= site_url('hrstruktur/index') ?>"
                                class="nav-link <?= ($menu == 'struktur') ? 'active' : '' ?>">
                                <i class="fas fa-bezier-curve text-lightblue"></i>
                                <p>
                                    Struktur Organisasi
                                </p>
                            </a>
                        </li>

                        <!-- Biodata -->
                        <li class="nav-item <?= ($menu == 'biodata') ? 'menu-open' : '' ?>"
                            style="display: <?= $biodata ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'biodata') ? 'active' : '' ?>">
                                <i class="fas fa-users text-warning"></i>
                                <p>
                                    Biodata
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $biodata_ktp ?>;">
                                    <a href="<?= site_url('biodataktp/index') ?>"
                                        class="nav-link <?= ($submenu == 'ktp') ? 'active' : '' ?>">
                                        <i class="fas fa-id-card nav-icon text-warning"></i>
                                        <p>KTP</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Seleksi -->
                        <li class="nav-item <?= ($menu == 'seleksi') ? 'menu-open' : '' ?>"
                            style="display: <?= $hrseleksi ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'seleksi') ? 'active' : '' ?>">
                                <i class="fas fa-user-clock text-secondary"></i>
                                <p>
                                    Seleksi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">

                                <li class="nav-item" style="display: <?= $pelamar ?>;">
                                    <a href="<?= site_url('hrpelamar/index') ?>"
                                        class="nav-link <?= ($submenu == 'pelamar') ? 'active' : '' ?>">
                                        <i class="fas fa-user-friends nav-icon text-secondary"></i>
                                        <p>Pelamar</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Finger -->
                        <li class="nav-item <?= ($menu == 'finger') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_finger ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'finger') ? 'active' : '' ?>">
                                <i class="fas fa-fingerprint text-success"></i>
                                <p>
                                    Finger
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $finger ?>;">
                                    <a href="<?= site_url('finger/index') ?>"
                                        class="nav-link <?= ($submenu == 'finger') ? 'active' : '' ?>">
                                        <i class="fas fa-fingerprint nav-icon text-success"></i>
                                        <p>Finger</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- pengingat -->
                        <li class="nav-item <?= ($menu == 'pengingat') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_pengingat ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'pengingat') ? 'active' : '' ?>">
                                <i class="fas fa-bell text-purple "></i>
                                <p>
                                    Pengingat
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $pengingat ?>;">
                                    <a href="<?= site_url('pengingat/index') ?>"
                                        class="nav-link <?= ($submenu == 'pengingat') ? 'active' : '' ?>">
                                        <i class="fas fa-bell nav-icon text-purple "></i>
                                        <p>pengingat</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-header">
                            <hr>USER
                        </li>

                        <!-- Menu -->
                        <li class="nav-item <?= ($menu == 'lowongan') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_test ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'lowongan') ? 'active' : '' ?>">
                                <i class="fas fa-align-justify text-secondary"></i>
                                <p>
                                    Menu
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $lowongandaftar ?>;">
                                    <a href="<?= site_url('lowongan/lowongandaftar') ?>"
                                        class="nav-link <?= ($submenu == 'lowongankerja') ? 'active' : '' ?>">
                                        <i class="fas fa-bars nav-icon text-secondary"></i>
                                        <p>Lowongan Kerja</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $psikotest ?>;">
                                    <a href="<?= site_url('psikotest/index') ?>"
                                        class="nav-link <?= ($submenu == 'psikotest') ? 'active' : '' ?>">
                                        <i class="fas fa-file-signature nav-icon text-secondary"></i>
                                        <p>Psikotest</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $perbaikan ?>;">
                                    <a href="<?= site_url('perbaikan/index') ?>"
                                        class="nav-link <?= ($submenu == 'perbaikan') ? 'active' : '' ?>">
                                        <i class="fas fa-users-cog nav-icon text-secondary"></i>
                                        <p>Perbaikan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-header">
                            <hr>PURCHASING
                        </li>

                        <!-- Master Barang -->
                        <li class="nav-item <?= ($menu == 'masterbarang') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_barang ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'masterbarang') ? 'active' : '' ?>">
                                <i class="fas fa-coins text-warning"></i>
                                <p>
                                    Master Barang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $kategori ?>;">
                                    <a href="<?= site_url('kategori/index') ?>"
                                        class="nav-link <?= ($submenu == 'kategori') ? 'active' : '' ?>">
                                        <i class="fas fa-cube nav-icon text-warning"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $subkategori ?>;">
                                    <a href="<?= site_url('subkategori/index') ?>"
                                        class="nav-link <?= ($submenu == 'subkategori') ? 'active' : '' ?>">
                                        <i class="fas fa-cubes nav-icon text-warning"></i>
                                        <p>Sub Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $satuan ?>;">
                                    <a href="<?= site_url('satuan/index') ?>"
                                        class="nav-link <?= ($submenu == 'satuan') ? 'active' : '' ?>">
                                        <i class="fas fa-tag nav-icon text-warning"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $barang ?>;">
                                    <a href="<?= site_url('barang/index') ?>"
                                        class="nav-link <?= ($submenu == 'barang') ? 'active' : '' ?>">
                                        <i class="fas fa-box-open nav-icon text-warning"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Pesanan Pembalian -->
                        <li class="nav-item <?= ($menu == 'pembelian') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_po ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'pembelian') ? 'active' : '' ?>">
                                <i class="fas fa-dolly-flatbed text-success"></i>
                                <p>
                                    Pesanan Pembelian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $pembelian ?>;">
                                    <a href="<?= site_url('pembelian/index') ?>"
                                        class="nav-link <?= ($submenu == 'pembelian') ? 'active' : '' ?>">
                                        <i class="fas fa-cart-arrow-down nav-icon text-success"></i>
                                        <p>Pembelian</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $datapembelian ?>;">
                                    <a href="<?= site_url('pembelian/datapembelian') ?>"
                                        class="nav-link <?= ($submenu == 'datapembelian') ? 'active' : '' ?>">
                                        <i class="fas fa-layer-group nav-icon text-success"></i>
                                        <p>Data Pembelian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Penerimaan Barang -->
                        <li class="nav-item <?= ($menu == 'penerimaan') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_ttb ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'penerimaan') ? 'active' : '' ?>">
                                <i class="fas fa-truck-loading text-info"></i>
                                <p>
                                    Penerimaan Barang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $penerimaan ?>;">
                                    <a href="<?= site_url('penerimaan/index') ?>"
                                        class="nav-link <?= ($submenu == 'penerimaan') ? 'active' : '' ?>">
                                        <i class="fas fa-hand-holding nav-icon text-info"></i>
                                        <p>Penerimaan</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $penerimaan ?>;">
                                    <a href="<?= site_url('penerimaan/detailttb') ?>"
                                        class="nav-link <?= ($submenu == 'detailpenerimaan') ? 'active' : '' ?>">
                                        <i class="fas fa-hand-holding nav-icon text-info"></i>
                                        <p>Detail Penerimaan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Pemakaian Barang -->
                        <li class="nav-item <?= ($menu == 'pemakaian') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_pm ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'pemakaian') ? 'active' : '' ?>">
                                <i class="fas fa-retweet text-danger"></i>
                                <p>
                                    Pemakaian Barang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $pemakaian ?>;">
                                    <a href="<?= site_url('pemakaian/index') ?>"
                                        class="nav-link <?= ($submenu == 'pemakaian') ? 'active' : '' ?>">
                                        <i class="fas fa-share nav-icon text-danger"></i>
                                        <p>Pemakaian</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $datapemakaian ?>;">
                                    <a href="<?= site_url('pemakaian/datapemakaian') ?>"
                                        class="nav-link <?= ($submenu == 'datapemakaian') ? 'active' : '' ?>">
                                        <i class="fas fa-share-square nav-icon text-danger"></i>
                                        <p>Detail Pemakaian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Pengembalian Barang -->
                        <li class="nav-item <?= ($menu == 'pengembalian') ? 'menu-open' : '' ?>"
                            style="display: <?= $master_pgm ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'pengembalian') ? 'active' : '' ?>">
                                <i class="fas fa-reply-all text-warning"></i>
                                <p>
                                    Pengembalian Barang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $pengembalian ?>;">
                                    <a href="<?= site_url('pengembalian/index') ?>"
                                        class="nav-link <?= ($submenu == 'pengembalian') ? 'active' : '' ?>">
                                        <i class="fas fa-reply nav-icon text-warning"></i>
                                        <p>Pengembalian</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $datapengembalian ?>;">
                                    <a href="<?= site_url('pengembalian/datapengembalian') ?>"
                                        class="nav-link <?= ($submenu == 'datapengembalian') ? 'active' : '' ?>">
                                        <i class="fas fa-recycle nav-icon text-warning"></i>
                                        <p>Detail Pengembalian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-header">
                            <hr>
                            <marquee>Rackindo Setara Perkasa</marquee>
                            <hr>
                        </li>


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <?= $this->section('judul') ?>
                            <?php
                            if ($subjudul != "Awal") {
                                $judule     = "";
                                $subjudule  = "";
                            } else {
                                $judule     = $judul;
                                $subjudule  = session()->levelnama;
                            }
                            ?>
                            <?= $this->endSection('judul') ?>
                            <ol class="breadcrumb float">
                                <li class="breadcrumb-item"><a
                                        href="<?= base_url() ?>"><?= $judule; ?><?= $this->renderSection('judul'); ?></a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= $subjudule; ?><?= $this->renderSection('subjudul'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <?= $this->renderSection('isi'); ?>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2022 <a href="<?= base_url() ?>">Project</a>.</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/plugins/pdfmake/vfs_fonts.js"></script>




    <script src="<?= base_url() ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


    <script>
    $(function() {
        bsCustomFileInput.init();
    });
    </script>

</body>

</html>