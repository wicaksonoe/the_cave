<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-biaya" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit biaya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-biaya">
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="bazar">Nama Bazar</label>
                        </div>
                        <div class="col-10">
                            <select id="edit-id_bazar" class="form-control">
                                <option selected disabled>Pilih Bazar...</option>
                                @foreach ($bazar as $item)
                                    @if (isset($item->deleted_at))
                                    <option value="{{ $item->id }}">-- Bazar sudah dihapus -- ({{ ucfirst($item->nama_bazar) }})</option>
                                    @else
                                    <option value="{{ $item->id }}">{{ ucfirst($item->nama_bazar) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger edit-id_bazar"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" cols="30" id="edit-keterangan" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nominal">nominal</label>
                        <input type="number" class="form-control" cols="30" id="edit-nominal" placeholder="Nominal">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" value="" id="update-button" onclick="updateBiaya(this.value)">Ubah</button>
            </div>
        </div>
    </div>
</div>
