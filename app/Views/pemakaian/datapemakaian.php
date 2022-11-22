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
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row mb-2">
            <div class="col">
                <label for="">Filter Data</label>
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

        <table style="width: 100%;" id="datapemakai"
            class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Pemakai</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>
<script>
function listDataPemakaian() {
    var table = $('#datapemakai').dataTable({
        destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url() ?>/pemakaian/listDataPemakai",
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
    listDataPemakaian();

    $('#tombolTampil').click(function(e) {
        e.preventDefault();
        listDataPemakaian();
    });
});

function cetak(nomor) {
    let windowCetak = window.open('<?= base_url() ?>/pemakaian/cetakPemakaian/' + nomor, "Cetak Pemakaian",
        "width=1300, height=600");

    windowCetak.focus();
}

function hapus(nomor) {
    Swal.fire({
        title: 'Hapus Pemakaian?',
        text: "Apakah ingin menghapus pemakaian !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/pemakaian/hapusPemakaian",
                data: {
                    nomor: nomor
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        swal.fire('Berhasil', response.sukes, 'success');
                        listDataPemakaian();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}

function edit(nomor) {
    window.location.href = ('<?= base_url() ?>/pemakaian/edit/') + nomor;
}
</script>

<?= $this->endSection('isi') ?>