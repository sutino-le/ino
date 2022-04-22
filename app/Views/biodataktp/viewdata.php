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



<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-sm btn-primary" id="tambahBiodataKtp"><i class="fas fa-plus-circle"></i>
                Tambah BiodataKtp</button>
        </div>
        <div class="card-body mt-1">
            <div class="table-responsive">

                <table style="width: 100%;" id="dataBiodataKtp" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat / Tgl.Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    function listDataBiodataKtp() {
        var table = $('#dataBiodataKtp').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/biodataktp/listData",
                "type": "POST",
            },
            "colomnDefs": [{
                "targets": [0, 6],
                "orderable": false,
            }, ],
        });
    }

    $(document).ready(function() {
        listDataBiodataKtp();
    });


    $(document).ready(function() {

        $('#tambahBiodataKtp').click(function(e) {
            e.preventDefault();
            window.location.href = ('/biodataktp/formtambah');
        });

    });

    function edit(ktp_nomor) {
        $.ajax({
            type: "post",
            url: "/biodataktp/formedit/" + ktp_nomor,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalEdit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function hapus(ktp_nomor) {
        $.ajax({
            url: "/biodataktp/hapus/" + ktp_nomor,
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    swal.fire(
                        'Berhasil',
                        response.sukses,
                        'success'
                    ).then((result) => {
                        window.location.reload();
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>