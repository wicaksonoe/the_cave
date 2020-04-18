<div class="modal fade" id="returBarang" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Retur Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="returBarangForm" onsubmit="event.preventDefault()">
                    <div class="form-group">
                        <label for="Nama Barang">Nama Barang</label>
                        <input type="text" name="barcode" id="barcode" readonly hidden>
                        <input type="text" name="barcode_retur" id="barcode_retur" readonly hidden>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly>
                        <label for="text">Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah" readonly>
                    </div>


                    <div class="form-group">
                        <label for="barcode_scan">Barcode</label>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" name="barcode_scan" id="barcode_scan" class="form-control"
                                    maxlength="15">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-info"
                                    onclick="get_nama_barang( $('#barcode_scan').val() )">Tambah</button>
                            </div>
                        </div>
                    </div>
                    <table id="tabelReturBarang" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 35%">Barcode</th>
                                <th style="width: 40%">Nama Barang</th>
                                <th style="width: 20%">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="kontenReturBarang"></tbody>
                    </table>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="returBarang()">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
