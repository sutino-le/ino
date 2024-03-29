<hr style="height:2px;border-width:0;color:white;background-color:white">

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background-color: coral;
}
</style>


<table style="width: 100%; text-align:left; font-size: 10pt;">
    <tr>
        <th align="center">No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th align="center">Tanggal</th>
        <th align="center">Jumlah</th>
        <th align="right">Harga</th>
        <th align="right">Total</th>
        <th align="center">Jenis</th>
        <th>Keterangan</th>
        <th>Dikembalikan</th>
        <th>Status</th>
    </tr>
    <?php
    $no = 1;
    $totalHargaPmk = 0;
    foreach ($tampildata->getResultArray() as $row) :
    ?>
    <tr>
        <td align="center"><?= $no++ ?></td>
        <td><?= $row['brgnama'] ?></td>
        <td><?= $row['subkatnama'] ?></td>
        <td align="center"><?= date('d-M-Y', strtotime($row['pmktanggal'])) ?></td>
        <?php
            if ($row['pmkjumlah'] > 1) {
                $satuan = $row['satinisial'] . 's';
            } else {
                $satuan = $row['satinisial'];
            }
            ?>
        <td align="center"><?= number_format($row['pmkjumlah'], 0, ",", ".") . ' ' . $satuan  ?></td>
        <td align="right"><?= number_format($row['brgharga'], 0, ",", ".")  ?></td>
        <td align="right"><?= number_format($row['pmkjumlah'] * $row['brgharga'], 0, ",", ".") ?></td>
        <td align="center"><?= $row['pmkjenis'] ?></td>
        <td><?= $row['pmkketerangan'] ?></td>
        <td><?= $row['detpgmjumlah'] ?></td>
        <td><?= $row['detpgmjenis'] ?></td>
    </tr>
    <?php
        $totalHargaPmk += $row['pmkjumlah'] * $row['brgharga'];
    endforeach;
    ?>
    <tr>
        <td colspan="7">
            <hr style="border: 0; border-top: 1px dashed #000;">
        </td>
    </tr>
    <tr>
        <td align="right" colspan="4">Total Keseluruhan :</td>
        <td align="right"><?= number_format($totalHargaPmk, 0, ",", ".") ?></td>
        <td></td>
        <td></td>
    </tr>
</table>