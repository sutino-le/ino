<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lowongan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="<?= base_url() ?>/upload/logo.png" rel="icon">
    <link href="<?= base_url() ?>/upload/logo.png" rel="apple-touch-icon">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-image: url("<?= base_url() ?>/upload/background.jpg");
            background-repeat: no-repeat;
            background-color: #cccccc;
            background-size: 100%;
            height: 100%;
        }
    </style>
</head>

<body background="<?= base_url() ?>/upload/background.jpg" style="background-repeat: no-repeat; backgground-size:100% 100%;">



    <div class="container-fluid m-2">
        <center>
            <img src="<?= base_url() ?>/upload/LOGO RSP NEW.png" alt="<?= base_url() ?>/upload/LOGO RSP NEW.png" width="30%">
            <br>
            <br>
            <h1>LOWONGAN KERJA</h1>
            <h2><?= $lowonganjob ?></h2>
        </center>
        <br>
        <h1>Deskripsi :</h1>
        <?= $lowongandeskripsi ?>
        <br>
        <h1>Persyaratan :</h1>
        <?= $lowonganpersyaratan ?>

    </div>



</body>

</html>