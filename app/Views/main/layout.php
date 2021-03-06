<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSP</title>

    <link href="<?= base_url() ?>/upload/logo.png" rel="icon">
    <link href="<?= base_url() ?>/upload/logo.png" rel="apple-touch-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
    <!-- SimpleMDE -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/simplemde/simplemde.min.css">



</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">


        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="<?= base_url() ?>/upload/logo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>/index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="text-white" href="<?= site_url('login/keluar') ?>"><i class="fas fa-sign-out-alt"></i> Logout &nbsp;</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link">
                <img src="<?= base_url() ?>/upload/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RSP</span>
            </a>


            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/upload/<?= session()->ktp_foto ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= site_url('profil/index/' . session()->iduser) ?>" class="d-block">
                            <?= session()->namauser . ' / ' . session()->levelnama ?>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php

                        // if (session()->idlevel == 1) :
                        if (session()->idlevel == 1) {
                            $setting = "show";
                            $levels = "show";
                            $users = "show";

                            $master_hr = "show";
                            $wilayah = "show";
                            $lowongan = "show";


                            $master_barang = "show";
                            $kategori = "show";
                            $subkategori = "show";
                            $satuan = "show";
                            $barang = "show";


                            $master_po = "show";
                            $pembelian = "show";

                            $biodata = "show";
                            $biodata_ktp = "show";
                        } else {
                            $setting = "none";
                            $levels = "none";
                            $users = "none";

                            $master_hr = "none";
                            $wilayah = "none";
                            $lowongan = "none";


                            $master_barang = "none";
                            $kategori = "none";
                            $subkategori = "none";
                            $satuan = "none";
                            $barang = "none";


                            $master_po = "none";
                            $pembelian = "none";

                            $biodata = "none";
                            $biodata_ktp = "none";
                        }

                        ?>


                        <li class="nav-item" style="display: <?= $setting ?>;">
                            <a href="#" class="nav-link">
                                <i class="fas fa-cog text-info"></i>
                                <p>
                                    Setting
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $levels ?>;">
                                    <a href="<?= site_url('levels/index') ?>" class="nav-link">
                                        <i class="fas fa-network-wired nav-icon text-info"></i>
                                        <p>Levels</p>
                                    </a>
                                </li>

                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $users ?>;">
                                    <a href="<?= site_url('users/index') ?>" class="nav-link">
                                        <i class="fas fa-user nav-icon text-info"></i>
                                        <p>Users</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item" style="display: <?= $master_hr ?>;">
                            <a href="#" class="nav-link">
                                <i class="fas fa-database text-primary"></i>
                                <p>
                                    Master HR
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $wilayah ?>;">
                                    <a href="<?= site_url('wilayah/index') ?>" class="nav-link">
                                        <i class="fas fa-map-marked-alt nav-icon text-primary"></i>
                                        <p>Wilayah</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $lowongan ?>;">
                                    <a href="<?= site_url('lowongan/index') ?>" class="nav-link">
                                        <i class="fas fa-business-time nav-icon text-primary"></i>
                                        <p>Lowongan</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item" style="display: <?= $master_barang ?>;">
                            <a href="#" class="nav-link">
                                <i class="fas fa-coins text-warning"></i>
                                <p>
                                    Master Barang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $kategori ?>;">
                                    <a href="<?= site_url('kategori/index') ?>" class="nav-link">
                                        <i class="fas fa-cube nav-icon text-warning"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $subkategori ?>;">
                                    <a href="<?= site_url('subkategori/index') ?>" class="nav-link">
                                        <i class="fas fa-cubes nav-icon text-warning"></i>
                                        <p>Sub Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $satuan ?>;">
                                    <a href="<?= site_url('satuan/index') ?>" class="nav-link">
                                        <i class="fas fa-tag nav-icon text-warning"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $barang ?>;">
                                    <a href="<?= site_url('barang/index') ?>" class="nav-link">
                                        <i class="fas fa-box-open nav-icon text-warning"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item" style="display: <?= $master_po ?>;">
                            <a href="#" class="nav-link">
                                <i class="fas fa-dolly-flatbed text-maroon"></i>
                                <p>
                                    Pesanan Pembelian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $pembelian ?>;">
                                    <a href="<?= site_url('pembelian/index') ?>" class="nav-link">
                                        <i class="fas fa-cart-arrow-down nav-icon text-maroon"></i>
                                        <p>Pembelian</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item" style="display: <?= $biodata ?>;">
                            <a href="#" class="nav-link">
                                <i class="fas fa-users text-success"></i>
                                <p>
                                    Biodata
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $biodata_ktp ?>;">
                                    <a href="<?= site_url('biodataktp/index') ?>" class="nav-link">
                                        <i class="fas fa-id-card nav-icon text-success"></i>
                                        <p>KTP</p>
                                    </a>
                                </li>

                            </ul>
                        </li>



                        <?php //endif; 
                        ?>


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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><?= $judule; ?><?= $this->renderSection('judul'); ?></a>
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



    <!-- Summernote -->
    <script src="<?= base_url() ?>/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- CodeMirror -->
    <script src="<?= base_url() ?>/plugins/codemirror/codemirror.js"></script>
    <script src="<?= base_url() ?>/plugins/codemirror/mode/css/css.js"></script>
    <script src="<?= base_url() ?>/plugins/codemirror/mode/xml/xml.js"></script>
    <script src="<?= base_url() ?>/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>

    <script src="<?= base_url() ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


    <script>
        $(function() {
            bsCustomFileInput.init();
        });


        $(function() {
            // Summernote
            $('#summernotedesk').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })


        $(function() {
            // Summernote
            $('#summernotepers').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>

</body>

</html>