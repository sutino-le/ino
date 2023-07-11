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
                    <th>Nomor Pengingat</th>
                    <th>Tanggal</th>
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
                ingatnomor: $('#ingatnomor').val(),
                ingattanggal: $('#ingattanggal').val(),
                ingatuser: $('#ingatuser').val(),
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


function hapus(ingatnomor) {
    Swal.fire({
        title: 'Hapus Pengingat?',
        text: "Apakah ingin menghapus transaksi !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/pengingat/hapusTransaksi",
                data: {
                    ingatnomor: ingatnomor
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        swal.fire('Berhasil', response.sukes, 'success');
                        listDataPengingat();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}

function edit(ingatnomor) {
    window.location.href = ('<?= base_url() ?>/pengingat/edit/') + ingatnomor;
}
</script>

<?= $this->endSection('isi') ?>