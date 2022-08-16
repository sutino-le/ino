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

        </div>
        <div class="card-body mt-1">
            <div class="table-responsive">

                <table class="table table-hover">
                    <tr align="center">
                        <td>No.</td>
                        <td>Pertanyaan</td>
                        <td>Jawaban</td>
                        <td>Status</td>
                        <td>Kunci Jawaban</td>
                    </tr>
                    <?php
                    $nomor = 1;
                    foreach ($tampilhasiltest->getResultArray() as $rowHasil) :
                    ?>
                        <tr align="center">
                            <td><?= $nomor++ ?></td>
                            <td><?= $rowHasil['soalper'] ?></td>
                            <td><?= $rowHasil['testjawab'] ?></td>
                            <td><?= $rowHasil['teststatus'] ?></td>
                            <td><?= substr($rowHasil['soalket'], 0, 50) ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>


            </div>
        </div>
    </div>
</div>

<?= $this->endSection('isi') ?>