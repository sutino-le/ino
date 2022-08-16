<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<style>
    .list-group-flush {
        height: 600px;
        overflow-y: auto;
    }

    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
    }

    .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font: 14px arial;
    }
</style>


<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>

<?php
if ($dataktp > 0) {
?>
    <script>

    </script>
<?php
}
?>



<div class='card'>
    <div class='card-header bg-info'>
        <div class='row'>
            <div class='col'>
                <p id="demo"></p>
            </div>
        </div>
    </div>

    <form action="<?= base_url('psikotest/simpan') ?>" class="formsimpanbanyak">
        <?= csrf_field(); ?>
        <div class="body">

            <div class="preloader">
                <div class="loading">
                    <img src="<?= base_url() ?>/upload/poi.gif" width="80">
                    <p>Harap Tunggu</p>
                </div>
            </div>

            <ul class='list-group list-group-flush'>
                <li class='list-group-item'>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body mt-1">
                                    <div class="table-responsive">
                                        <?php
                                        $nomor = 1;
                                        foreach ($tampildata as $rowSoal) :
                                        ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?= $nomor++ ?>. Jawablah pertanyaan <u><b><?= strtoupper(strtoupper($rowSoal['soalkat'])) ?></b></u> berikut ini. <br>
                                                    <u>Soal :</u> <?= $rowSoal['soalper'] ?><br>
                                                    <input type="hidden" name="nomorktp[]" id="nomorktp" value="<?= session()->userktp ?>">
                                                    <input type="hidden" name="tanggal[]" id="tanggal" value="<?= date('Y-m-d') ?>">
                                                    <input type="hidden" name="soal[]" value="<?= $rowSoal['soalid'] ?>">
                                                    <input class="form-control" type="hidden" name="kuncijawaban[]" id="kuncijawaban" value="<?= $rowSoal['soaljaw'] ?>">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <label class="form-check-label">A. <?= $rowSoal['soalpila'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">B. <?= $rowSoal['soalpilb'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">C. <?= $rowSoal['soalpilc'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">D. <?= $rowSoal['soalpild'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">E. <?= $rowSoal['soalpile'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-4 col-form-label">Jawaban :</label>
                                                                <div class="col-sm-4">
                                                                    <input class="form-control" type="text" name="jawab[]" id="jawab" maxlength="1" autocapitalize="on" autocomplete="off" onkeyup="this.value = this.value.toUpperCase()">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </li>
            </ul>

        </div>


        <div class='card-footer'>
            <div class='row'>
                <div class='col text-right'>
                    <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTest"><i class="fa fa-save"></i>
                        Selesaikan Test</button>
                </div>
            </div>
        </div>

    </form>
</div>





<script src="https://cdn.jsdelivr.net/gh/jquery/jquery@1.11.3/dist/jquery.min.js"></script>

<script>
    var countDownDate = new Date(new Date().getTime() + (30 * 60 * 1000));
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 60);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = "Waktu : " + minutes + "Menit : " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);


            Swal.fire({
                title: 'Waktu telah habis!',
                text: "Lanjut test berikutnya ?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Lanjutkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.formsimpanbanyak').submit();
                } else {
                    $('.formsimpanbanyak').submit();
                }

            })

        }
    }, 1000);

    $(document).ready(function() {
        $('.formsimpanbanyak').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Selesaikan Test!',
                text: "Apakah Anda yakin ingin menyelesaikan test ?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Lanjutkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                location.href = "<?= base_url() ?>/psikotest/index";
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + '\n' + thrownError);
                        }
                    });
                }
            })
            return false;
        });
    });
</script>



<?= $this->endSection('isi') ?>