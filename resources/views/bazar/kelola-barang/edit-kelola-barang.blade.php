<div class="modal fade" id="modal-edit-KelolaBarang" tabindex="1" role="dialog" aria-hidden="true"
    data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Barang Keluar Bazar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-KelolaBarang" class="form-horizontal" data-toggle="validator">
                    <input type="text" name="edit-barcode" id="edit-barcode" readonly hidden>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control" id="edit-jml" placeholder="Jumlah Barang">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" value="" id="update-button"
                    onclick="updateKelolaBarang(this.value)">Ubah</button>
            </div>
        </div>
    </div>
</div>
