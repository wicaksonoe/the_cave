<div class="modal fade" id="tambahKelolaStaff" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Staff Keluar Bazar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambahKelolaStaffForm" class="form-horizontal" data-toggle="validator">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="form-group">
                        <label for="namabrg">Nama Staff</label>
                        <select class="form-control" id="username" class="js-example-basic-single" name="nama">
                            <option selected disabled>Pilih Staff</option>
                            @foreach ($nama as $item)
                            <option value="{{ $item->username }}">{{ ucfirst($item->nama) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="tambahKelolaStaff()">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
