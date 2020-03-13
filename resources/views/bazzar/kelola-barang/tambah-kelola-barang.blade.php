<div class="modal fade" id="tambahKelolaBarang" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Barang Keluar Bazzar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambahKelolaBarangForm">
                    <div class="form-group">
                        <label for="tanggal"> Tanggal</label>
                        <input type="date" class="form-control" name="date" id="date" readonly>
                    </div>

                    <table id="tabel_tambah_barang" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 35%">Barcode</th>
                                <th style="width: 40%">Nama Barang</th>
                                <th style="width: 15%">Jumlah</th>
                                <th style="width: 10%">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="konten_tambah_barang"></tbody>
                    </table>

                    <div class="form-group">
                        <label for="barcode_scan">Barcode</label>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" name="barcode_scan" id="barcode_scan" class="form-control" maxlength="15">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-info" onclick="get_nama_barang( $('#barcode_scan').val() )">Tambah</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="tambahKelolaBarang()">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
