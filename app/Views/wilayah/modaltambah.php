<!-- Modal -->
<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <form action="<?= base_url('menukategori/simpan') ?>" class="formsimpan">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Menu Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Menu Kategori</label>
                        <input type="text" name="menukategori" id="menukategori" class="form-control"
                            placeholder="Masukan kategori...">
                        <div class="invalid-feedback errorMenuKategori"></div>
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