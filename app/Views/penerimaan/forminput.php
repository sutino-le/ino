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
    height: 600px;
    overflow-y: auto;
}



.list-group-flush {
    height: 550px;
    overflow-y: auto;
}

table#datattb tbody tr:hover {
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
                    'onclick'   => "location.href=('" . site_url('penerimaan/index') . "')"
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
                            <label for="">No. TTB</label>
                            <input type="text" name="nottb" id="nottb" value="<?= $nottb ?>" class="form-control"
                                readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Tgl. TTB</label>
                            <input type="date" name="tglttb" id="tglttb" class="form-control"
                                value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Pilih Faktur</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                                name="ttbfaktur" id="ttbfaktur">
                                <option value="">Pilih Faktur</option>
                                <option value="">------------</option>
                                <?php foreach ($tampilfaktur as $rowFaktur) : ?>
                                <option value="<?= $rowFaktur['faktur'] ?>"><?= $rowFaktur['faktur'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback errorTtbFaktur"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Penerima</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="<?= $penerima ?>"
                                    placeholder="Nama Penerima" name="penerima" id="penerima">
                                <div class="invalid-feedback errorPenerima"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <hr style="height:2px;border-width:0;color:white;background-color:gray">

                <div class="row">
                    <div class="col-lg-12 tampilDataPembelian">

                    </div>
                </div>

                <hr style="height:2px;border-width:0;color:white;background-color:gray">

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">ID Pembelian</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode Pembelian" name="kodebeli"
                                    id="kodebeli">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"><i
                                            class="fas fa-search"></i></button>
                                </div>
                                <div class="invalid-feedback errorKodeBeli"></div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" class="form-control" placeholder="Kode Barang" name="kodebarang"
                        id="kodebarang">
                    <input type="hidden" class="form-control" placeholder="Kode TTB" name="ttbid" id="ttbid">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Total Order</label>
                            <input type="text" class="form-control" name="detjml" id="detjml" readonly>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Jumlah Terima</label>
                            <input type="number" class="form-control" name="jml" id="jml" value="">
                            <div class="invalid-feedback errorJumlah"></div>
                        </div>
                    </div>

                    <div class=" col-lg-2">
                        <div class="form-group">
                            <label for="">#</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-success" title="Simpan Item"
                                    id="tombolSimpanTtb"><i class="fas fa-plus-square"></i></button>

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
                    <div class="col-lg-12 tampilTerimaBarang">

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
                    Selesaikan TTB</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>


<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>

<script>
function kosong() {
    $('#kodebeli').val('');
    $('#kodebarang').val('');
    $('#namabarang').val('');
    $('#detjml').val('');
    $('#jml').val('');
    $('#kodebeli').focus();
}


function simpanItem() {
    let faktur = $('#ttbfaktur').val();
    let nottb = $('#nottb').val();
    let tglttb = $('#tglttb').val();
    let ttbfaktur = $('#ttbfaktur').val();
    let penerima = $('#penerima').val();
    let kodebeli = $('#kodebeli').val();
    let kodebarang = $('#kodebarang').val();
    let namabarang = $('#namabarang').val();
    let detjml = $('#detjml').val();
    let jml = $('#jml').val();


    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/penerimaan/simpanItemTtb",
        data: {
            nottb: nottb,
            tglttb: tglttb,
            ttbfaktur: ttbfaktur,
            penerima: penerima,
            kodebeli: kodebeli,
            kodebarang: kodebarang,
            namabarang: namabarang,
            detjml: detjml,
            jml: jml
        },
        dataType: "json",
        success: function(response) {

            if (response.error) {
                let err = response.error;

                if (err.errTtbFaktur) {
                    $('#ttbfaktur').addClass('is-invalid');
                    $('.errorTtbFaktur').html(err.errTtbFaktur);
                } else {
                    $('#ttbfaktur').removeClass('is-invalid');
                    $('#ttbfaktur').addClass('is-valid');
                }

                if (err.errPenerima) {
                    $('#penerima').addClass('is-invalid');
                    $('.errorPenerima').html(err.errPenerima);
                } else {
                    $('#penerima').removeClass('is-invalid');
                    $('#penerima').addClass('is-valid');
                }

                if (err.errKodeBeli) {
                    $('#kodebeli').addClass('is-invalid');
                    $('.errorKodeBeli').html(err.errKodeBeli);
                } else {
                    $('#kodebeli').removeClass('is-invalid');
                    $('#kodebeli').addClass('is-valid');
                }

                if (err.errJumlah) {
                    $('#jml').addClass('is-invalid');
                    $('.errorJumlah').html(err.errJumlah);
                } else {
                    $('#jml').removeClass('is-invalid');
                    $('#jml').addClass('is-valid');
                }
            }

            if (response.sukses) {
                swal.fire('Berhasil', response.sukses, 'success');
                tampilDataPembelian();
                tampilTtb();
                kosong();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


function buatNoTtb() {
    let tanggal = $('#tglttb').val();

    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/penerimaan/buatNoTtb",
        data: {
            tanggal: tanggal
        },
        dataType: "json",
        success: function(response) {
            $('#nottb').val(response.nottb);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });

}


function tampilDataPembelian() {
    let faktur = $('#ttbfaktur').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/penerimaan/tampilDataPembelian",
        data: {
            nofaktur: faktur
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataPembelian').html("<i class='fas fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataPembelian').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


function tampilTtb() {
    let faktur = $('#ttbfaktur').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/penerimaan/tampilTtb",
        data: {
            nofaktur: faktur
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilTerimaBarang').html("<i class='fas fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilTerimaBarang').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}



function ambilDataBarangBeli() {

    let kodebeli = $('#kodebeli').val();
    if (kodebeli.length == 0) {
        swal.fire('Error', 'Kode barang harus diinput', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/penerimaan/ambilDataBarangBeli",
            data: {
                kodebeli: kodebeli
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    swal.fire('Error', response.error, 'error');
                    kosong();
                }

                if (response.sukses) {
                    let data = response.sukses;

                    $('#kodebarang').val(data.kodebarang);
                    $('#namabarang').val(data.namabarang);
                    $('#detjml').val(data.detjml);

                    $('#jml').focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

}

$(document).ready(function() {
    $('#tglttb').change(function(e) {
        buatNoTtb();
    });

    $('#ttbfaktur').change(function(e) {
        tampilDataPembelian();
        tampilTtb();
    });

    $('#tombolSimpanTtb').click(function(e) {
        e.preventDefault();
        simpanItem();
    });



    $('#tombolCariBarang').click(function(e) {
        e.preventDefault();

        let faktur = $('#ttbfaktur').val();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/penerimaan/modalCariBarangBeli",
            data: {
                faktur: faktur
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalcaribarangbeli').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolEditItem').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/penerimaan/editItemTtb",
            data: {
                ttbid: $('#ttbid').val(),
                jml: $('#jml').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.errJumlah) {
                        $('#jml').addClass('is-invalid');
                        $('.errorJumlah').html(err.errJumlah);
                    } else {
                        $('#jml').removeClass('is-invalid');
                        $('#jml').addClass('is-valid');
                    }
                }


                if (response.sukses) {
                    swal.fire({
                        'icon': 'success',
                        'title': 'Berhasil',
                        'text': response.sukses
                    });
                    kosong();
                    tampilDataPembelian();
                    tampilTtb();
                    $('#tombolBatal').fadeOut();
                    $('#tombolEditItem').fadeOut();
                    $('#kodebarang').prop('readonly', false);
                    $('#tombolCari').prop('disabled', false);
                    $('#tombolSimpanTtb').fadeIn();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

});


$('#tombolSelesaiTransaksi').click(function(e) {
    e.preventDefault();
    window.location.href = "<?= base_url() ?>/penerimaan/index";
});
</script>



<link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
<script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->

<script>
$(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

})
</script>

<?= $this->endsection('isi') ?>