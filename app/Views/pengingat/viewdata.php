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
        <?= form_button('', '<i class="fa fa-plus-circle"></i> Pengingat', [
            'class'     => 'btn btn-sm btn-primary',
            'onclick'   => "location.href=('" . site_url('pengingat/input') . "')"
        ]) ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row mb-2">

        </div>

        <table style="width: 100%;" id="datapengingat"
            class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Lokasi</th>
                    <th>Tgl Awal</th>
                    <th>Tgl Akhir</th>
                    <th>User</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>
<script>
function listDataPengingat() {
    var table = $('#datapengingat').dataTable({
        destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url() ?>/pengingat/listData",
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
    listDataPengingat();

    $('#tombolTampil').click(function(e) {
        e.preventDefault();
        listDataPengingat();
    });
});



function cetak(nottb) {
    let windowCetak = window.open('<?= base_url() ?>/pengingat/cetakTtb/' + nottb, "Cetak Pengingat Barang",
        "width=1300, height=600");

    windowCetak.focus();
}
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

<?= $this->endSection('isi') ?>