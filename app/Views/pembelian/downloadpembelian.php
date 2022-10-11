<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Faktur Pembelian</title>
</head>

<body onload="window.print();">


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

            <div class="row mb-4">
                <div class="col col-4 text-right">
                    <label for="">Filter Data</label>
                </div>
                <div class="col col-3">
                    <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" name="brgkode" id="brgkode">
                        <option value="">Pilih Barang</option>
                        <option value="">------------</option>
                        <?php foreach ($tampilpembelian->getResultArray() as $rowBarang) : ?>
                            <option value="<?= $rowBarang['brgkode'] ?>"><?= $rowBarang['brgnama'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col col-2">
                    <input type="date" name="tglawal" id="tglawal" class="form-control">
                </div>
                <div class="col col-2">
                    <input type="date" name="tglakhir" id="tglakhir" class="form-control">
                </div>
                <div class="col col-1">
                    <button type="button" class="btn btn-success" id="tombolTampil"><i class="fas fa-search"></i></button>
                    <button type="button" class="btn btn-secondary" id="tombolDownload"><i class="	fas fa-cloud-download-alt"></i></button>
                </div>
            </div>

            <table style="width: 100%;" id="datapembelian" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Beli</th>
                        <th>Jumlah</th>
                        <th>TotalHarga</th>
                        <th>Nama Suplier</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
    <script>
        function listDataPembelian() {
            var table = $('#datapembelian').dataTable({
                destroy: true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= base_url() ?>/pembelian/listDataPembelian",
                    "type": "POST",
                    "data": {
                        brgkode: $('#brgkode').val(),
                        tglawal: $('#tglawal').val(),
                        tglakhir: $('#tglakhir').val(),
                    }
                },
                "colomnDefs": [{
                    "targets": [0, 6],
                    "orderable": false,
                }, ],
            });
        }

        $(document).ready(function() {
            listDataPembelian();

            $('#tombolTampil').click(function(e) {
                e.preventDefault();
                listDataPembelian();
            });
        });

        function download(brgkode) {
            let windowCetak = window.open('<?= base_url() ?>/pembelian/cetakfaktur/' + brgkode, "Cetak Faktur Penjualan", "width=400, height=600");

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


</body>

</html>