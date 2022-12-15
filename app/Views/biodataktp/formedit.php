<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<style>
.list-group-flush {
    height: 620px;
    overflow-y: auto;
}
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<div class='card'>
    <div class='card-header bg-secondary'>
        <div class='row'>
            <div class='col'>
                <?= form_button('', '<i class="fas fa-arrow-alt-circle-left"></i> Kembali', [
                    'class'     => 'btn btn-sm btn-warning',
                    'onclick'   => "location.href=('" . site_url('biodataktp/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>


    <?= form_open_multipart(base_url() . '/biodataktp/update', 'class="formupdate"'); ?>
    <?= csrf_field(); ?>




    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nomor KTP</label>
                            <input type="text" name="ktp_nomor" id="ktp_nomor" maxlength="16" minlength="16"
                                class="form-control" value="<?= $ktp_nomor ?>" placeholder="Masukan Nomor KTP...">
                            <div class="invalid-feedback errorKtpNomor"></div>
                            <input type="hidden" name="ktp_nomor_lama" id="ktp_nomor_lama" value="<?= $ktp_nomor ?>">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="ktp_nama" id="ktp_nama" class="form-control"
                                value="<?= $ktp_nama ?>" placeholder="Masukan Nama Lengkap...">
                            <div class="invalid-feedback errorKtpNama"></div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Tempat Lahir</label>
                            <input type="text" name="ktp_tempat_lahir" id="ktp_tempat_lahir" class="form-control"
                                value="<?= $ktp_tempat_lahir ?>" placeholder="Masukan Tempat Lahir...">
                            <div class="invalid-feedback errorKtpTempatLahir"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Tanggal Lahir</label>
                            <input type="date" name="ktp_tanggal_lahir" id="ktp_tanggal_lahir" class="form-control"
                                value="<?= $ktp_tanggal_lahir ?>">
                            <div class="invalid-feedback errorKtpTanggalLahir"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Jenis Kelamin</label>
                            <select name="ktp_kelamin" id="ktp_kelamin" class="form-control">
                                <option value="<?= $ktp_kelamin ?>" selected><?= $ktp_kelamin ?></option>
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
                            <label for="">Alamat</label>
                            <input type="text" name="ktp_alamat" id="ktp_alamat" class="form-control"
                                value="<?= $ktp_alamat ?>" placeholder="Masukan Alamat...">
                            <div class="invalid-feedback errorKtpAlamat"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">RT</label>
                            <input type="text" name="ktp_rt" id="ktp_rt" class="form-control" value="<?= $ktp_rt ?>"
                                placeholder="Masukan RT...">
                            <div class="invalid-feedback errorKtpRt"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">RW</label>
                            <input type="text" name="ktp_rw" id="ktp_rw" class="form-control" value="<?= $ktp_rw ?>"
                                placeholder="Masukan RW...">
                            <div class="invalid-feedback errorKtpRw"></div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kelurahan</label>
                            <input type="text" name="kelurahan" id="kelurahan" class="form-control"
                                value="<?= $kelurahan ?>" placeholder="Masukan Kelurahan..." readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" class="form-control"
                                value="<?= $kecamatan ?>" placeholder="Masukan Kecamatan..." readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kota / Kabupaten</label>
                            <input type="text" name="kota_kabupaten" id="kota_kabupaten" class="form-control"
                                value="<?= $kota_kabupaten ?>" placeholder="Masukan Kota / Kabupaten..." readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Propinsi</label>
                            <input type="text" name="propinsi" id="propinsi" class="form-control"
                                value="<?= $propinsi ?>" placeholder="Masukan Propinsi..." readonly>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Pilih Daerah</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode Wilayah" name="kelurahanpilih"
                                    id="kelurahanpilih" value="<?= $ktp_alamatid ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" id="tombolCariWilayah"
                                        title="Cari Wilayah"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="invalid-feedback errorKtpAlamatId"></div>
                                <input type="hidden" name="ktp_alamatid" id="ktp_alamatid" value="<?= $ktp_alamatid ?>">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nomor Hp</label>
                            <input type="text" name="ktp_hp" id="ktp_hp" class="form-control" value="<?= $ktp_hp ?>"
                                placeholder="Masukan Nomor HP...">
                            <div class="invalid-feedback errorKtpHp"></div>
                        </div>
                    </div>

                </div>

            </li>
        </ul>

    </div>

    <div class='card-footer bg-secondary'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i
                        class="fa fa-save"></i>
                    Selesai</button>
            </div>
        </div>
    </div>

    <?= form_close(); ?>

</div>

<div class="viewmodal" style="display: none;"></div>

<script>
$(document).ready(function() {
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
                        window.location.href = (
                            '<?= base_url() ?>/biodataktp/index');
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