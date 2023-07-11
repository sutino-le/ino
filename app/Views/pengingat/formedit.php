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
    height: 550px;
    overflow-y: auto;
}

table#datadetail tbody tr:hover {
    cursor: pointer;
    background-color: #00e6e6;
    color: black;
}
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<div class='card'>
    <div class='card-header bg-info'>
        <div class='row'>
            <div class='col'>
                <?= form_button('', '<i class="fas fa-arrow-alt-circle-left"></i> Kembali', [
                    'class'     => 'btn btn-sm btn-warning',
                    'onclick'   => "location.href=('" . site_url('pengingat/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="row">

                    <table class="table table-striped table-sm">
                        <tr>
                            <input type="hidden" name="ingatnomor" id="ingatnomor" value="<?= $ingatnomor ?>">
                            <td style="width:20%;">No. </td>
                            <td style="width:10%;">:</td>
                            <td style="width:20%;"><?= $ingatnomor ?></td>
                            <td rowspan="3"
                                style="width:50%; font-weight:bold; color:red; font-size:20pt; text-align:center; vertical-align:middle;"
                                id="lbTotalHarga"></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td><?= $tanggal ?></td>
                        </tr>
                        <tr>
                            <td>User</td>
                            <td>:</td>
                            <td><?= $ingatuser ?></td>
                        </tr>
                    </table>

                </div>

                <div class="row">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kode Barang</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode" name="pgtbrgkode"
                                    id="pgtbrgkode">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"><i
                                            class="fas fa-search"></i></button>
                                    <button class="btn btn-outline-success" type="button" id="tambahBarang"
                                        title="Tambah Barang"><i class="fas fa-plus-square"></i></button>
                                </div>
                                <div class="invalid-feedback errorPgtBrgKode"></div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" class="form-control" name="pgtid" id="pgtid">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="namabarang" id="namabarang"
                                placeholder="Nama Barang" readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Lokasi</label>
                            <input type="text" class="form-control" name="pgtlocation" id="pgtlocation"
                                placeholder="Lokasi" autocomplete="off">
                            <div class="invalid-feedback errorPgtLocation"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Cari User</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama User" name="pgtnama"
                                    id="pgtnama" readonly>
                                <input type="hidden" name="pgtuser" id="pgtuser">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariUser"
                                        title="Cari Nama"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="invalid-feedback errorPgtUser"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">


                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Tgl. Awal</label>
                            <input type="date" name="pgtawal" id="pgtawal" class="form-control">
                            <div class="invalid-feedback errorPgtAwal"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Tgl. Akhir</label>
                            <input type="date" name="pgtakhir" id="pgtakhir" class="form-control">
                            <div class="invalid-feedback errorPgtAkhir"></div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="pgtketerangan" id="pgtketerangan"
                                placeholder="keterangan" autocomplete="off">
                            <div class="invalid-feedback errorPgtKeterangan"></div>
                        </div>
                    </div>

                    <div class=" col-lg-1">
                        <div class="form-group">
                            <label for="">#</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-success" title="Simpan Item" id="tombolSimpanItem">
                                    <i class="fas fa-plus-square"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-primary" style="display: none;"
                                    title="Edit Item" id="tombolEditItem"><i class="fa fa-edit"></i></button>
                                &nbsp;
                                <button type="button" class="btn btn-sm btn-default" style="display: none;"
                                    title="Batalkan" id="tombolBatal"><i class="fa fa-sync-alt"></i></button>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12 tampilDataPengingat">

                    </div>
                </div>

            </li>
        </ul>

    </div>

    <div class='card-footer'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i
                        class="fa fa-save"></i>
                    Selesaikan Pengingat</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>


<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>

<script>
function kosong() {
    $('#pgtid').val('');
    $('#pgtakhir').val('');
    $('#pgtbrgkode').val('');
    $('#namabarang').val('');
    $('#pgtlocation').val('');
    $('#pgtnama').val('');
    $('#pgtuser').val('');
    $('#pgtawal').val('');
    $('#pgtakhir').val('');
    $('#pgtketerangan').val('');
    $('#pgtbrgkode').focus();
}


function ambilDataBarang() {

    let pgtbrgkode = $('#pgtbrgkode').val();
    if (pgtbrgkode.length == 0) {
        swal.fire('Error', 'Kode barang harus diinput', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pengingat/ambilDataBarang",
            data: {
                pgtbrgkode: pgtbrgkode
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    swal.fire('Error', response.error, 'error');
                    kosong();
                }

                if (response.sukses) {
                    let data = response.sukses;

                    $('#namabarang').val(data.namabarang);

                    $('#pgtnama').focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

}

function ambilDataPengingat() {

    let pgtid = $('#pgtid').val();
    if (pgtid.length == 0) {
        swal.fire('Error', 'Kode barang harus diinput', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pengingat/ambilDataPengingat",
            data: {
                pgtid: pgtid
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    swal.fire('Error', response.error, 'error');
                    kosong();
                }

                if (response.sukses) {
                    let data = response.sukses;

                    $('#ingatnomor').val(data.ingatnomor);
                    $('#pgtawal').val(data.pgtawal);
                    $('#pgtakhir').val(data.pgtakhir);
                    $('#pgtuser').val(data.pgtuser);
                    $('#ingatnama').val(data.ingatnama);
                    $('#pgtbrgkode').val(data.pgtbrgkode);
                    $('#namabarang').val(data.namabarang);
                    $('#pgtlocation').val(data.pgtlocation);
                    $('#pgtketerangan').val(data.pgtketerangan);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

}

function tampilDataPengingat() {
    let ingatnomor = $('#ingatnomor').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pengingat/tampilDataPengingatDet",
        data: {
            ingatnomor: ingatnomor
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataPengingat').html("<i class='fas fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataPengingat').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


function simpanItem() {
    let ingatnomor = $('#ingatnomor').val();
    let pgtbrgkode = $('#pgtbrgkode').val();
    let pgtlocation = $('#pgtlocation').val();
    let pgtawal = $('#pgtawal').val();
    let pgtakhir = $('#pgtakhir').val();
    let pgtuser = $('#pgtuser').val();
    let pgtketerangan = $('#pgtketerangan').val();


    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pengingat/simpanDetail",
        data: {
            ingatnomor: ingatnomor,
            pgtbrgkode: pgtbrgkode,
            pgtlocation: pgtlocation,
            pgtawal: pgtawal,
            pgtakhir: pgtakhir,
            pgtuser: pgtuser,
            pgtketerangan: pgtketerangan,
        },
        dataType: "json",
        success: function(response) {

            if (response.error) {
                let err = response.error;

                if (err.errIngatNomor) {
                    $('#ingatnomor').addClass('is-invalid');
                    $('.errorIngatNomor').html(err.errIngatNomor);
                } else {
                    $('#ingatnomor').removeClass('is-invalid');
                    $('#ingatnomor').addClass('is-valid');
                }

                if (err.errPgtBrgKode) {
                    $('#pgtbrgkode').addClass('is-invalid');
                    $('.errorPgtBrgKode').html(err.errPgtBrgKode);
                } else {
                    $('#pgtbrgkode').removeClass('is-invalid');
                    $('#pgtbrgkode').addClass('is-valid');
                }

                if (err.errPgtLocation) {
                    $('#pgtlocation').addClass('is-invalid');
                    $('.errorPgtLocation').html(err.errPgtLocation);
                } else {
                    $('#pgtlocation').removeClass('is-invalid');
                    $('#pgtlocation').addClass('is-valid');
                }

                if (err.errPgtAwal) {
                    $('#pgtawal').addClass('is-invalid');
                    $('.errorPgtAwal').html(err.errPgtAwal);
                } else {
                    $('#pgtawal').removeClass('is-invalid');
                    $('#pgtawal').addClass('is-valid');
                }

                if (err.errPgtAkhir) {
                    $('#pgtakhir').addClass('is-invalid');
                    $('.errorPgtAkhir').html(err.errPgtAkhir);
                } else {
                    $('#pgtakhir').removeClass('is-invalid');
                    $('#pgtakhir').addClass('is-valid');
                }

                if (err.errPgtUser) {
                    $('#pgtnama').addClass('is-invalid');
                    $('.errorPgtUser').html(err.errPgtUser);
                } else {
                    $('#pgtnama').removeClass('is-invalid');
                    $('#pgtnama').addClass('is-valid');
                }
            }

            if (response.sukses) {
                tampilDataPengingat();
                kosong();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


$(document).ready(function() {

    tampilDataPengingat();

    $('#tambahBarang').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/barang/formtambah",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalTambah').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolCariUser').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url() ?>/biodataktp/modalData",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaldataktp').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolCariBarang').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url() ?>/pengingat/modalCariBarang",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalcaribarang').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });



    $('#pgtbrgkode').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilDataBarang();
        }
    });

    $('#tombolEditItem').click(function(e) {
        e.preventDefault();



        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pengingat/editItem",
            data: {
                pgtid: $('#pgtid').val(),
                pgtbrgkode: $('#pgtbrgkode').val(),
                pgtlocation: $('#pgtlocation').val(),
                pgtawal: $('#pgtawal').val(),
                pgtakhir: $('#pgtakhir').val(),
                pgtuser: $('#pgtuser').val(),
                pgtketerangan: $('#pgtketerangan').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.errPgtBrgKode) {
                        $('#pgtbrgkode').addClass('is-invalid');
                        $('.errorPgtBrgKode').html(err.errPgtBrgKode);
                    } else {
                        $('#pgtbrgkode').removeClass('is-invalid');
                        $('#pgtbrgkode').addClass('is-valid');
                    }

                    if (err.errPgtLocation) {
                        $('#pgtlocation').addClass('is-invalid');
                        $('.errorPgtLocation').html(err.errPgtLocation);
                    } else {
                        $('#pgtlocation').removeClass('is-invalid');
                        $('#pgtlocation').addClass('is-valid');
                    }

                    if (err.errPgtAwal) {
                        $('#pgtawal').addClass('is-invalid');
                        $('.errorPgtAwal').html(err.errPgtAwal);
                    } else {
                        $('#pgtawal').removeClass('is-invalid');
                        $('#pgtawal').addClass('is-valid');
                    }

                    if (err.errPgtAkhir) {
                        $('#pgtakhir').addClass('is-invalid');
                        $('.errorPgtAkhir').html(err.errPgtAkhir);
                    } else {
                        $('#pgtakhir').removeClass('is-invalid');
                        $('#pgtakhir').addClass('is-valid');
                    }

                    if (err.errPgtUser) {
                        $('#pgtnama').addClass('is-invalid');
                        $('.errorPgtUser').html(err.errPgtUser);
                    } else {
                        $('#pgtnama').removeClass('is-invalid');
                        $('#pgtnama').addClass('is-valid');
                    }
                }


                if (response.sukses) {
                    swal.fire({
                        'icon': 'success',
                        'title': 'Berhasil',
                        'text': response.sukses
                    });
                    tampilDataPengingat();
                    kosong();
                    $('#tombolBatal').fadeOut();
                    $('#tombolEditItem').fadeOut();
                    $('#pgtbrgkode').prop('readonly', false);
                    $('#tombolCari').prop('disabled', false);
                    $('#tombolSimpanItem').fadeIn();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolSimpanItem').click(function(e) {
        e.preventDefault();
        simpanItem();
    });



    $('#tombolSelesaiTransaksi').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Selesaikan Edit?',
            text: "Apakah ingin selesaikan transaksi !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Batal!'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = ('<?= base_url() ?>/pengingat/index');
            }
        })
    });

});
</script>

<?= $this->endsection('isi') ?>