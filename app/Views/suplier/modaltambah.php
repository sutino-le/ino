<!-- Modal -->
<div class="modal fade" id="modaltambahsuplier" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Input Suplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?= form_open(base_url('suplier/simpan'), ['class' => 'formsimpan']) ?>

                <div class="form-group">
                    <label for="">Nama Suplier</label>
                    <input type="text" name="supnama" id="supnama" class="form-control" placeholder="Masukan Nama Suplier">
                    <div class="invalid-feedback errorSupNama"></div>
                </div>

                <div class="form-group">
                    <label for="">No. Telp/Hp</label>
                    <input type="text" name="suptelp" id="suptelp" class="form-control" placeholder="Masukan No. Telp">
                    <div class="invalid-feedback errorSupTelp"></div>
                </div>

                <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" name="supalamat" id="supalamat" class="form-control" placeholder="Masukan Alamat">
                    <div class="invalid-feedback errorSupAlamat"></div>
                </div>

                <div class="form-group">
                    <label for="">NPWP</label>
                    <input type="text" name="supnpwp" id="supnpwp" class="form-control" placeholder="Masukan NPWP">
                    <div class="invalid-feedback errorSupNpwp"></div>
                </div>

                <div class="form-group">
                    <label for="">Rekening</label>
                    <input type="text" name="suprekening" id="suprekening" class="form-control" placeholder="Masukan Rekening">
                    <div class="invalid-feedback errorSupRekening"></div>
                </div>

                <div class="form-group">
                    <label for=""></label>
                    <button type="submit" class="btn btn-block btn-success" id="tombolsimpan">
                        Simpan
                    </button>
                </div>

                <?= form_close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
                beforeSend: function() {
                    $('#tombolsimpan').prop('disabled', true);
                    $('#tombolsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#tombolsimpan').prop('disabled', false);
                    $('#tombolsimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errSupNama) {
                            $('#supnama').addClass('is-invalid');
                            $('.errorSupNama').html(err.errSupNama);
                        } else {
                            $('#supnama').removeClass('is-invalid');
                            $('#supnama').addClass('is-valid');
                        }

                        if (err.errSupTelp) {
                            $('#suptelp').addClass('is-invalid');
                            $('.errorSupTelp').html(err.errSupTelp);
                        } else {
                            $('#suptelp').removeClass('is-invalid');
                            $('#suptelp').addClass('is-valid');
                        }

                        if (err.errSupAlamat) {
                            $('#supalamat').addClass('is-invalid');
                            $('.errorSupAlamat').html(err.errSupAlamat);
                        } else {
                            $('#supalamat').removeClass('is-invalid');
                            $('#supalamat').addClass('is-valid');
                        }

                        if (err.errSupNpwp) {
                            $('#supnpwp').addClass('is-invalid');
                            $('.errorSupNpwp').html(err.errSupNpwp);
                        } else {
                            $('#supnpwp').removeClass('is-invalid');
                            $('#supnpwp').addClass('is-valid');
                        }

                        if (err.errSupRekening) {
                            $('#suprekening').addClass('is-invalid');
                            $('.errorSupRekening').html(err.errSupRekening);
                        } else {
                            $('#suprekening').removeClass('is-invalid');
                            $('#suprekening').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.sukses,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Ambil !'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#namasuplier').val(response.namasuplier);
                                $('#idsuplier').val(response.idsuplier);
                                $('#modaltambahsuplier').modal('hide');
                            } else {
                                $('#modaltambahsuplier').modal('hide');
                            }
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