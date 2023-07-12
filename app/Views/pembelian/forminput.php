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
                    'onclick'   => "location.href=('" . site_url('pembelian/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="row">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">No. PO</label>
                            <input type="number" name="nofaktur" id="nofaktur" value="<?= $nofaktur ?>"
                                class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Tgl. PO</label>
                            <input type="date" name="tglfaktur" id="tglfaktur" class="form-control"
                                value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control">
                                <option value="">Pilih Jenis</option>
                                <option value=""></option>
                                <option value="Pajak">Pajak</option>
                                <option value="Non Pajak">Non Pajak</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Cari Suplier</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Suplier" name="namasuplier"
                                    id="namasuplier" readonly>
                                <input type="hidden" name="idsuplier" id="idsuplier">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariSuplier"
                                        title="Cari Suplier"><i class="fas fa-search"></i></button>
                                    <button class="btn btn-outline-success" type="button" id="tombolTambahSuplier"
                                        title="Tambah Suplier"><i class="fas fa-plus-square"></i></button>
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
                                <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang"
                                    id="kodebarang">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"
                                        title="Cari Barang"><i class="fas fa-search"></i></button>
                                    <button class="btn btn-outline-success" type="button" id="tambahBarang"
                                        title="Tambah Barang"><i class="fas fa-plus-square"></i></button>
                                </div>
                                <div class="invalid-feedback errorKodeBarang"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="">Harga Jual</label>
                            <input type="text" class="form-control" name="hargajual" id="hargajual" readonly>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" class="form-control" name="jml" id="jml" value="1">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Harga Beli</label>
                            <input type="text" class="form-control" name="hargabeli" id="hargabeli" autocomplete="off">
                            <div class="invalid-feedback errorHargaBeli"></div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="detketerangan" id="detketerangan">
                            <div class="invalid-feedback errorKeterangan"></div>
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
                    Selesaikan Faktur</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>


<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>

<script>
$(document).ready(function() {

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

});


function kosong() {
    $('#kodebarang').val('');
    $('#namabarang').val('');
    $('#hargajual').val('');
    $('#hargabeli').val('');
    $('#jml').val('1');
    $('#detketerangan').val('');
    $('#kodebarang').focus();
}

function simpanItem() {
    let nofaktur = $('#nofaktur').val();
    let kodebarang = $('#kodebarang').val();
    let namabarang = $('#namabarang').val();
    let hargabeli = $('#hargabeli').val();
    let hargajual = $('#hargajual').val();
    let jml = $('#jml').val();
    let detketerangan = $('#detketerangan').val();


    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pembelian/simpanItem",
        data: {
            nofaktur: nofaktur,
            kodebarang: kodebarang,
            namabarang: namabarang,
            hargabeli: hargabeli,
            hargajual: hargajual,
            jml: jml,
            detketerangan: detketerangan,
        },
        dataType: "json",
        success: function(response) {

            if (response.error) {
                let err = response.error;

                if (err.errKodeBarang) {
                    $('#kodebarang').addClass('is-invalid');
                    $('.errorKodeBarang').html(err.errKodeBarang);
                } else {
                    $('#kodebarang').removeClass('is-invalid');
                    $('#kodebarang').addClass('is-valid');
                }

                if (err.errHargaBeli) {
                    $('#hargabeli').addClass('is-invalid');
                    $('.errorHargaBeli').html(err.errHargaBeli);
                } else {
                    $('#hargabeli').removeClass('is-invalid');
                    $('#hargabeli').addClass('is-valid');
                }

                if (err.errKeterangan) {
                    $('#detketerangan').addClass('is-invalid');
                    $('.errorKeterangan').html(err.errKeterangan);
                } else {
                    $('#detketerangan').removeClass('is-invalid');
                    $('#detketerangan').addClass('is-valid');
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

    let kodebarang = $('#kodebarang').val();
    if (kodebarang.length == 0) {
        swal.fire('Error', 'Kode barang harus diinput', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pembelian/ambilDataBarang",
            data: {
                kodebarang: kodebarang
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
                    $('#hargajual').val(data.hargajual);

                    $('#jml').focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

}


function tampilDataTemp() {
    let faktur = $('#nofaktur').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pembelian/tampilDataTemp",
        data: {
            nofaktur: faktur
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


function buatNoFaktur() {
    let tanggal = $('#tglfaktur').val();

    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/pembelian/buatNoFaktur",
        data: {
            tanggal: tanggal
        },
        dataType: "json",
        success: function(response) {
            $('#nofaktur').val(response.nofaktur);
            tampilDataTemp();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });

}

$(document).ready(function() {
    tampilDataTemp();
    $('#tglfaktur').change(function(e) {
        buatNoFaktur();
    });

    $('#tombolTambahSuplier').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/suplier/formtambah",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambahsuplier').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });



    $('#tombolCariSuplier').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url() ?>/suplier/modalData",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaldatasuplier').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#kodebarang').keydown(function(e) {
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
            url: "<?= base_url() ?>/pembelian/modalCariBarang",
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


        let jenis = $('#jenis').val();

        if (jenis.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Maaf, Jenis tidak boleh kosong'
            })
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/pembelian/modalPembayaran",
                data: {
                    nofaktur: $('#nofaktur').val(),
                    tglfaktur: $('#tglfaktur').val(),
                    jenis: $('#jenis').val(),
                    idsuplier: $('#idsuplier').val(),
                    totalharga: $('#totalharga').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        swal.fire('Error', response.error, 'error');
                        kosong();
                    }

                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalpembayaran').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }



    });

});
</script>

<?= $this->endsection('isi') ?>