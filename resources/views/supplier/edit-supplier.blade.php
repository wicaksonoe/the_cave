<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-supplier" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-supplier">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input class="form-control" id="edit-nama" placeholder="Nama Supplier">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" cols="30" id="edit-alamat" placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="telp">Telepon</label>
                        <input type="number" class="form-control" cols="30" id="edit-telp" placeholder="Telepon">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" value="" id="update-button" onclick="updateSupplier(this.value)">Ubah</button>
            </div>
        </div>
    </div>
</div>
