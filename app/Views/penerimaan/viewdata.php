<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="card">
    <div class="card-header">
        <?= form_button('', '<i class="fa fa-plus-circle"></i> Input TTB', [
            'class'     => 'btn btn-sm btn-primary',
            'onclick'   => "location.href=('" . site_url('penerimaan/input') . "')"
        ]) ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row mb-2">
            <div class="col">
                <label for="">Filter Data</label>
            </div>
            <div class="col">
                <select class="form-control" name="nofaktur" id="nofaktur">
                    <option value="">Pilih No. Faktur</option>
                    <option value=""></option>
                    <?php foreach ($datapembelian as $rowfaktur) : ?>
                        <option value="<?= $rowfaktur['faktur'] ?>"><?= $rowfaktur['faktur'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col">
                <input type="date" name="tglawal" id="tglawal" class="form-control">
            </div>
            <div class="col">
                <input type="date" name="tglakhir" id="tglakhir" class="form-control">
            </div>
            <div class="col">
                <button type="button" class="btn btn-block btn-primary" id="tombolTampil">Tampilkan</button>
            </div>
        </div>

        <table style="width: 100%;" id="datattb" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor TTB</th>
                    <th>Faktur</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Penerima</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>
<script>
    function listDataPenerimaan() {
        var table = $('#datattb').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>/penerimaan/listData",
                "type": "POST",
                "data": {
                    nofaktur: $('#nofaktur').val(),
                    tglawal: $('#tglawal').val(),
                    tglakhir: $('#tglakhir').val(),
                }
            },
            "colomnDefs": [{
                "targets": [0, 7],
                "orderable": false,
            }, ],
        });
    }

    $(document).ready(function() {
        listDataPenerimaan();

        $('#tombolTampil').click(function(e) {
            e.preventDefault();
            listDataPenerimaan();
        });
    });
</script>

<?= $this->endSection('isi') ?>