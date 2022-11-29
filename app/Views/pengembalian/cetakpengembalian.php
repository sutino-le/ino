<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pengembalian</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <table border="0" style="width: 100%;">
            <tr style="text-align: center;">
                <td colspan="4">
                    <h3 style="height: 2px;">Form Pengembalian</h3>
                    <br>
                    <hr style="border: 0; border-top: 1px solid #000;">
                </td>
            </tr>
            <tr style="text-align: left;">
                <td>Nomor</td>
                <td colspan="3">: <?= $pgmnomor ?></td>
            </tr>
            <tr style="text-align: left;">
                <td>Tanggal</td>
                <td colspan="3">: <?= date("d/m/Y", strtotime($pgmtanggal)) ?></td>
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
                    <table style="width: 100%; text-align:left; font-size: 10pt;" class="table table-bordered table-sm">
                        <tr align="center">
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                        <?php
                        $no = 1;
                        $totalHargaPgm = 0;
                        foreach ($detailpengembalian->getResultArray() as $row) :
                        ?>
                        <tr>
                            <td align="center"><?= $no++ ?></td>
                            <td><?= $row['brgnama'] ?></td>
                            <?php
                                if ($row['detpgmjumlah'] > 1) {
                                    $satuan = $row['satinisial'] . 's';
                                } else {
                                    $satuan = $row['satinisial'];
                                }
                                ?>
                            <td align="center"><?= number_format($row['detpgmjumlah'], 0, ",", ".") . ' ' . $satuan  ?>
                            </td>
                            <td align="right"><?= number_format($row['brgharga'], 0, ",", ".")  ?></td>
                            <td align="right"><?= number_format($row['detpgmjumlah'] * $row['brgharga'], 0, ",", ".") ?>
                            </td>
                            <td align="center"><?= $row['detpgmjenis'] ?></td>
                            <td><?= $row['detpgmketerangan'] ?></td>
                        </tr>
                        <?php
                            $totalHargaPgm += $row['detpgmjumlah'] * $row['brgharga'];
                        endforeach;
                        ?>
                        <tr>
                            <td colspan="7">
                                <hr style="border: 0; border-top: 1px dashed #000;">
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="4">Total Keseluruhan :</td>
                            <td align="right"><?= number_format($totalHargaPgm, 0, ",", ".") ?></td>
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
    </div>
</body>

</html>