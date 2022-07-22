<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="<?= base_url() ?>/upload/logo.png" rel="icon">
    <link href="<?= base_url() ?>/upload/logo.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="<?= base_url() ?>/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>

</head>

<body>

    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        <div class="row mt-3 text-center">
                            <a href="<?= site_url() ?>"><img src="<?= base_url() ?>/upload/LOGO RSP NEW.png" width="80%" height="40px"></a>
                        </div>
                        <div class=" row px-3 justify-content-center mt-5 mb-5 border-line"> <img src="<?= base_url() ?>/upload/pngwing (1).png" width="100%" height="100%"> </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row px-3 mb-4">
                            <div class="line"></div> <small class="or text-center">Daftar</small>
                            <div class="line"></div>
                        </div>

                        <form action="<?= base_url('login/simpan') ?>" class="formsimpan">

                            <div class="form-group">
                                <label for="">User Name (Untuk Login)</label>
                                <input type="text" name="userid" id="userid" class="form-control" placeholder="Masukan User Name...">
                                <div class="invalid-feedback errorUserID"></div>
                            </div>

                            <div class="form-group">
                                <label for="">Nomor KTP</label>
                                <input type="text" name="userktp" id="userktp" minlength="16" maxlength="16" class="form-control" placeholder="Masukan Nomor KTP...">
                                <div class="invalid-feedback errorUserKtp"></div>
                            </div>

                            <div class="form-group">
                                <label for="">Nama Lengkap</label>
                                <input type="text" name="usernama" id="usernama" class="form-control" placeholder="Masukan Nama Lengkap...">
                                <div class="invalid-feedback errorUserNama"></div>
                            </div>

                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="useremail" id="useremail" class="form-control" placeholder="Masukan Email...">
                                <div class="invalid-feedback errorUserEmail"></div>
                            </div>

                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="userpassword" id="userpassword" class="form-control" placeholder="Masukan Password...">
                                <div class="invalid-feedback errorUserPassword"></div>
                            </div>

                            <div class="row px-3 mb-4">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="hidden" name="userlevelid" value="2" class="form-control">
                                </div>
                            </div>




                            <div class="row mb-3 px-3"> <button type="submit" class="btn btn-primary btn-block text-center">Daftar</button> </div>


                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>

</body>

</html>



<script>
    $(document).ready(function() {
        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errUserID) {
                            $('#userid').addClass('is-invalid');
                            $('.errorUserID').html(err.errUserID);
                        }

                        if (err.errUserKtp) {
                            $('#userktp').addClass('is-invalid');
                            $('.errorUserKtp').html(err.errUserKtp);
                        }

                        if (err.errUserNama) {
                            $('#usernama').addClass('is-invalid');
                            $('.errorUserNama').html(err.errUserNama);
                        }

                        if (err.errUserEmail) {
                            $('#useremail').addClass('is-invalid');
                            $('.errorUserEmail').html(err.errUserEmail);
                        }

                        if (err.errUserPassword) {
                            $('#userpassword').addClass('is-invalid');
                            $('.errorUserPassword').html(err.errUserPassword);
                        }
                    }

                    if (response.sukses) {
                        if (response.sukses) {
                            Swal.fire(
                                'Berhasil',
                                response.success,
                                'success'
                            ).then((result) => {
                                window.location.href = ('<?= base_url() ?>/login/index');
                            })
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

            return false;
        });

    });
</script>