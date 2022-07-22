<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('barang/updatedata') ?>" class="formsimpan">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="brgkode" id="brgkode" value="<?= $brgkode ?>">

                    <div class="form-group">
                        <label for="">Nama Barang</label>
                        <input type="text" name="brgnama" id="brgnama" value="<?= $brgnama ?>" class="form-control" placeholder="Masukan Barang...">
                        <div class="invalid-feedback errorBrgNama"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="brgkatid" id="brgkatid" class="form-control">
                            <option value="<?= $brgkatid ?>"><?= $brgkatnama ?></option>
                            <option value=""></option>
                            <option value="">Pilih Kategori</option>
                            <option value=""></option>
                            <?php foreach ($kategori as $rowkat) : ?>
                                <option value="<?= $rowkat['katid'] ?>"><?= $rowkat['katnama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback errorBrgKategori"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Sub Kategori</label>
                        <select name="brgsubkatid" id="brgsubkatid" class="form-control">
                            <option value="<?= $brgsubkatid ?>"><?= $brgsubkatnama ?></option>
                            <option value=""></option>
                            <option value="">Pilih Sub Kategori</option>
                            <option value=""></option>
                            <?php foreach ($subkategori as $rowsubkat) : ?>
                                <option value="<?= $rowsubkat['subkatid'] ?>"><?= $rowsubkat['subkatnama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback errorBrgSubKategori"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Satuan</label>
                        <select name="brgsatid" id="brgsatid" class="form-control">
                            <option value="<?= $brgsatid ?>"><?= $brgsatnama ?></option>
                            <option value=""></option>
                            <option value="">Pilih Satuan</option>
                            <option value=""></option>
                            <?php foreach ($satuan as $rowsat) : ?>
                                <option value="<?= $rowsat['satid'] ?>"><?= $rowsat['satnama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback errorBrgSatuan"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="text" name="brgharga" id="brgharga" value="<?= $brgharga ?>" class="form-control" placeholder="Masukan Harga...">
                        <div class="invalid-feedback errorBrgHarga"></div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan" autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>

<script>
    function kosong() {
        $('#satnama').val('');
        $('#brgkatid').val('');
        $('#brgsubkatid').val('');
        $('#brgsatid').val('');
        $('#brgharga').val('');
    }

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

                        if (err.errBrgNama) {
                            $('#brgnama').addClass('is-invalid');
                            $('.errorBrgNama').html(err.errBrgNama);
                        } else {
                            $('#brgnama').removeClass('is-invalid');
                            $('#brgnama').addClass('is-valid');
                        }

                        if (err.errBrgKategori) {
                            $('#brgkatid').addClass('is-invalid');
                            $('.errorBrgKategori').html(err.errBrgKategori);
                        } else {
                            $('#brgkatid').removeClass('is-invalid');
                            $('#brgkatid').addClass('is-valid');
                        }

                        if (err.errBrgSubKategori) {
                            $('#brgsubkatid').addClass('is-invalid');
                            $('.errorBrgSubKategori').html(err.errBrgSubKategori);
                        } else {
                            $('#brgsubkatid').removeClass('is-invalid');
                            $('#brgsubkatid').addClass('is-valid');
                        }

                        if (err.errBrgSatuan) {
                            $('#brgsatid').addClass('is-invalid');
                            $('.errorBrgSatuan').html(err.errBrgSatuan);
                        } else {
                            $('#brgsatid').removeClass('is-invalid');
                            $('#brgsatid').addClass('is-valid');
                        }

                        if (err.errBrgHarga) {
                            $('#brgharga').addClass('is-invalid');
                            $('.errorBrgHarga').html(err.errBrgHarga);
                        } else {
                            $('#brgharga').removeClass('is-invalid');
                            $('#brgharga').addClass('is-valid');
                        }

                    }

                    if (response.sukses) {
                        $('#modalEdit').modal('hide');
                        swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
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

        $('#batal').click(function(e) {
            e.preventDefault();
            window.location.reload();
        });

    });
</script>