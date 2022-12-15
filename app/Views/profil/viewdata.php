<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<style>
.list-group-flush {
    height: 400px;
    overflow-y: auto;
}
</style>


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

                            <img class=" profile-user-img img-fluid img-circle"
                                src="<?= base_url() ?>/upload/<?= $ktp_foto ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= $ktp_nama ?></h3>

                        <p class="text-muted text-center"><?= $ktp_nomor ?></p>

                        <input type="hidden" id="ktpnomor" value="<?= $ktp_nomor ?>">

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
                </div>

            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#biodata_ktp"
                                    data-toggle="tab">KTP</a></li>
                            <li class="nav-item"><a class="nav-link" href="#biodata_domisili"
                                    data-toggle="tab">Domisili</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pemakaian" data-toggle="tab">Pemakaian</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>
                    </div>


                    <div class="card-body">
                        <div class="tab-content">

                            <div class="active tab-pane" id="biodata_ktp">
                                <div class="post">

                                    <table class="table">
                                        <tr>
                                            <td>Tempat/Tgl. Lahir</td>
                                            <td>:&nbsp;</td>
                                            <td><?= $ktp_tempat_lahir . ' / ' . date('d-M-Y', strtotime($ktp_tanggal_lahir)) ?>
                                            </td>
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


                            <div class="tab-pane" id="biodata_domisili">

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


                            <div class="tab-pane" id="pemakaian">
                                <div class="col-lg-12 tampilDataPemakai">

                                </div>
                            </div>



                            <div class="tab-pane" id="settings">
                                <?= form_open_multipart(base_url('profil/update'), 'class="formupdate"'); ?>


                                <div class="body">

                                    <ul class='list-group list-group-flush'>
                                        <li class='list-group-item'>

                                            <div class="content">
                                                <div class="modal-header bg-info">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Biodata KTP</h5>
                                                </div>

                                                <div class="body">
                                                    <div class="container-fluid">



                                                        <div class="row">

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="">Nomor KTP <font color="#ff9999"> &#42;
                                                                        </font></label>
                                                                    <input type="text" name="ktp_nomor" id="ktp_nomor"
                                                                        class="form-control" value="<?= $ktp_nomor ?>"
                                                                        placeholder="Masukan Nomor KTP...">
                                                                    <div class="invalid-feedback errorKtpNomor"></div>

                                                                    <input type="hidden" name="userid" id="userid"
                                                                        value="<?= $userid ?>">
                                                                    <input type="hidden" name="ktp_nomor_lama"
                                                                        id="ktp_nomor_lama" value="<?= $ktp_nomor ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="">Nama Lengkap <font color="#ff9999">
                                                                            &#42;</font></label>
                                                                    <input type="text" name="ktp_nama" id="ktp_nama"
                                                                        class="form-control" value="<?= $ktp_nama ?>"
                                                                        placeholder="Masukan Nama Lengkap...">
                                                                    <div class="invalid-feedback errorKtpNama"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="">Tempat Lahir <font color="#ff9999">
                                                                            &#42;</font></label>
                                                                    <input type="text" name="ktp_tempat_lahir"
                                                                        id="ktp_tempat_lahir" class="form-control"
                                                                        value="<?= $ktp_tempat_lahir ?>"
                                                                        placeholder="Masukan Tempat Lahir...">
                                                                    <div class="invalid-feedback errorKtpTempatLahir">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">Tanggal Lahir <font color="#ff9999">
                                                                            &#42;</font></label>
                                                                    <input type="date" name="ktp_tanggal_lahir"
                                                                        id="ktp_tanggal_lahir" class="form-control"
                                                                        value="<?= $ktp_tanggal_lahir ?>">
                                                                    <div class="invalid-feedback errorKtpTanggalLahir">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">Jenis Kelamin <font color="#ff9999">
                                                                            &#42;</font></label>
                                                                    <select name="ktp_kelamin" id="ktp_kelamin"
                                                                        class="form-control">
                                                                        <option value="<?= $ktp_kelamin ?>" selected>
                                                                            <?= $ktp_kelamin ?></option>
                                                                        <option value="">Pilih Jenis Kelamin</option>
                                                                        <option value=""></option>
                                                                        <option value="Pria">Pria</option>
                                                                        <option value="Wanita">Wanita</option>
                                                                    </select>
                                                                    <div class="invalid-feedback errorKtpKelamin"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="">Alamat <font color="#ff9999"> &#42;
                                                                        </font></label>
                                                                    <input type="text" name="ktp_alamat" id="ktp_alamat"
                                                                        class="form-control" value="<?= $ktp_alamat ?>"
                                                                        placeholder="Masukan Alamat...">
                                                                    <div class="invalid-feedback errorKtpAlamat"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">RT <font color="#ff9999"> &#42;</font>
                                                                    </label>
                                                                    <input type="text" name="ktp_rt" id="ktp_rt"
                                                                        class="form-control" value="<?= $ktp_rt ?>"
                                                                        placeholder="Masukan RT...">
                                                                    <div class="invalid-feedback errorKtpRt"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">RW <font color="#ff9999"> &#42;</font>
                                                                    </label>
                                                                    <input type="text" name="ktp_rw" id="ktp_rw"
                                                                        class="form-control" value="<?= $ktp_rw ?>"
                                                                        placeholder="Masukan RW...">
                                                                    <div class="invalid-feedback errorKtpRw"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">Kelurahan</label>
                                                                    <input type="text" name="kelurahan" id="kelurahan"
                                                                        class="form-control" value="<?= $kelurahan ?>"
                                                                        placeholder="Masukan Kelurahan..." readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">Kecamatan</label>
                                                                    <input type="text" name="kecamatan" id="kecamatan"
                                                                        class="form-control" value="<?= $kecamatan ?>"
                                                                        placeholder="Masukan Kecamatan..." readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">Kota / Kabupaten</label>
                                                                    <input type="text" name="kota_kabupaten"
                                                                        id="kota_kabupaten" class="form-control"
                                                                        value="<?= $kota_kabupaten ?>"
                                                                        placeholder="Masukan Kota / Kabupaten..."
                                                                        readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="">Propinsi</label>
                                                                    <input type="text" name="propinsi" id="propinsi"
                                                                        class="form-control" value="<?= $propinsi ?>"
                                                                        placeholder="Masukan Propinsi..." readonly>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row">

                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="">Pilih Daerah <font color="#ff9999">
                                                                            &#42;</font></label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Kode Wilayah"
                                                                            name="kelurahanpilih" id="kelurahanpilih"
                                                                            value="<?= $ktp_alamatid ?>" readonly>
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-outline-success"
                                                                                type="button" id="tombolCariWilayah"
                                                                                title="Cari Wilayah"><i
                                                                                    class="fas fa-search"></i></button>
                                                                        </div>
                                                                        <div class="invalid-feedback errorKtpAlamatId">
                                                                        </div>
                                                                        <input type="hidden" name="ktp_alamatid"
                                                                            id="ktp_alamatid"
                                                                            value="<?= $ktp_alamatid ?>">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="">Nomor Hp <font color="#ff9999"> &#42;
                                                                        </font></label>
                                                                    <input type="text" name="ktp_hp" id="ktp_hp"
                                                                        class="form-control" value="<?= $ktp_hp ?>"
                                                                        placeholder="Masukan Nomor HP...">
                                                                    <div class="invalid-feedback errorKtpHp"></div>
                                                                </div>
                                                            </div>

                                                        </div>



                                                    </div>
                                                </div>

                                            </div>

                                        </li>
                                    </ul>

                                </div>

                                <div class='card-footer bg-secondary'>
                                    <div class='row'>
                                        <div class='col text-right'>
                                            <button type="submit" class="btn btn-sm btn-success"
                                                id="tombolSelesaiTransaksi"><i class="fa fa-save"></i>
                                                Simpan</button>
                                        </div>
                                    </div>
                                </div>

                                <?= form_close(); ?>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="viewmodal" style="display: none;"></div>

