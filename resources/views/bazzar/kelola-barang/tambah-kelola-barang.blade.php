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
                        <label for="namabrg">Nama Barang</label>
                        <select class="form-control" id="barcode" class="js-example-basic-single" name="namabrg">
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $item)
                            <option value="{{ $item->barcode }}">{{ $item->barcode }}-{{ ucfirst($item->namabrg) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jml" placeholder="Jumlah Barang">
                    </div>

                    <div class="form-group">
                        <label for="tanggal"> Tanggal</label>
                        <input type='date' class="form-control" id="date" placeholder="Tanggal Barang Masuk">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="tambahKelolaBarang()">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
