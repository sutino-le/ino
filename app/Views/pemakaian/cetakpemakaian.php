<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pemakaian</title>
</head>

<body>
    <table border="0" style="width: 100%;">
        <tr style="text-align: center;">
            <td colspan="4">
                <h3 style="height: 2px;">Form Pemakaian</h3>
                <hr style="border: 0; border-top: 1px solid #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td>Nomor</td>
            <td colspan="3">: <?= $nomor ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Tanggal</td>
            <td colspan="3">: <?= date("d/m/Y", strtotime($pmktanggal)) ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Nama</td>
            <td colspan="3">: <?= $ktpnama ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <table style="width: 100%; text-align:left; font-size: 10pt;">
                    <tr>
                        <th align="center">No</th>
                        <th>Nama Barang</th>
                        <th align="center">Jumlah</th>
                        <th align="right">Harga</th>
                        <th align="right">Total</th>
                        <th align="center">Jenis</th>
                        <th>Keterangan</th>
                    </tr>
                    <?php
                    $no = 1;
                    $totalHargaPmk = 0;
                    foreach ($detailpemakaian->getResultArray() as $row) :
                    ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><?= $row['brgnama'] ?></td>
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