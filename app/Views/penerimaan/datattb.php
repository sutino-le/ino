<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
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
                <td><?= $rowpenerimaan['ttbbrgkode']; ?></td>
                <td><?= $rowpenerimaan['brgnama']; ?></td>
                <td><?= $rowpenerimaan['ttbjml']; ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $rowpenerimaan['ttbid'] ?>')"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>