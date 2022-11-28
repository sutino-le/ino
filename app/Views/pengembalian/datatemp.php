<hr style="height:2px;border-width:0;color:white;background-color:white">

<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Ketarangan</th>
            <th>Jumlah</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['pgmbrgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td><?= $row['pgmjenis']; ?></td>
                <td><?= $row['pgmketerangan']; ?></td>
                <td align="right"><?= number_format($row['pgmjumlah'], 0, ",", "."); ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['detpgmid'] ?>')"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    function hapusItem(detpgmid) {
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
                    url: "<?= base_url() ?>/pengembalian/hapusItem",
                    data: {
                        detpgmid: detpgmid
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire('Berhasil', response.sukses, 'success');
                            tampilDataTemp();
                            kosong();
                        }
                    }
                });
            }
        })
    }
</script>