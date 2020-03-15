<div class="modal fade" id="tambahBiaya" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
                <h3 class="modal-title"></h3>
            </div>

            <div class="modal-body">
                <form method="post" id="tambahBiayaForm" class="form-horizontal" data-toggle="validator">
                    {{ csrf_field() }} {{ method_field('POST') }}

                    <div class="form-group row">
                        <div class="col-2">
                            <label for="nama_bazar">Nama Bazar/Toko</label>
                        </div>
                        <div class="col-10">
                            <select id="nama_bazar" class="form-control">
                                <option selected disabled>Pilih Nama Bazar...</option>
                                <option value="0">Toko</option>
                                @foreach ($bazar as $item)
                                    @if (!isset($item->deleted_at))
                                    <option value="{{ $item->id }}"> {{ $item->id }}-{{ ucfirst($item->nama_bazar) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger id_bazar"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" cols="30" id="keterangan" placeholder="Keterangan">
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" class="form-control" id="nominal" placeholder="Nominal">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="tambahBiaya()">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
