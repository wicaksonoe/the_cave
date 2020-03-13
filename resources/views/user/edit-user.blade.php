<div class="modal fade" id="modal-edit-user" tabindex="1" role="dialog" aria-hidden="true" aria-labelledby="modelTitleId">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-edit-user" class="form-horizontal" data-toggle="validator">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" id="edit-username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="edit-password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="password">Masukkan Ulang Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="edit-password_confirmation"
                            placeholder="Masukkan Ulang Password">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input class="form-control" id="edit-nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" cols="30" id="edit-alamat" placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="telp">Telepon</label>
                        <input type="number" class="form-control" cols="30" id="edit-telp" placeholder="Telepon">
                    </div>
                    <div class="form-group">
                        <label for="role">Jabatan</label>
                        <select id="edit-role" class="form-control">
                            <option selected disabled>Pilih Jabatan...</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning" value="" id="update-button" onclick="updateUser(this.value)">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
