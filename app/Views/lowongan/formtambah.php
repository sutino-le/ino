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
        height: 620px;
        overflow-y: auto;
    }
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<div class='card'>
    <div class='card-header bg-secondary'>
        <div class='row'>
            <div class='col'>
                <?= form_button('', '<i class="fas fa-arrow-alt-circle-left"></i> Kembali', [
                    'class'     => 'btn btn-sm btn-warning',
                    'onclick'   => "location.href=('" . site_url('lowongan/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>


    <?= form_open_multipart(base_url() . '/lowongan/simpan', 'class="formsimpan"'); ?>
    <?= csrf_field(); ?>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Bagian</label>
                            <input type="text" name="lowonganjob" id="lowonganjob" class="form-control" placeholder="Masukan Bagian...">
                            <div class="invalid-feedback errorLowonganJob"></div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <div class="card card-outline card-info">
                                <!-- /.card-header -->
                                <textarea name="summernotedesk" id="summernotedesk" class="form-control"></textarea>
                                <div class="invalid-feedback errorLowonganDesk"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Persyaratan</label>
                            <div class="card card-outline card-info">
                                <!-- /.card-header -->
                                <textarea name="summernotepers" id="summernotepers" class="form-control"></textarea>
                                <div class="invalid-feedback errorLowonganPers"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </li>
        </ul>

    </div>

    <div class='card-footer bg-secondary'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i class="fa fa-save"></i>
                    Selesai</button>
            </div>
        </div>
    </div>

    <?= form_close(); ?>

</div>

<div class="viewmodal" style="display: none;"></div>

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
                    if (response.error) {
                        let err = response.error;

                        if (err.errLowonganJob) {
                            $('#lowonganjob').addClass('is-invalid');
                            $('.errorLowonganJob').html(err.errLowonganJob);
                        } else {
                            $('#lowonganjob').removeClass('is-invalid');
                            $('#lowonganjob').addClass('is-valid');
                        }

                        if (err.errLowonganDesk) {
                            $('#summernotedesk').addClass('is-invalid');
                            $('.errorLowonganDesk').html(err.errLowonganDesk);
                        } else {
                            $('#summernotedesk').removeClass('is-invalid');
                            $('#summernotedesk').addClass('is-valid');
                        }

                        if (err.errLowonganPers) {
                            $('#summernotepers').addClass('is-invalid');
                            $('.errorLowonganPers').html(err.errLowonganPers);
                        } else {
                            $('#summernotepers').removeClass('is-invalid');
                            $('#summernotepers').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire(
                            'Berhasil',
                            response.success,
                            'success'
                        ).then((result) => {
                            window.location.href = ('<?= base_url() ?>/lowongan/index');
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
</script>

<?= $this->endSection('isi') ?>