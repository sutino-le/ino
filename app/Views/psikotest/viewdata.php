<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <?php

            // menambahkan menit di php
            $date = date('d-m-Y h:i:s');

            $totalBenar = 0;
            foreach ($hasilTest->getResultArray() as $rowHasil) :
                if ($rowHasil['teststatus'] == 'Benar') {
                    $jawaban = 1;
                } else {
                    $jawaban = 0;
                }
                $totalBenar += $jawaban;
            endforeach;


            if ($dataktp > 0) {
            ?>

                Anda sudah melakukan Psikotest. dengan Nilai <?= $totalBenar ?>, lihat detail <a href="<?= base_url() ?>/psikotest/lihathasil">disini.</a>
            <?php
            } else if ($statusapply > 0) {
                $waktu = date('d-m-Y h:i:s', strtotime('+5 minutes', strtotime($date)));
            ?>
                <a href="<?= base_url() ?>/psikotest/mulaitest/<?= $waktu  ?>" style="text-decoration: none"><button type="button" class="btn btn-sm btn-primary" id="mulaiPsikotest"><i class="fas fa-caret-square-right"></i> Mulai Test</button></a>

            <?php
            } else {
            ?>

                Anda belum submit Lowongan. Silahkan submit Lowongan yang tersedia, <a href="<?= site_url('lowongan/lowongandaftar') ?>" style="text-decoration: none">disini.</a>
            <?php
            }
            ?>

        </div>
        <div class="card-body mt-1">
            <div class="table-responsive">

                <table class="table table-hover">
                    <tr align="center">
                        <td>No.</td>
                        <td>Jenis-jenis Soal</td>
                        <td>Keterangan</td>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>SINONIM (Padanan Kata)</td>
                        <td>
                            Soal-soal sinonim, kemampuan yang
                            dituntut adalah mampu mencari arti dari
                            sebuah kata pada pilihan jawaban yang
                            tersedia.
                        </td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>ANTONIM (Lawan Kata)</td>
                        <td>
                            Soal tentang antonim ini kebalikan
                            dari sinonim. Dalam soal antonim dituntut
                            untuk mencari lawan kata dari soal yang
                            diberikan.
                        </td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>ANALOGI (Padanan Hubungan)</td>
                        <td>
                            Pada soal analogi, dituntut
                            kemampuan untuk mencari padanan
                            hubungan antara soal dengan jawaban.
                            Langkah untuk menemukan hubungan tersebut adalah
                            dengan mencoba kata yang cocok digunakan
                            pada kedua pasangan kata pada soal
                            maupun pada jawaban.
                        </td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>PENALARAN ANALITIK</td>
                        <td>
                            Tes penalaran analitik atau bisa
                            disebut juga analitis merupakan tes
                            penalaran yang menguji kemampuan sobat
                            dalam menganalisa suatu informasi
                            berbentuk teks paragraf serta memanipulasi
                            informasi atau data tersebut untuk
                            menyimpulkan suatu masalah dan
                            mengambil suatu kesimpulan. Berbeda
                            dengan penalaran logis yang menggunakan
                            prinsip-prinsip silogisme dalam mengambil
                            kesimpulan, penalaran analitik lebih
                            menekankan pengambilan kesimpulan
                            dengan menggunakan penalaran yang
                            bersifat analisa. Di antaranya adalah dengan
                            menuliskan informasi-informasi yang
                            didapat menggunakan gambar, kemudian
                            dari gambar itu dapat diambil beberapa
                            kesimpulan.

                        </td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Barisan</td>
                        <td>
                            merupakan suatu susunan dalam
                            bilangan yang dibentuk menurut suatu pola
                            urutan tertentu. Bilangan-bilangan yang
                            terbentuk seperti itu disebut suku.
                            Perubahan diantara suku-suku berurutan
                            terjadi akibat adanya pengurangan,
                            pembagian, penambahan, atau kelipatan
                            bilangan tertentu. Jika barisan yang suku
                            berurutannya memiliki selisih yang tetap
                            atau sama, maka barisan seperti itu disebut
                            Barisan Aritmetika.

                        </td>
                    </tr>
                </table>


            </div>
        </div>
    </div>
</div>

<?= $this->endSection('isi') ?>