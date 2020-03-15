<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-biaya" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit biaya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-biaya">
                    <div class="form-group">
                        <label for="nama_biaya">Nama</label>
                        <input class="form-control" id="edit-nama_biaya" placeholder="Nama Biaya">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" cols="30" id="edit-alamat" placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">Telepon</label>
                        <input type="number" class="form-control" cols="30" id="edit-no_telp" placeholder="Telepon">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" value="" id="update-button" onclick="updateBiaya(this.value)">Ubah</button>
            </div>
        </div>
    </div>
</div>
