<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>




<?php
$servername = "localhost";
$database = "project";
$username = "root";
$password = "";

// Create connection

$koneksi = mysqli_connect($servername, $username, $password, $database);

$IP = "192.168.1.203";
$Key = "0";
if ($IP == "") $IP = "192.168.1.203";
if ($Key == "") $Key = "0";


$Connect = fsockopen($IP, "80", $errno, $errstr, 1);
if ($Connect) {
    $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";



    $newLine = "\r\n";
    fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
    fputs($Connect, "Content-Type: text/xml" . $newLine);
    fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
    fputs($Connect, $soap_request . $newLine);
    $buffer = "";
    while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
    }
} else echo "Koneksi Gagal";


$buffer = Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
$buffer = explode("\r\n", $buffer);
for ($a = 0; $a < count($buffer); $a++) {
    $data = Parse_Data($buffer[$a], "<Row>", "</Row>");

    $pin = Parse_Data($data, "<PIN>", "</PIN>");
    $datetime = Parse_Data($data, "<DateTime>", "</DateTime>");
    $status = Parse_Data($data, "<Status>", "</Status>");



    $cekdulu = "SELECT * FROM finger WHERE pin='$pin' AND waktu='$datetime' ";
    $prosescek = mysqli_query($koneksi, $cekdulu);
    if (mysqli_num_rows($prosescek) > 0) {
    } else { //proses menambahkan data, tambahkan sesuai dengan yang kalian gunakan
        $sql = "INSERT INTO finger (pin, waktu, status) VALUES ('$pin','$datetime','$status')";
        mysqli_query($koneksi, $sql);

        if ($sql) {
            $hapus = mysqli_query($koneksi, "DELETE FROM finger WHERE pin='0' ");
        }
    }
    ini_set('max_execution_time', 10000);
}
?>
<script>
Swal.fire(
    'Berhasil',
    'Finger berhasil disownload...',
    'success'
).then((result) => {
    window.location.href = ('<?= base_url() ?>/finger/download204');
})
</script>
<?php

function Parse_Data($data, $p1, $p2)
{
    $data = " " . $data;
    $hasil = "";
    $awal = strpos($data, $p1);
    if ($awal != "") {
        $akhir = strpos(strstr($data, $p1), $p2);
        if ($akhir != "") {
            $hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
        }
    }
    return $hasil;
}
?>

<?= $this->endSection('isi') ?>