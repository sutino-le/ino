<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <button type="button" class="close" onclick="editfoto('<?= $userid ?>')" title="Ubah Foto">
                                <i class='fas fa-camera text-primary'></i>
                            </button>

                            <img class=" profile-user-img img-fluid img-circle" src="/upload/<?= $ktp_foto ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= $ktp_nama ?></h3>

                        <p class="text-muted text-center"><?= $ktp_nomor ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#biodata_ktp" data-toggle="tab">KTP</a></li>
                            <li class="nav-item"><a class="nav-link" href="#biodata_domisili" data-toggle="tab">Domisili</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">
                        <div class="tab-content">


                            <div class="active tab-pane" id="biodata_ktp">
                                <!-- Post -->
                                <div class="post">

                                    <button type="button" class="close" onclick="editktp('<?= $userid ?>')" title="Ubah Data KTP">
                                        <i class='fas fa-user-edit text-primary mb-3'></i>
                                    </button>

                                    <table class="table">
                                        <tr>
                                            <td>Tempat/Tgl. Lahir</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $ktp_tempat_lahir . ' / ' . date('d-M-Y', strtotime($ktp_tanggal_lahir)) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $ktp_kelamin ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $ktp_alamat ?>, RT/RW <?= $ktp_rt ?>/<?= $ktp_rw ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kelurahan</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $kelurahan ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kecamatan</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $kecamatan ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kota/Kabupaten</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $kota_kabupaten ?></td>
                                        </tr>
                                        <tr>
                                            <td>Propinsi</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $propinsi ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.post -->
                            </div>


                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="biodata_domisili">
                                <!-- The timeline -->

                                <button type="button" class="close" onclick="editktp('<?= $userid ?>')" title="Ubah Data KTP">
                                    <i class='fas fa-user-edit text-primary mb-3'></i>
                                </button>


                                <table class="table">
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:&nbsp;</td>
                                        <td><?= $domisili_alamat ?>, RT/RW <?= $domisili_rt ?>/<?= $domisili_rw ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kelurahan</td>
                                        <td>:&nbsp;</td>
                                        <td><?= $domisili_kelurahan ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>:&nbsp;</td>
                                        <td><?= $domisili_kecamatan ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kota/Kabupaten</td>
                                        <td>:&nbsp;</td>
                                        <td><?= $domisili_kota_kabupaten ?></td>
                                    </tr>
                                    <tr>
                                        <td>Propinsi</td>
                                        <td>:&nbsp;</td>
                                        <td><?= $domisili_propinsi ?></td>
                                    </tr>
                                </table>

                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputName" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->



<div class="viewmodal" style="display: none;"></div>

<script>
    function editfoto(userid) {
        $.ajax({
            type: "post",
            url: "/profil/formeditfoto/" + userid,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalEditFoto').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>