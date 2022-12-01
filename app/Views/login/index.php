<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSP</title>

    <link href="<?= base_url() ?>/upload/logo.png" rel="icon">
    <link href="<?= base_url() ?>/upload/logo.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="<?= base_url() ?>/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>

    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        <div class="row mt-3 text-center">
                            <a href="<?= site_url() ?>"><img src="<?= base_url() ?>/upload/LOGO RSP NEW.png" width="80%"
                                    height="40px"></a>
                        </div>
                        <div class=" row px-3 justify-content-center mt-5 mb-5 border-line"> <img
                                src="<?= base_url() ?>/upload/pngwing (1).png" width="100%" height="100%"> </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4 px-3">
                            <marquee>
                                <h2 class="mb-0 mr-4 mt-2">Selamat Datang...!!!</h2>
                            </marquee>
                        </div>
                        <div class="row px-3 mb-4">
                            <div class="line"></div> <small class="or text-center">Login</small>
                            <div class="line"></div>
                        </div>
                        <?= form_open(base_url('login/cekUser')); ?>
                        <?= csrf_field(); ?>


                        <?php
                        if (session()->getFlashdata('errIdUser')) {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?= session()->getFlashdata('errIdUser'); ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        }
                        ?>



                        <div class="row px-3">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm">User ID</h6>
                            </label>
                            <input type="text" name="iduser" class="form-control" placeholder="Masukan ID User"
                                autofocus>

                        </div>
                        <div class="row px-3">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm">Password</h6>
                            </label>
                            <input type="password" name="pass" class="form-control" placeholder="Password">
                        </div>
                        <div class="row px-3 mb-4">
                            <div class="custom-control custom-checkbox custom-control-inline">

                            </div>
                            <a href="#" class="ml-auto mb-0 text-sm">Lupa Password?</a>
                        </div>



                        <div class="row mb-3 px-3"> <button type="submit"
                                class="btn btn-primary btn-block text-center">Login</button> </div>


                        <?= form_close() ?>

                        <div class="row mb-4 px-3"> <small class="font-weight-bold">Tidak punya akun ? <a
                                    href="<?= site_url('login/daftar') ?>" class="text-danger ">Daftar</a></small>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</body>

</html>