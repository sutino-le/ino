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
        height: 400px;
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
                    'onclick'   => "location.href=('" . site_url('pembelian/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <table class="table table-striped table-sm">
                    <tr>
                        <input type="hidden" id="nofaktur" value="<?= $nofaktur ?>">
                        <td style="wwidth:20%;">No. Faktur</td>
                        <td style="wwidth:20%;">:</td>
                        <td style="wwidth:20%;"><?= $nofaktur ?></td>
                        <td rowspan="3" style="wwidth:20%; font-weight:bold; color:red; font-size:20pt; text-align:center; vertical-align:middle;" id="lbTotalHarga"></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?= $tanggal ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?= $tanggal ?></td>
                    </tr>
                </table>

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Kode Barang</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang" id="kodebarang">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Harga Jual (Rp)</label>
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
                            <label for="">Harga Beli (Rp)</label>
                            <input type="text" class="form-control" name="hargabeli" id="hargabeli" autocomplete="off">
                        </div>
                    </div>

                    <div class=" col-lg-2">
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
                    <div class="col-lg-12 tampilDataDetail">

                    </div>
                </div>

            </li>
        </ul>

    </div>

    <div class='card-footer'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i class="fa fa-save"></i>
                    Selesaikan Faktur</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>

<script>
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

    function ambilTotalHarga() {
        let nofaktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pembelian/ambilTotalHarga",
            data: {
                nofaktur: nofaktur
            },
            dataType: "json",
            success: function(response) {
                $('#lbTotalHarga').html(response.totalharga);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function kosong() {
        $('#kodebarang').val('');
        $('#namabarang').val('');
        $('#hargajual').val('');
        $('#hargabeli').val('');
        $('#jml').val('1');
        $('#kodebarang').focus();
    }


    function tampilDataDetail() {
        let faktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/pembelian/tampilDataDetail",
            data: {
                nofaktur: faktur
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


    $(document).ready(function() {
        ambilTotalHarga();
        tampilDataDetail();
    });

    $.ajax({
        type: "method",
        url: "url",
        data: "data",
        dataType: "dataType",
        success: function(response) {

        }
    });
</script>

<?= $this->endsection('isi') ?>