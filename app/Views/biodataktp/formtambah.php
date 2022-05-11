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


    <?= form_open_multipart('biodataktp/simpan', 'class="formsimpan"'); ?>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nomor KTP</label>
                            <input type="text" name="ktp_nomor" id="ktp_nomor" class="form-control" placeholder="Masukan Nomor KTP...">
                            <div class="invalid-feedback errorKtpNomor"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="ktp_nama" id="ktp_nama" class="form-control" placeholder="Masukan Nama Lengkap...">
                            <div class="invalid-feedback errorKtpNama"></div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Tempat Lahir</label>
                            <input type="text" name="ktp_tempat_lahir" id="ktp_tempat_lahir" class="form-control" placeholder="Masukan Tempat Lahir...">
                            <div class="invalid-feedback errorKtpTempatLahir"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Tanggal Lahir</label>
                            <input type="date" name="ktp_tanggal_lahir" id="ktp_tanggal_lahir" class="form-control">
                            <div class="invalid-feedback errorKtpTanggalLahir"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Jenis Kelamin</label>
                            <select name="ktp_kelamin" id="ktp_kelamin" class="form-control">
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
                            <input type="text" name="ktp_alamat" id="ktp_alamat" class="form-control" placeholder="Masukan Alamat...">
                            <div class="invalid-feedback errorKtpAlamat"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">RT</label>
                            <input type="text" name="ktp_rt" id="ktp_rt" class="form-control" placeholder="Masukan RT...">
                            <div class="invalid-feedback errorKtpRt"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">RW</label>
                            <input type="text" name="ktp_rw" id="ktp_rw" class="form-control" placeholder="Masukan RW...">
                            <div class="invalid-feedback errorKtpRw"></div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kelurahan</label>
                            <input type="text" name="kelurahan" id="kelurahan" class="form-control" placeholder="Masukan Kelurahan..." readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Masukan Kecamatan..." readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kota / Kabupaten</label>
                            <input type="text" name="kota_kabupaten" id="kota_kabupaten" class="form-control" placeholder="Masukan Kota / Kabupaten..." readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Propinsi</label>
                            <input type="text" name="propinsi" id="propinsi" class="form-control" placeholder="Masukan Propinsi..." readonly>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Pilih Daerah</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode Wilayah" name="kelurahanpilih" id="kelurahanpilih" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" id="tombolCariWilayah" title="Cari Wilayah"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="invalid-feedback errorKtpAlamatId"></div>
                                <input type="hidden" name="ktp_alamatid" id="ktp_alamatid">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nomor Hp</label>
                            <input type="text" name="ktp_hp" id="ktp_hp" class="form-control" placeholder="Masukan Nomor HP...">
                            <div class="invalid-feedback errorKtpHp"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="ktp_email" id="ktp_email" class="form-control" placeholder="Masukan Email...">
                            <div class="invalid-feedback errorKtpEmail"></div>
                        </div>
                    </div>

                </div>

            </li>
        </ul>

    </div>

    <div class='card-footer bg-secondary'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i class="fa fa-save"></i>
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
                url: "/wilayah/modalData",
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

                        if (err.errKtpNomor) {
                            $('#ktp_nomor').addClass('is-invalid');
                            $('.errorKtpNomor').html(err.errKtpNomor);
                        }

                        if (err.errKtpNama) {
                            $('#ktp_nama').addClass('is-invalid');
                            $('.errorKtpNama').html(err.errKtpNama);
                        }

                        if (err.errKtpTempatLahir) {
                            $('#ktp_tempat_lahir').addClass('is-invalid');
                            $('.errorKtpTempatLahir').html(err.errKtpTempatLahir);
                        }

                        if (err.errKtpTanggalLahir) {
                            $('#ktp_tanggal_lahir').addClass('is-invalid');
                            $('.errorKtpTanggalLahir').html(err.errKtpTanggalLahir);
                        }

                        if (err.errKtpKelamin) {
                            $('#ktp_kelamin').addClass('is-invalid');
                            $('.errorKtpKelamin').html(err.errKtpKelamin);
                        }

                        if (err.errKtpAlamat) {
                            $('#ktp_alamat').addClass('is-invalid');
                            $('.errorKtpAlamat').html(err.errKtpAlamat);
                        }

                        if (err.errKtpRt) {
                            $('#ktp_rt').addClass('is-invalid');
                            $('.errorKtpRt').html(err.errKtpRt);
                        }

                        if (err.errKtpRw) {
                            $('#ktp_rw').addClass('is-invalid');
                            $('.errorKtpRw').html(err.errKtpRw);
                        }

                        if (err.errKtpAlamatId) {
                            $('#kelurahan').addClass('is-invalid');
                            $('#kecamatan').addClass('is-invalid');
                            $('#kota_kabupaten').addClass('is-invalid');
                            $('#propinsi').addClass('is-invalid');
                            $('#kelurahanpilih').addClass('is-invalid');
                            $('.errorKtpAlamatId').html(err.errKtpAlamatId);
                        }

                        if (err.errKtpHp) {
                            $('#ktp_hp').addClass('is-invalid');
                            $('.errorKtpHp').html(err.errKtpHp);
                        }

                        if (err.errKtpEmail) {
                            $('#ktp_email').addClass('is-invalid');
                            $('.errorKtpEmail').html(err.errKtpEmail);
                        }

                    }

                    if (response.sukses) {
                        Swal.fire(
                            'Berhasil',
                            response.success,
                            'success'
                        ).then((result) => {
                            window.location.reload();
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