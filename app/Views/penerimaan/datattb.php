<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr style="background-color: gray;" align="center">
            <th colspan="7">Terima Barang</th>
        </tr>
        <tr align="center">
            <th>No.</th>
            <th>ID</th>
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
                <td><?= $no++; ?></td>
                <td><?= $rowpenerimaan['ttbid']; ?></td>
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
</script>