<script>
// untuk menampilkan pemakaian
function tampilPemakaian() {
    let ktpnomor = $('#ktpnomor').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/profil/tampilPemakaian",
        data: {
            ktpnomor: ktpnomor
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataPemakai').html("<i class='fas fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataPemakai').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

$(document).ready(function() {
    tampilPemakaian();
});


// tombol edit foto
function editfoto(userid) {
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/profil/formeditfoto/" + userid,
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

$(document).ready(function() {
    // tombol cari wilayah
    $('#tombolCariWilayah').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url() ?>/wilayah/modalData",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalDataWilayah').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });


    $('.formupdate').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.errKtpNomor) {
                        $('#ktp_nomor').addClass('is-invalid');
                        $('.errorKtpNomor').html(err.errKtpNomor);
                    } else {
                        $('#ktp_nomor').removeClass('is-invalid');
                        $('#ktp_nomor').addClass('is-valid');
                    }

                    if (err.errKtpNama) {
                        $('#ktp_nama').addClass('is-invalid');
                        $('.errorKtpNama').html(err.errKtpNama);
                    } else {
                        $('#ktp_nama').removeClass('is-invalid');
                        $('#ktp_nama').addClass('is-valid');
                    }

                    if (err.errKtpTempatLahir) {
                        $('#ktp_tempat_lahir').addClass('is-invalid');
                        $('.errorKtpTempatLahir').html(err.errKtpTempatLahir);
                    } else {
                        $('#ktp_tempat_lahir').removeClass('is-invalid');
                        $('#ktp_tempat_lahir').addClass('is-valid');
                    }

                    if (err.errKtpTanggalLahir) {
                        $('#ktp_tanggal_lahir').addClass('is-invalid');
                        $('.errorKtpTanggalLahir').html(err.errKtpTanggalLahir);
                    } else {
                        $('#ktp_tanggal_lahir').removeClass('is-invalid');
                        $('#ktp_tanggal_lahir').addClass('is-valid');
                    }

                    if (err.errKtpKelamin) {
                        $('#ktp_kelamin').addClass('is-invalid');
                        $('.errorKtpKelamin').html(err.errKtpKelamin);
                    } else {
                        $('#ktp_kelamin').removeClass('is-invalid');
                        $('#ktp_kelamin').addClass('is-valid');
                    }

                    if (err.errKtpAlamat) {
                        $('#ktp_alamat').addClass('is-invalid');
                        $('.errorKtpAlamat').html(err.errKtpAlamat);
                    } else {
                        $('#ktp_alamat').removeClass('is-invalid');
                        $('#ktp_alamat').addClass('is-valid');
                    }

                    if (err.errKtpRt) {
                        $('#ktp_rt').addClass('is-invalid');
                        $('.errorKtpRt').html(err.errKtpRt);
                    } else {
                        $('#ktp_rt').removeClass('is-invalid');
                        $('#ktp_rt').addClass('is-valid');
                    }

                    if (err.errKtpRw) {
                        $('#ktp_rw').addClass('is-invalid');
                        $('.errorKtpRw').html(err.errKtpRw);
                    } else {
                        $('#ktp_rw').removeClass('is-invalid');
                        $('#ktp_rw').addClass('is-valid');
                    }

                    if (err.errKelurahan) {
                        $('#kelurahan').addClass('is-invalid');
                        $('.errorKelurahan').html(err.errKelurahan);
                    } else {
                        $('#kelurahan').removeClass('is-invalid');
                        $('#kelurahan').addClass('is-valid');
                    }

                    if (err.errKecamatan) {
                        $('#kecamatan').addClass('is-invalid');
                        $('.errorKecamatan').html(err.errKecamatan);
                    } else {
                        $('#kecamatan').removeClass('is-invalid');
                        $('#kecamatan').addClass('is-valid');
                    }

                    if (err.errKotaKabupaten) {
                        $('#kota_kabupaten').addClass('is-invalid');
                        $('.errorKotaKabupaten').html(err.errKotaKabupaten);
                    } else {
                        $('#kota_kabupaten').removeClass('is-invalid');
                        $('#kota_kabupaten').addClass('is-valid');
                    }

                    if (err.errPropinsi) {
                        $('#propinsi').addClass('is-invalid');
                        $('.errorPropinsi').html(err.errPropinsi);
                    } else {
                        $('#propinsi').removeClass('is-invalid');
                        $('#propinsi').addClass('is-valid');
                    }

                    if (err.errKtpAlamatId) {
                        $('#kelurahanpilih').addClass('is-invalid');
                        $('.errorKtpAlamatId').html(err.errKtpAlamatId);
                    } else {
                        $('#kelurahanpilih').removeClass('is-invalid');
                        $('#kelurahanpilih').addClass('is-valid');
                    }

                    if (err.errKtpHp) {
                        $('#ktp_hp').addClass('is-invalid');
                        $('.errorKtpHp').html(err.errKtpHp);
                    } else {
                        $('#ktp_hp').removeClass('is-invalid');
                        $('#ktp_hp').addClass('is-valid');
                    }

                }

                if (response.sukses) {
                    Swal.fire(
                        'Berhasil',
                        response.success,
                        'success'
                    ).then((result) => {
                        location.reload();
                    })
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

<?= $this->endSection('isi') ?>