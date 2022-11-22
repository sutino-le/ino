<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Penerimaan</title>
</head>

<body>
    <table border="0" style="width: 100%;">
        <tr style="text-align: right;">
            <td colspan="4">
                <h2 style="height: 2px;">Penerimaan</h2>
                <hr style="border: 0; border-top: 1px solid #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td>Nomor TTB</td>
            <td>: <?= $nomor ?></td>
            <td>Nomor PO</td>
            <td>: <?= $faktur ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Tanggal</td>
            <td>: <?= date("d-M-Y", strtotime($ttbtanggal)) ?></td>
            <td>Suplier</td>
            <td>: <?= $supnama ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Penerima</td>
            <td>: <?= $penerima ?></td>
            <td>Alamat</td>
            <td>: <?= $supalamat ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <table style="width: 100%; text-align:left; font-size: 10pt;" border="1" cellspacing="0" colspacing="0">
                    <tr align="center">
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                    <?php
                    $no = 1;
                    $totalHargaPmk = 0;
                    foreach ($detailpenerimaan->getResultArray() as $row) :
                    ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><?= $row['brgnama'] ?></td>
                        <?php
                            if ($row['ttbjml'] > 1) {
                                $satuan = $row['satinisial'] . 's';
                            } else {
                                $satuan = $row['satinisial'];
                            }
                            ?>
                        <td align="center"><?= number_format($row['ttbjml'], 0, ",", ".") . ' ' . $satuan  ?></td>
                        <td></td>
                    </tr>
                    <?php
                        $totalHargaPmk += $row['ttbjml'] * $row['brgharga'];
                    endforeach;
                    ?>
                </table>
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
    </table>
</body>

</html>