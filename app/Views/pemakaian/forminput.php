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
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<div class='card'>
    <div class='card-header bg-info'>
        <div class='row'>
            <div class='col'>
                <?= form_button('', '<i class="fas fa-arrow-alt-circle-left"></i> Kembali', [
                    'class'     => 'btn btn-sm btn-warning',
                    'onclick'   => "location.href=('" . site_url('pemakaian/index') . "')"
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
                            <label for="">No. Pemakaian</label>
                            <input type="text" name="pmknomor" id="pmknomor" value="<?= $pmknomor ?>"
                                class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Tgl. Pakai</label>
                            <input type="date" name="pmktanggal" id="pmktanggal" class="form-control"
                                value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Cari Pemakai</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Pemakai" name="pemakainama"
                                    id="pemakainama" readonly>
                                <input type="hidden" name="pemakai" id="pemakai">
                                <input type="hidden" name="pmkuser" id="pmkuser" value="<?= session()->namauser ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariPemakai"
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
                                <input type="text" class="form-control" placeholder="Kode" name="pmkbrgkode"
                                    id="pmkbrgkode">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"><i
                                            class="fas fa-search"></i></button>
                                </div>
                                <div class="invalid-feedback errorPmkBrgKode"></div>
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
                            <div class="invalid-feedback errorBrgStok"></div>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" class="form-control" name="pmkjumlah" id="pmkjumlah" value="1">
                            <div class="invalid-feedback errorPmkJumlah"></div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Jenis</label>
                            <select name="pmkjenis" id="pmkjenis" class="form-control">
                                <option value="">Jenis Pemakaian</option>
                                <option value=""></option>
                                <option value="Pemakaian">Pemakaian</option>
                                <option value="Peminjaman">Peminjaman</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Servis">Servis</option>
                            </select>
                            <div class="invalid-feedback errorPmkJenis"></div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="pmkketerangan" id="pmkketerangan"
                                placeholder="keterangan" autocomplete="off">
                            <div class="invalid-feedback errorPmkKeterangan"></div>
                        </div>
                    </div>

                    <div class=" col-lg-1">
                        <div class="form-group">
                            <label for="">#</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-success" title="Simpan Item" id="tombolSimpanItem">
                                    <i class="fas fa-plus-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12 tampilDataTemp">

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
                    Selesaikan Pemakaian</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>


<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>

<script>
function kosong() {
    $('#pmkbrgkode').val('');
    $('#namabarang').val('');
    $('#brgstok').val('');
    $('#pmkjumlah').val('1');
    $('#pmkjenis').val('');
    $('#pmkketerangan').val('');
    $('#pmkbrgkode').focus();
}

function simpanItem() {
    let pmknomor = $('#pmknomor').val();
    let pmkbrgkode = $('#pmkbrgkode').val();
    let namabarang = $('#namabarang').val();
    let brgstok = $('#brgstok').val();
    let pmkjenis = $('#pmkjenis').val();
    let pmkketerangan = $('#pmkketerangan').val();
    let pmkjumlah = $('#pmkjumlah').val();


    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pemakaian/simpanItem",
        data: {
            pmknomor: pmknomor,
            pmkbrgkode: pmkbrgkode,
            namabarang: namabarang,
            brgstok: brgstok,
            pmkjenis: pmkjenis,
            pmkketerangan: pmkketerangan,
            pmkjumlah: pmkjumlah
        },
        dataType: "json",
        success: function(response) {

            if (response.error) {
                let err = response.error;

                if (err.errPmkBrgKode) {
                    $('#pmkbrgkode').addClass('is-invalid');
                    $('.errorPmkBrgKode').html(err.errPmkBrgKode);
                } else {
                    $('#pmkbrgkode').removeClass('is-invalid');
                    $('#pmkbrgkode').addClass('is-valid');
                }

                if (err.errBrgStok) {
                    $('#brgstok').addClass('is-invalid');
                    $('.errorBrgStok').html(err.errBrgStok);
                } else {
                    $('#brgstok').removeClass('is-invalid');
                    $('#brgstok').addClass('is-valid');
                }

                if (err.errPmkJumlah) {
                    $('#pmkjumlah').addClass('is-invalid');
                    $('.errorPmkJumlah').html(err.errPmkJumlah);
                } else {
                    $('#pmkjumlah').removeClass('is-invalid');
                    $('#pmkjumlah').addClass('is-valid');
                }

                if (err.errPmkJenis) {
                    $('#pmkjenis').addClass('is-invalid');
                    $('.errorPmkJenis').html(err.errPmkJenis);
                } else {
                    $('#pmkjenis').removeClass('is-invalid');
                    $('#pmkjenis').addClass('is-valid');
                }

                if (err.errPmkKeterangan) {
                    $('#pmkketerangan').addClass('is-invalid');
                    $('.errorPmkKeterangan').html(err.errPmkKeterangan);
                } else {
                    $('#pmkketerangan').removeClass('is-invalid');
                    $('#pmkketerangan').addClass('is-valid');
                }
            }

            if (response.sukses) {
                tampilDataTemp();
                kosong();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


function ambilDataBarang() {

    let pmkbrgkode = $('#pmkbrgkode').val();
    if (pmkbrgkode.length == 0) {
        swal.fire('Error', 'Kode barang harus diinput', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pemakaian/ambilDataBarang",
            data: {
                pmkbrgkode: pmkbrgkode
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

                    $('#pmkjumlah').focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

}


function tampilDataTemp() {
    let pmknomor = $('#pmknomor').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pemakaian/tampilDataTemp",
        data: {
            pmknomor: pmknomor
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataTemp').html("<i class='fas fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataTemp').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


function buatNoPakai() {
    let tanggal = $('#pmktanggal').val();

    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pemakaian/buatNoPakai",
        data: {
            tanggal: tanggal
        },
        dataType: "json",
        success: function(response) {
            $('#pmknomor').val(response.pmknomor);
            tampilDataTemp();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });

}

$(document).ready(function() {
    tampilDataTemp();
    $('#pmktanggal').change(function(e) {
        buatNoPakai();
    });



    $('#tombolCariPemakai').click(function(e) {
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

    $('#pmkbrgkode').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilDataBarang();
        }
    });

    $('#tombolSimpanItem').click(function(e) {
        e.preventDefault();
        simpanItem();
    });

    $('#tombolCariBarang').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url() ?>/pemakaian/modalCariBarang",
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

    $('#tombolSelesaiTransaksi').click(function(e) {
        e.preventDefault();


        let pmknomor = $('#pmknomor').val();
        let pmktanggal = $('#pmktanggal').val();
        let pemakai = $('#pemakai').val();
        let pmkuser = $('#pmkuser').val();

        if (pmknomor.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Maaf, Nomor tidak boleh kosong'
            })
        } else if (pmktanggal.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Maaf, Tanggal tidak boleh kosong'
            })
        } else if (pemakai.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Maaf, Pemakai tidak boleh kosong'
            })
        } else if (pmkuser.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Maaf, User tidak boleh kosong'
            })
        } else {
            Swal.fire({
                title: 'Selesai Pemakaian.',
                text: "Apakah yakin ingin menyelesaikan pemakaian ?",
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
                        url: "<?= base_url() ?>/pemakaian/selesaiPemakaian",
                        data: {
                            pmknomor: pmknomor,
                            pmktanggal: pmktanggal,
                            pemakai: pemakai,
                            pmkuser: pmkuser,
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
                                        window.location
                                            .reload();
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
        }
    });

});
</script>

<?= $this->endsection('isi') ?>