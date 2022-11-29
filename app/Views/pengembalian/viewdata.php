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
        <?= form_button('', '<i class="fa fa-plus-circle"></i> Pengembalian', [
            'class'     => 'btn btn-sm btn-primary',
            'onclick'   => "location.href=('" . site_url('pengembalian/forminput') . "')"
        ]) ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <table style="width: 100%;" id="pengembalian"
            class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Dikembalikan</th>
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
function listData() {
    var table = $('#pengembalian').dataTable({
        destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url() ?>/pengembalian/listData",
            "type": "POST",
            "data": {
                tglawal: $('#tglawal').val(),
                tglakhir: $('#tglakhir').val(),
            }
        },
        "colomnDefs": [{
            "targets": [0, 5],
            "orderable": false,
        }, ],
    });
}

$(document).ready(function() {
    listData();

    $('#tombolTampil').click(function(e) {
        e.preventDefault();
        listData();
    });
});



function cetak(pgmnomor) {
    let windowCetak = window.open('<?= base_url() ?>/pengembalian/cetakPengembalian/' + pgmnomor, "Cetak Pengembalian",
        "width=1300, height=800");

    windowCetak.focus();
}


function hapus(pgmnomor) {
    Swal.fire({
        title: 'Hapus Pengembalian?',
        text: "Apakah ingin menghapus pengembalian !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/pengembalian/hapusPengembalian",
                data: {
                    pgmnomor: pgmnomor
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        swal.fire('Berhasil', response.sukes, 'success');
                        listData();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}

function edit(pgmnomor) {
    window.location.href = ('<?= base_url() ?>/pengembalian/edit/') + pgmnomor;
}
</script>

<?= $this->endSection('isi') ?>