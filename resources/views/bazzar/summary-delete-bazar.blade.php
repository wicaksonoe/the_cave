<div class="modal fade" id="summaryDeleteBazar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tutup Bazar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <h5>Barang dalam tabel ini akan kembali ke gudang:</h5>
                <br><br>
                <div class="table-responsive">
                    <table id="tabel_hapus_bazar" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" value="" id="confirmDelete" onclick="deleteBazzar(this.value)">Delete</button>
            </div>
        </div>
    </div>
</div>
