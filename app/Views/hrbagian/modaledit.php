<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('hrbagian/updatedata') ?>" class="formsimpan">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Bagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="bagianid" id="bagianid" value="<?= $bagianid ?>">

                    <div class="form-group">
                        <label for="">Nama Bagian</label>
                        <input type="text" name="bagiannama" id="bagiannama" value="<?= $bagiannama ?>"
                            class="form-control" placeholder="Masukan Bagian...">
                        <div class="invalid-feedback errorBagianNama"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Parent</label>
                        <select name="bagianparent" id="bagianparent" class="form-control">
                            <?php foreach ($databagian as $rowbagian) : ?>
                            <option value="<?= $rowbagian['bagianid'] ?>"
                                <?= ($rowbagian['bagianid'] == $bagianparent) ? 'selected' : '' ?>>
                                <?= $rowbagian['bagiannama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback errorBagianParent"></div>
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
    $('#bagiannama').val('');
    $('#bagianparent').val('');
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

                    if (err.errBagianNama) {
                        $('#bagiannama').addClass('is-invalid');
                        $('.errorBagianNama').html(err.errBagianNama);
                    } else {
                        $('#bagiannama').removeClass('is-invalid');
                        $('#bagiannama').addClass('is-valid');
                    }

                    if (err.errBagianParent) {
                        $('#bagianparent').addClass('is-invalid');
                        $('.errorBagianParent').html(err.errBagianParent);
                    } else {
                        $('#bagianparent').removeClass('is-invalid');
                        $('#bagianparent').addClass('is-valid');
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