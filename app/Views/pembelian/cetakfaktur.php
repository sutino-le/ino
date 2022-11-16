<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Faktur Pembelian</title>
</head>

<body onload="window.print();">
    <table border="0" style="width: 100%;">
        <tr style="text-align: center;">
            <td colspan="8">
                <h3 style="height: 2px;">Purchase Order (PO)</h3>
                <h5 style="height: 2px;"></i></h5>
                <hr style="border: 0; border-top: 1px solid #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td>No. Faktur</td>
            <td colspan="3">: <?= $faktur ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align: left;">
            <td>Tgl. Faktur</td>
            <td colspan="3">: <?= date("d/m/Y", strtotime($tanggal)) ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align: left;">
            <td>Suplier</td>
            <td colspan="3">: <?= $namasuplier ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="8">
                <table style="width: 100%; text-align:left; font-size: 10pt;" border="1" cellspacing="0"
                    collspacing="0">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">Nama Barang</th>
                            <th align="center">Jumlah</th>
                            <th align="center">Satuan</th>
                            <th align="center">Harga</th>
                            <th align="center">Total Harga</th>
                        </tr>
                    </thead>

                    <?php
                    $no = 1;
                    $totalhargabayar = 0;
                    $totaljumlah = 0;
                    foreach ($detailbarang->getResultArray() as $row) :
                        $totalhargabayar += $row['detjml'] * $row['dethargamasuk'];
                        $totaljumlah += $row['detjml'];
                    ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><?= $row['brgnama'] ?></td>
                        <?php
                            if ($row['detjml'] > 1) {
                                $satuan = $row['satinisial'] . 's';
                            } else {
                                $satuan = $row['satinisial'];
                            }
                            ?>
                        <td align="center"><?= number_format($row['detjml'], 0, ",", ".") ?> </td>
                        <td align="center"><?= $satuan  ?></td>
                        <td align="right">Rp. <?= $row['dethargamasuk'] ?></td>
                        <td align="right">Rp.
                            <?= number_format(($row['detjml'] * $row['dethargamasuk']), 0, ",", ".") ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="2" align="right"><b>Total Pembelian :</b></td>
                        <td align="center"><b><?= $totaljumlah ?></b></td>
                        <td align="center">Item</td>
                        <td colspan="2" align="right"><b>Rp. <?= $totalhargabayar ?></b></td>
                    </tr>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
    <br>
    <table width="100%" border="1" cellspacing="0">
        <tr>
            <td width="60%">Keterangan</td>
            <td align="center" width="20%">Mengetahui</td>
            <td align="center" width="20%">Dipesan Oleh</td>
        </tr>
        <tr>
            <td><br><br><br><br></td>
            <td></td>
            <td></td>
        </tr>
    </table>




</body>

</html>