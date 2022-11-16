<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pemakaian</title>
</head>

<body onload="window.print();">
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
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                    </tr>
                    <?php
                    $no = 1;
                    foreach ($detailpemakaian->getResultArray() as $row) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['brgnama'] ?></td>
                        <?php
                            if ($row['pmkjumlah'] > 1) {
                                $satuan = $row['satinisial'] . 's';
                            } else {
                                $satuan = $row['satinisial'];
                            }
                            ?>
                        <td><?= number_format($row['pmkjumlah'], 0, ",", ".") . ' ' . $satuan  ?></td>
                        <td><?= $row['pmkjenis'] ?></td>
                        <td><?= $row['pmkketerangan'] ?></td>
                    </tr>
                    <?php endforeach; ?>
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