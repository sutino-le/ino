<table class="table table-sm table-hover table-bordered" style="width: 100%;" id="datattb">
    <thead>
        <tr style="background-color: gray;" align="center">
            <th colspan="7">Terima Barang</th>
        </tr>
        <tr align="center">
            <th>No.</th>
            <th>ID Pembelian</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Penerima</th>
            <th>Jumlah Terima</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tampilpenerimaan->getResultArray() as $rowpenerimaan) :
        ?>
            <tr>
                <td>
                    <?= $no++; ?>
                    <input type="hidden" value="<?= $rowpenerimaan['ttbid'] ?>" id="ttbid">
                </td>
                <td><?= $rowpenerimaan['ttbpembelianid']; ?></td>
                <td><?= $rowpenerimaan['brgnama']; ?></td>
                <td align="center"><?= date('d F Y', strtotime($rowpenerimaan['ttbtanggal'])); ?></td>
                <td><?= $rowpenerimaan['ttbpenerima']; ?></td>
                <td align="center"><?= $rowpenerimaan['ttbjml']; ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusItemTtb('<?= $rowpenerimaan['ttbid'] ?>')"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    function hapusItemTtb(ttbid) {
        let faktur = $('#ttbfaktur').val();
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
                    url: "<?= base_url() ?>/penerimaan/hapusItemTtb",
                    data: {
                        ttbid: ttbid
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire('Berhasil', response.sukses, 'success');
                            tampilDataPembelian();
                            tampilTtb();
                        }
                    }
                });
            }
        })
    }

    $('#datattb tbody').on('click', 'tr', function() {
        let row = $(this).closest('tr');

        let id = row.find('td:eq(1)').text();
        let ttbid = row.find('td input').val();

        $('#kodebeli').val(id);
        $('#ttbid').val(ttbid);

        $('#tombolBatal').fadeIn();
        $('#tombolEditItem').fadeIn();
        $('#kodebarang').prop('readonly', true);
        $('#tombolCari').prop('disabled', true);
        $('#tombolSimpanTtb').fadeOut();
        ambilDataBarangBeli();
    });

    $(document).on('click', '#tombolBatal', function(e) {
        e.preventDefault();
        kosong();
        tampilDataPembelian();
        tampilTtb();
        $('#tombolBatal').fadeOut();
        $('#tombolEditItem').fadeOut();
        $('#kodebarang').prop('readonly', false);
        $('#tombolCari').prop('disabled', false);
        $('#tombolSimpanTtb').fadeIn();
    });
</script>