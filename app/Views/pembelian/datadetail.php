<table class="table table-sm table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th style="text-align: right;">
                <?php
                $totalHarga = 0;
                foreach ($tampildata->getResultArray() as $row) :
                    $totalHarga += $row['detsubtotal'];
                endforeach;
                ?>
                <h2>Total : Rp. <?= number_format($totalHarga, 0, ",", "."); ?></h2>
                <input type="hidden" id="totalharga" value="<?= $totalHarga ?>">
            </th>
        </tr>
    </thead>
</table>

<table class="table table-sm table-hover table-bordered" style="width: 100%;" id="datadetail">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Jumlah</th>
            <th>Sub.Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
            <tr>
                <td>
                    <?= $no++; ?>
                    <input type="hidden" value="<?= $row['iddetail'] ?>" id="id">
                </td>
                <td><?= $row['detbrgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td align="right"><?= number_format($row['dethargamasuk'], 0, ",", "."); ?></td>
                <td align="right"><?= number_format($row['dethargajual'], 0, ",", "."); ?></td>
                <td align="right"><?= number_format($row['detjml'], 0, ",", "."); ?></td>
                <td align="right"><?= number_format($row['detsubtotal'], 0, ",", "."); ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['iddetail'] ?>')"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    function hapusItem(iddetail) {
        Swal.fire({
            title: 'Hapus Item ?',
            text: "Yakin ingin menghapus Item ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>/pembelian/hapusItemDetail",
                    data: {
                        iddetail: iddetail
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire('Berhasil', response.sukses, 'success');
                            tampilDataDetail();
                            kosong();
                        }
                    }
                });
            }
        })
    }

    $('#datadetail tbody').on('click', 'tr', function() {
        let row = $(this).closest('tr');

        let kodebarang = row.find('td:eq(1)').text();
        let id = row.find('td input').val();

        $('#iddetail').val(id);
        $('#kodebarang').val(kodebarang);

        $('#tombolBatal').fadeIn();
        $('#tombolEditItem').fadeIn();
        $('#kodebarang').prop('readonly', true);
        $('#tombolCari').prop('disabled', true);
        $('#tombolSimpanItem').fadeOut();
        ambilDataBarang();
    });

    $(document).on('click', '#tombolBatal', function(e) {
        e.preventDefault();
        kosong();
        tampilDataDetail();
        $('#tombolBatal').fadeOut();
        $('#tombolEditItem').fadeOut();
        $('#kodebarang').prop('readonly', false);
        $('#tombolCari').prop('disabled', false);
        $('#tombolSimpanItem').fadeIn();
    });
</script>