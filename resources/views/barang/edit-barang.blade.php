<div class="modal fade" id="modal-edit-barang" tabindex="1" role="dialog" aria-labelledby="modelTitleId"
    data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-edit-barang">
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tanggal"> Tanggal</label>
                        </div>
                        <div class="col-10">
                            <input type='date' class="form-control" id="edit-tanggal" readonly>
                        </div>
                        <small class="text-danger edit-date"></small>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="id">Barcode</label>
                        </div>
                        <div class="col-10">
                            <input class="form-control" id="edit-barcode" placeholder="Barcode" maxlength="15">
                            <small class="text-danger edit-barcode"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="nama">Nama Barang</label>
                        </div>
                        <div class="col-10">
                            <input class="form-control" id="edit-namabrg" placeholder="Nama Barang">
                            <small class="text-danger edit-namabrg"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="jenis">Jenis Barang</label>
                        </div>
                        <div class="col-10">
                            <select id="edit-id_jenis" class="form-control">
                                <option selected disabled>Pilih Jenis Barang...</option>
                                @foreach ($jenis as $item)
                                    @if (isset($item->deleted_at))
                                    <option value="{{ $item->id }}">-- Jenis barang sudah dihapus --({{ ucfirst($item->nama_jenis) }})</option>
                                    @else
                                    <option value="{{ $item->id }}">{{ ucfirst($item->nama_jenis) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger edit-id_jenis"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="tipe">Tipe Barang</label>
                        </div>
                        <div class="col-10">
                            <select id="edit-id_tipe" class="form-control">
                                <option selected disabled>Pilih Tipe Barang...</option>
                                @foreach ($tipe as $item)
                                    @if (isset($item->deleted_at))
                                    <option value="{{ $item->id }}">-- Tipe barang sudah dihapus -- ({{ ucfirst($item->nama_tipe) }})</option>
                                    @else
                                    <option value="{{ $item->id }}">{{ ucfirst($item->nama_tipe) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger edit-id_tipe"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="supplier">Supplier</label>
                        </div>
                        <div class="col-10">
                            <select id="edit-id_sup" class="form-control">
                                <option selected disabled>Pilih Supplier Barang...</option>
                                @foreach ($supplier as $item)
                                    @if (isset($item->deleted_at))
                                    <option value="{{ $item->id }}">-- Supplier sudah dihapus -- ({{ ucfirst($item->nama) }})</option>
                                    @else
                                    <option value="{{ $item->id }}">{{ ucfirst($item->nama_supplier) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger edit-id_sup"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="jumlah">Jumlah Barang</label>
                        </div>
                        <div class="col-10">
                            <input type="text" class="form-control number" id="edit-jumlah" placeholder="Jumlah Barang">
                            <small class="text-danger edit-jumlah"></small>
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
                                <input type="text" class="form-control number" id="edit-hpp" placeholder="Harga Pokok Penjualan">
                            </div>
                            <small class="text-danger edit-hpp"></small>
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
                                <input type="text" class="form-control number" id="edit-hjual" placeholder="Harga Jual">
                                <small class="text-danger edit-hjual"></small>
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
                                <input type="text" class="form-control number" id="edit-grosir" placeholder="Harga Grosir">
                                <small class="text-danger edit-grosir"></small>
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
                                <input type="text" class="form-control number" id="edit-partai" placeholder="Harga Partai">
                                <small class="text-danger edit-partai"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" value="" id="update-button"
                    onclick="updateBarang(this.value)">Ubah</button>
            </div>
        </div>
    </div>
</div>
