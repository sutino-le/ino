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

                <table style="width: 100%;" id="dataLowongan" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bagian</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($tampildata->getResultArray() as $rowLowongan) :
                        ?>
                            <tr>
                                <td><?= $nomor++ ?></td>
                                <td><?= $rowLowongan['lowonganjob'] ?></td>
                                <td><?= $rowLowongan['lowongandeskripsi'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info
                                    " onclick="apply('<?= $rowLowongan['lowonganid'] ?>')" title="Submit"><i class='fas fa-handshake'></i></button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function apply(lowonganid) {
        Swal.fire({
            title: 'Submit Lowongan?',
            text: "Apakah ingin submit lowongan ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Submit!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>/lowongan/lowonganapply",
                    data: {
                        lowonganid: lowonganid
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire('Berhasil', response.sukes, 'success');
                            location.href = '<?= base_url() ?>/psikotest/index';
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }
</script>


<?= $this->endSection('isi') ?>