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
                    'onclick'   => "location.href=('" . site_url('pengembalian/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="row">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">No. Pengembalian</label>
                            <input type="text" name="pgmnomor" id="pgmnomor" value="<?= $pgmnomor ?>"
                                class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Tgl. Kembali</label>
                            <input type="date" name="pgmtanggal" id="pgmtanggal" class="form-control"
                                value="<?= $pgmtanggal ?>">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Cari Nama</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama" name="pengembaliamnama"
                                    id="pengembaliamnama" value="<?= $ktpnama ?>" readonly>
                                <input type="hidden" name="pgmoleh" id="pgmoleh" value="<?= $pgmoleh ?>">
                                <input type="hidden" name="pgmuser" id="pgmuser" value="<?= session()->namauser ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariPengembalian"
                                        title="Cari Nama"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Kode Barang</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode" name="pgmbrgkode"
                                    id="pgmbrgkode">
                                <input type="hidden" id="detpgmid">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"><i
                                            class="fas fa-search"></i></button>
                                </div>
                                <input type="hidden" name="detpgmpmkid" id="detpgmpmkid">
                                <div class="invalid-feedback errorPgmBrgKode"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="namabarang" id="namabarang"
                                placeholder="Nama Barang" readonly>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="">Stock</label>
                            <input type="number" class="form-control" name="brgstok" id="brgstok" placeholder="Stok"
                                readonly>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" class="form-control" name="pgmjumlah" id="pgmjumlah" value="1">
                            <div class="invalid-feedback errorPgmJumlah"></div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Kondisi</label>
                            <select name="pgmjenis" id="pgmjenis" class="form-control">
                                <option value="">Jenis Kondsi</option>
                                <option value=""></option>
                                <option value="Oke">Oke</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                            <div class="invalid-feedback errorPgmJenis"></div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="pgmketerangan" id="pgmketerangan"
                                placeholder="keterangan" autocomplete="off">
                            <div class="invalid-feedback errorPgmKeterangan"></div>
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
                    <div class="col-lg-12 tampilDataDetail">

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
                    Selesaikan Pengembalian</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>

<script>
function kosong() {
    $('#pgmbrgkode').val('');
    $('#detpgmpmkid').val('');
    $('#namabarang').val('');
    $('#brgstok').val('');
    $('#pgmjumlah').val('1');
    $('#pgmjenis').val('');
    $('#pgmketerangan').val('');
    $('#pgmbrgkode').focus();
}

$('#tombolCariBarang').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?= base_url() ?>/pengembalian/modalCariBarang",
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

function ambilDataBarang() {

    let pgmbrgkode = $('#pgmbrgkode').val();
    if (pgmbrgkode.length == 0) {
        swal.fire('Error', 'Kode barang harus diinput', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pengembalian/ambilDataBarang",
            data: {
                pgmbrgkode: pgmbrgkode
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
                    $('#brgstok').val(data.brgstok);

                    $('#jml').focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

}


function tampilDataDetail() {
    let pgmnomor = $('#pgmnomor').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pengembalian/tampilDataDetail",
        data: {
            pgmnomor: pgmnomor
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataDetail').html("<i class='fas fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataDetail').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function simpanDetail() {
    let pgmnomor = $('#pgmnomor').val();
    let pgmbrgkode = $('#pgmbrgkode').val();
    let pgmjenis = $('#pgmjenis').val();
    let pgmketerangan = $('#pgmketerangan').val();
    let pgmjumlah = $('#pgmjumlah').val();
    let detpgmpmkid = $('#detpgmpmkid').val();


    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pengembalian/simpanDetail",
        data: {
            pgmnomor: pgmnomor,
            pgmbrgkode: pgmbrgkode,
            pgmjenis: pgmjenis,
            pgmketerangan: pgmketerangan,
            pgmjumlah: pgmjumlah,
            detpgmpmkid: detpgmpmkid
        },
        dataType: "json",
        success: function(response) {

            if (response.error) {
                let err = response.error;

                if (err.errPgmBrgKode) {
                    $('#pgmbrgkode').addClass('is-invalid');
                    $('.errorPgmBrgKode').html(err.errPgmBrgKode);
                } else {
                    $('#pgmbrgkode').removeClass('is-invalid');
                    $('#pgmbrgkode').addClass('is-valid');
                }

                if (err.errPgmJumlah) {
                    $('#pgmjumlah').addClass('is-invalid');
                    $('.errorPgmJumlah').html(err.errPgmJumlah);
                } else {
                    $('#pgmjumlah').removeClass('is-invalid');
                    $('#pgmjumlah').addClass('is-valid');
                }

                if (err.errPgmJenis) {
                    $('#pgmjenis').addClass('is-invalid');
                    $('.errorPgmJenis').html(err.errPgmJenis);
                } else {
                    $('#pgmjenis').removeClass('is-invalid');
                    $('#pgmjenis').addClass('is-valid');
                }

                if (err.errPgmKeterangan) {
                    $('#pgmketerangan').addClass('is-invalid');
                    $('.errorPgmKeterangan').html(err.errPgmKeterangan);
                } else {
                    $('#pgmketerangan').removeClass('is-invalid');
                    $('#pgmketerangan').addClass('is-valid');
                }
            }

            if (response.sukses) {
                tampilDataDetail();
                kosong();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


$(document).ready(function() {
    tampilDataDetail();

    $('#tombolEditItem').click(function(e) {
        e.preventDefault();


        let detpgmid = $('#detpgmid').val();
        let pgmnomor = $('#pgmnomor').val();
        let pgmbrgkode = $('#pgmbrgkode').val();
        let pgmjenis = $('#pgmjenis').val();
        let pgmketerangan = $('#pgmketerangan').val();
        let pgmjumlah = $('#pgmjumlah').val();
        let detpgmpmkid = $('#detpgmpmkid').val();



        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pengembalian/editItem",
            data: {
                detpgmid: detpgmid,
                pgmnomor: pgmnomor,
                pgmbrgkode: pgmbrgkode,
                pgmjenis: pgmjenis,
                pgmketerangan: pgmketerangan,
                pgmjumlah: pgmjumlah,
                detpgmpmkid: detpgmpmkid
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.errPgmBrgKode) {
                        $('#pgmbrgkode').addClass('is-invalid');
                        $('.errorPgmBrgKode').html(err.errPgmBrgKode);
                    } else {
                        $('#pgmbrgkode').removeClass('is-invalid');
                        $('#pgmbrgkode').addClass('is-valid');
                    }

                    if (err.errPgmJumlah) {
                        $('#pgmjumlah').addClass('is-invalid');
                        $('.errorPgmJumlah').html(err.errPgmJumlah);
                    } else {
                        $('#pgmjumlah').removeClass('is-invalid');
                        $('#pgmjumlah').addClass('is-valid');
                    }

                    if (err.errPgmJenis) {
                        $('#pgmjenis').addClass('is-invalid');
                        $('.errorPgmJenis').html(err.errPgmJenis);
                    } else {
                        $('#pgmjenis').removeClass('is-invalid');
                        $('#pgmjenis').addClass('is-valid');
                    }

                    if (err.errPgmKeterangan) {
                        $('#pgmketerangan').addClass('is-invalid');
                        $('.errorPgmKeterangan').html(err.errPgmKeterangan);
                    } else {
                        $('#pgmketerangan').removeClass('is-invalid');
                        $('#pgmketerangan').addClass('is-valid');
                    }
                }


                if (response.sukses) {
                    swal.fire({
                        'icon': 'success',
                        'title': 'Berhasil',
                        'text': response.sukses
                    });
                    tampilDataDetail();
                    kosong();
                    $('#tombolBatal').fadeOut();
                    $('#tombolEditItem').fadeOut();
                    $('#pgmbrgkode').prop('readonly', false);
                    $('#pgmjenis').prop('disabled', false);
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
        simpanDetail();
    });

    $('#tombolSelesaiTransaksi').click(function(e) {
        e.preventDefault();


        let pgmnomor = $('#pgmnomor').val();

        Swal.fire({
            title: 'Selesai Pengembalian.',
            text: "Apakah yakin ingin menyelesaikan pengembalian ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Selesaikan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>/pengembalian/selesaiPengembalianEdit",
                    data: {
                        pgmnomor: pgmnomor,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.error
                            })
                        }

                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses
                            }).then((resul) => {
                                if (resul.isConfirmed) {
                                    location.href = (
                                        '<?= base_url() ?>/pengembalian/index'
                                    );
                                }
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })

    });
});
</script>

<?= $this->endsection('isi') ?>