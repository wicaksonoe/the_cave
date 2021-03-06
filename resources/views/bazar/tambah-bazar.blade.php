<div class="modal fade" id="tambahBazar" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
                <h3 class="modal-title"></h3>
            </div>

            <div class="modal-body">
                <form id="tambahBazarForm" data-toggle="validator">
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="nama">Nama Bazar</label>
                        </div>
                        <div class="col-10">
                            <input class="form-control" id="nama_bazar" placeholder="Nama Bazar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="alamat"> Alamat Bazar</label>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control" rows="3" id="alamat" placeholder="Alamat Bazar"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tgl"> Tanggal Mulai</label>
                        </div>
                        <div class="col-10">
                            <input type='date' class="form-control" id="tgl_mulai" placeholder="Tanggal Bazar Dimulai">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tgl"> Tanggal Akhir</label>
                        </div>
                        <div class="col-10">
                            <input type='date' class="form-control" id="tgl_akhir" placeholder="Tanggal Bazar Berakhir">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="potongan"> Potongan</label>
                        </div>
                        <div class="col-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">Rp. </span>
                                </div>
                                <input class="form-control col-4 number" id="potongan" placeholder="Potongan Harga">
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="tambahBazar()">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
