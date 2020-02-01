<div class="modal fade" id="tambahBazzar" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
                <h3 class="modal-title"></h3>
            </div>

            <div class="modal-body">
                <form method="post" id="tambahBazzar" class="form-horizontal" data-toggle="validator">
                    {{ csrf_field() }} {{ method_field('POST') }}

                <div class="form-group">
                    <label for="nama">Nama Bazzar</label>
                    <input class="form-control" id="nama_bazzar" placeholder="Nama Bazzar">
                </div>
                <div class="form-group">
                    <label for="alamat"> Alamat Bazzar</label>
                    <textarea class="form-control" rows="3" id="alamat" placeholder="Alamat Bazzar"></textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal"> Tanggal</label>
                    <input type = 'date' class="form-control" id="tgl" placeholder="Tanggal Bazzar">
                </div>

                <div class="form-group">
                    <label for="potongan"> Potongan</label>
                    <input class="form-control"  id="potongan" placeholder="Potongan Harga">
                </div>
                <div class="form-group">
                    <label for="status"> Status</label><br>
                    <input type="checkbox" checked class="form-control" data-toggle="toggle"  id="status" placeholder="Status Bazzar">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="tambahBarang()">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
