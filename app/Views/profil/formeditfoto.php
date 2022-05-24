<!-- Modal -->
<div class="modal fade" id="modalEditFoto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('profil/updatefoto') ?>" method="post" enctype="multipart/form-data">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="userid" id="userid" value="<?= $userid ?>">
                    <input type="hidden" name="ktp_nomor" id="ktp_nomor" value="<?= $ktp_nomor ?>">

                    <div class="form-group">
                        <img src="<?= base_url() ?>/upload/<?= $ktp_foto ?>" class="img-thumbnail" style="width: 50%;" alt="Foto Profil">
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="form-control-file" id="gambar" name="gambar">
                        </div>
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