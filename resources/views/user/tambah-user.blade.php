<div class="modal fade" id="tambahUser" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
                <h3 class="modal-title"></h3>
            </div>

            <div class="modal-body">
                <form id="tambahUserForm" class="form-horizontal" data-toggle="validator">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="form-group">
                        <label for="id">Username</label>
                        <input class="form-control" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input class="form-control" id="nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" cols="30" id="alamat" placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="telp">Telepon</label>
                        <input type="number" class="form-control" cols="30" id="telp" placeholder="Telepon">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="role">Jabatan</label>
                        <select id="role" class="form-control">
                            <option selected disabled>Pilih Jabatan...</option>
                            <option value="Admin">Admin</option>
                            <option value="Pegawai">Pegawai</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
