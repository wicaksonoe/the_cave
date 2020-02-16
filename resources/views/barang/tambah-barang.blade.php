<div class="modal fade" id="tambahBarang" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
                <h3 class="modal-title"></h3>
            </div>

            <div class="modal-body">
                <form id="tambahBarangForm">
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tanggal"> Tanggal</label>
                        </div>
                        <div class="col-10">
                            <input type='date' class="form-control" id="tgl" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="id">Barcode</label>
                        </div>
                        <div class="col-10">
                            <input class="form-control" id="barcode" placeholder="Barcode">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="nama">Nama Barang</label>
                        </div>
                        <div class="col-10">
                            <input class="form-control" id="namabrg" placeholder="Nama Barang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="jenis">Jenis Barang</label>
                        </div>
                        <div class="col-10">
                            <select id="id_jenis" class="form-control">
                                <option selected disabled>Pilih Jenis Barang...</option>
                                @foreach ($jenis as $item)
                                    @if (!isset($item->deleted_at))
                                    <option value="{{ $item->id }}">{{ ucfirst($item->nama_jenis) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tipe">Tipe Barang</label>
                        </div>
                        <div class="col-10">
                            <select id="id_tipe" class="form-control">
                                <option selected disabled>Pilih Tipe Barang...</option>
                                @foreach ($tipe as $item)
                                    @if (!isset($item->deleted_at))
                                    <option value="{{ $item->id }}">{{ ucfirst($item->nama_tipe) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="supplier">Supplier</label>
                        </div>
                        <div class="col-10">
                            <select id="id_sup" class="form-control">
                                <option selected disabled>Pilih Supplier Barang...</option>
                                @foreach ($supp as $item)
                                    @if (!isset($item->deleted_at))
                                    <option value="{{ $item->id }}">{{ ucfirst($item->nama) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="jumlah">Jumlah Barang</label>
                        </div>
                        <div class="col-10">
                            <input type="text" class="form-control number" id="jumlah" placeholder="Jumlah Barang">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="hpp">Harga Pokok Penjualan</label>
                        </div>
                        <div class="col-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">Rp. </span>
                                </div>
                                <input type="text" class="form-control number" id="hpp" placeholder="Harga Pokok Penjualan">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="hjual">Harga Jual</label>
                        </div>
                        <div class="col-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">Rp. </span>
                                </div>
                                <input type="text" class="form-control number" id="hjual" placeholder="Harga Jual">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="grosir">Harga Grosir</label>
                        </div>
                        <div class="col-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">Rp. </span>
                                </div>
                                <input type="text" class="form-control number" id="grosir" placeholder="Harga Grosir">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="partai">Harga Partai</label>
                        </div>
                        <div class="col-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">Rp. </span>
                                </div>
                                <input type="text" class="form-control number" id="partai" placeholder="Harga Partai">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="tambahBarang()">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>