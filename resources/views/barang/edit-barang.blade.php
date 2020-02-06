<div class="modal fade" id="modal-edit-barang" tabindex="1" role="dialog" aria-labelledby="modelTitleId" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-edit-barang" class="form-horizontal" data-toggle="validator">
                    <div class="form-group">
                        <label for="id">Barcode</label>
                        <input class="form-control" id="edit-barcode" placeholder="Barcode">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input class="form-control" id="edit-namabrg" placeholder="Nama Barang">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="jenis">Jenis Barang</label>
                        <select id="edit-id_jenis" class="form-control">
                            <option selected disabled>Pilih Jenis Barang...</option>
                            @foreach ($jenis as $item)
                                <option value="{{ $item->id }}">{{ ucfirst($item->nama_jenis) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="tipe">Tipe Barang</label>
                        <select id="edit-id_tipe" class="form-control">
                            <option selected disabled>Pilih Tipe Barang...</option>
                            @foreach ($tipe as $item)
                                <option value="{{ $item->id }}">{{ ucfirst($item->nama_tipe) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="supplier">Supplier</label>
                        <select id="edit-id_sup" class="form-control">
                            <option selected disabled>Pilih Supplier Barang...</option>
                            @foreach ($supp as $item)
                                <option value="{{ $item->id }}">{{ ucfirst($item->nama) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control" id="edit-jumlah" placeholder="Jumlah Barang">
                    </div>

                    <div class="form-group">
                        <label for="hpp">Harga Pokok Penjualan</label>
                        <input type="number" class="form-control" id="edit-hpp" placeholder="Harga Pokok Penjualan">
                    </div>

                    <div class="form-group">
                        <label for="hjual">Harga Jual</label>
                        <input type="number" class="form-control" id="edit-hjual" placeholder="Harga Jual">
                    </div>

                    <div class="form-group">
                        <label for="grosir">Harga Grosir</label>
                        <input type="number" class="form-control" id="edit-grosir" placeholder="Harga Grosir">
                    </div>

                    <div class="form-group">
                        <label for="partai">Harga Partai</label>
                        <input type="number" class="form-control" id="edit-partai" placeholder="Harga Partai">
                    </div>

                    <div class="form-group">
                        <label for="tanggal"> Tanggal</label>
                        <input type='date' class="form-control" id="edit-tgl" placeholder="Tanggal Barang Masuk">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning" value="" id="update-button" onclick="updateBarang(this.value)">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
