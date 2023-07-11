<!-- Modal -->
<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('perbaikan/simpan') ?>" class="formsimpan">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Perbaikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">User</label>
                        <input type="hidden" name="pbknuser" id="pbknuser" value="<?= $pbknuser ?>">
                        <input type="text" name="namauser" id="namauser" value="<?= $namauser ?>" class="form-control"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="date" name="pbkntanggal" id="pbkntanggal" value="<?= date("Y-m-d") ?>"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Permasalahan</label>
                        <textarea name="pbknproblem" id="pbknproblem" class="form-control" cols="30"
                            rows="10"></textarea>
                        <div class="invalid-feedback errorPbknProblem"></div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan"
                        autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>


<script>
function kosong() {
    $('#pbknproblem').val('');
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

                    if (err.errPbknProblem) {
                        $('#pbknproblem').addClass('is-invalid');
                        $('.errorPbknProblem').html(err.errPbknProblem);
                    } else {
                        $('#pbknproblem').removeClass('is-invalid');
                        $('#pbknproblem').addClass('is-valid');
                    }
                }

                if (response.sukses) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: response.sukses +
                            ", Apakah ingin menambah Perbaikan ?",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#modalTambah').modal('show');
                            kosong();
                        } else {
                            window.location.reload();
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

    $('#batal').click(function(e) {
        e.preventDefault();
        window.location.reload();
    });

});
</script>