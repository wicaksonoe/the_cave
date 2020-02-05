<div class="modal fade" id="modal-edit-bazzar" tabindex="1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
            </div>

            <div class="modal-body">
                <form id="form-edit-bazzar">
                    <div class="form-group">
                        <label for="nama">Nama Bazzar</label>
                        <input class="form-control" id="edit-nama_bazar" placeholder="Nama Bazzar">
                    </div>
                    <div class="form-group">
                        <label for="alamat"> Alamat Bazzar</label>
                        <textarea class="form-control" rows="3" id="edit-alamat" placeholder="Alamat Bazzar"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tgl"> Tanggal</label>
                        <input type='date' class="form-control" id="edit-tgl" placeholder="Tanggal Bazzar">
                    </div>

                    <div class="form-group">
                        <label for="potongan"> Potongan</label>
                        <input class="form-control" id="edit-potongan" placeholder="Potongan Harga">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning" value="" id="update-button" onclick="updateBazzar(this.value)">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
