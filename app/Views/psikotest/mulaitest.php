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
</style>

<script src="https://cdn.jsdelivr.net/gh/jquery/jquery@1.11.3/dist/jquery.min.js"></script>

<div class='card'>
    <div class='card-header bg-info'>
        <div class='row'>
            <div class='col'>
                <p id="demo"></p>
            </div>
        </div>
    </div>

    <form action="<?= base_url('psikotest/simpan') ?>" class="formsimpan">
        <?= csrf_field(); ?>
        <div class="body">

            <ul class='list-group list-group-flush'>
                <li class='list-group-item'>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body mt-1">
                                    <div class="table-responsive">

                                        <input type="hidden" name="nomorktp" id="nomorktp" value="<?= session()->userktp ?>">
                                        <input type="hidden" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                                        <?php
                                        $nomor = 1;
                                        foreach ($tampildata as $rowSoal) :
                                        ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?= $nomor++ ?>. <?= $rowSoal['soalper'] ?><br>
                                                    <input type="hidden" name="pertanyaan<?= $rowSoal['soalid'] ?>" id="pertanyaan" value="<?= $rowSoal['soalid'] ?>">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="jawab<?= $rowSoal['soalid'] ?>" value="<?= $rowSoal['soalpila'] ?>" id="jawaban1">
                                                            <label class="form-check-label"><?= $rowSoal['soalpila'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="jawab<?= $rowSoal['soalid'] ?>" value="<?= $rowSoal['soalpilb'] ?>" id="jawaban2">
                                                            <label class="form-check-label"><?= $rowSoal['soalpilb'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="jawab<?= $rowSoal['soalid'] ?>" value="<?= $rowSoal['soalpilc'] ?>" id="jawaban3">
                                                            <label class="form-check-label"><?= $rowSoal['soalpilc'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="jawab<?= $rowSoal['soalid'] ?>" value="<?= $rowSoal['soalpild'] ?>" id="jawaban4">
                                                            <label class="form-check-label"><?= $rowSoal['soalpild'] ?></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="jawab<?= $rowSoal['soalid'] ?>" value="<?= $rowSoal['soalpile'] ?>" id="jawaban5">
                                                            <label class="form-check-label"><?= $rowSoal['soalpile'] ?></label>
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

<script>
    $(document).ready(function() {
        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.sukses +
                                ", Apakah ingin menambah Kategori ?",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            window.location.reload();
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

            return false;
        });

    });




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
        document.getElementById("target").innerHTML = countDownDate;

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            Swal.fire({
                title: 'Waktu telah habis!',
                text: "Lanjut test berikutnya ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "<?= base_url() ?>/psikotest/index";
                }
            })
        }
    }, 1000);
</script>



<?= $this->endSection('isi') ?>