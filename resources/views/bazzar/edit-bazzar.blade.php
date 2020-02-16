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
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="nama">Nama Bazar</label>
                        </div>
                        <div class="col-10">
                            <input class="form-control" id="edit-nama_bazar" placeholder="Nama Bazar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="alamat"> Alamat Bazar</label>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control" rows="3" id="edit-alamat" placeholder="Alamat Bazar"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tgl"> Tanggal Mulai</label>
                        </div>
                        <div class="col-10">
                            <input type='date' class="form-control" id="edit-tgl_mulai" placeholder="Tanggal Bazar Dimulai">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tgl"> Tanggal Akhir</label>
                        </div>
                        <div class="col-10">
                            <input type='date' class="form-control" id="edit-tgl_akhir" placeholder="Tanggal Bazar Berakhir">
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
                                <input class="form-control col-4 number" id="edit-potongan" placeholder="Potongan Harga">
                            </div>
                        </div>
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
