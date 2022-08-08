<table class="table table-striped table-sm">
    <tr style="background-color: gray;">
        <td>No</td>
        <td>Nama Barang</td>
        <td>Jumlah Pembelian</td>
        <td>Sudah Datang</td>
    </tr>
    <?php
    $nobeli = 1;
    foreach ($tampilpembelian->getResultArray() as $rowPembelian) :
    ?>
        <tr>
            <td><?= $nobeli++ ?></td>
            <td><?= $rowPembelian['brgnama'] ?></td>
            <td><?= $rowPembelian['detjml'] ?></td>
            <td></td>
        </tr>
    <?php endforeach ?>
</table>