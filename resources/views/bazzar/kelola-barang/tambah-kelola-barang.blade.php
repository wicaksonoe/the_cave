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
                <form id="tambahKelolaBarangForm" class="form-horizontal" data-toggle="validator">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="form-group">
                        <label for="id">Barcode</label>
                        <input class="form-control" id="barcode" placeholder="Barcode">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input class="form-control" id="namabrg" placeholder="Nama Barang">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="jenis">Jenis Barang</label>
                        <select id="id_jenis" class="form-control">
                            <option selected disabled>Pilih Jenis Barang...</option>
                            @foreach ($jenis as $item)
                                <option value="{{ $item->id }}">{{ ucfirst($item->nama_jenis) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="tipe">Tipe Barang</label>
                        <select id="id_tipe" class="form-control">
                            <option selected disabled>Pilih Tipe Barang...</option>
                            @foreach ($tipe as $item)
                                <option value="{{ $item->id }}">{{ ucfirst($item->nama_tipe) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah" placeholder="Jumlah Barang">
                    </div>

                    <div class="form-group">
                        <label for="hpp">Harga Pokok Penjualan</label>
                        <input type="number" class="form-control" id="hpp" placeholder="Harga Pokok Penjualan">
                    </div>

                    <div class="form-group">
                        <label for="hjual">Harga Jual</label>
                        <input type="number" class="form-control" id="hjual" placeholder="Harga Jual">
                    </div>

                    <div class="form-group">
                        <label for="tanggal"> Tanggal</label>
                        <input type='date' class="form-control" id="tgl" placeholder="Tanggal Barang Masuk">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="tambahKelolaBarang()">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
