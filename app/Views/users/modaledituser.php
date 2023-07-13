<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('users/updatedataid') ?>" class="formsimpan">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit User ID</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="useridlama" id="useridlama" value="<?= $userid ?>">

                    <div class="form-group">
                        <label for="">User ID</label>
                        <input type="text" name="userid" id="userid" value="<?= $userid ?>" class="form-control"
                            placeholder="Masukan User ID..." disabled>
                    </div>

                    <div class="form-group">
                        <label for="">User KTP</label>
                        <input type="text" name="userktp" id="userktp" value="<?= $userktp ?>" class="form-control"
                            placeholder="Masukan Nomor KTP..." disabled>
                    </div>

                    <div class="form-group">
                        <label for="">User Nama</label>
                        <input type="text" name="usernama" id="usernama" value="<?= $usernama ?>" class="form-control"
                            placeholder="Masukan User Nama..." disabled>
                    </div>

                    <div class="form-group">
                        <label for="">User ID</label>
                        <input type="text" name="useridbaru" id="useridbaru" class="form-control"
                            placeholder="Masukan User ID Baru...">
                        <div class="invalid-feedback errorUserIDBaru"></div>
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

                    if (err.errUserIDBaru) {
                        $('#useridbaru').addClass('is-invalid');
                        $('.errorUserIDBaru').html(err.errUserIDBaru);
                    } else {
                        $('#useridbaru').removeClass('is-invalid');
                        $('#useridbaru').addClass('is-valid');
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