<table class="table table-hover table-striped table-sm">
    <thead>
        <tr style="background-color: gray;" align="center">
            <th colspan="5">Faktur Pembelian</th>
        </tr>
        <tr style="background-color: gray;" align="center">
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah Pembelian</th>
            <th>Sudah Datang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nobeli = 1;
        foreach ($tampilpembelian->getResultArray() as $rowPembelian) :
        ?>
        <tr>
            <td><?= $nobeli++ ?></td>
            <td><?= $rowPembelian['brgnama'] ?></td>
            <td align="center"><?= $rowPembelian['detjml'] ?></td>
            <td align="center"><?= $rowPembelian['ttbjml'] ?></td>
            <td align="center">
                <?php
                    if ($rowPembelian['ttbjml'] < $rowPembelian['detjml']) {
                        echo "-";
                    } else if ($rowPembelian['ttbjml'] > $rowPembelian['detjml']) {
                        echo "Datang Lebih Banyak";
                    } else {
                        echo "Selesai";
                    }
                    ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>