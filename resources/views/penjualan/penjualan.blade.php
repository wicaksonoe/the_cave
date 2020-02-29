@extends('adminlte::page')

@section('title', 'PENJUALAN')

@section('content_header')
<h1>Transaksi Penjualan</h1>
@stop

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi Penjualan</h3>
                </div>
                <div class="card-body">
                    <form id="tambahKelolaBarangForm">
                        <div class="form-group">
                            <label for="barcode_scan">Barcode</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="barcode_scan" id="barcode_scan" class="form-control">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-info"
                                        onclick="get_nama_barang( $('#barcode_scan').val() )">Tambah</button>
                                </div>
                            </div>
                        </div>
                        <table id="tabel_tambah_barang" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Nama Barang</th>
                                    <th style="width: 15%">Jumlah</th>
                                    <th style="width: 10%">Harga</th>
                                </tr>
                            </thead>
                            <tbody id="konten_tambah_barang"></tbody>
                        </table>



                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

<script>

</script>
@stop

@section('js')
<script>
    const BASE_URL_API = "{{ url('api/v1/') }}"
    $(document).ready(function () {
        get_data();
    });

    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid")
    })

    function get_data() {
        var settings = {
            "url": "{{ url('api/v1/users') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelUser').DataTable().clear().destroy();
        $('#tabelUser').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '10%', data: 'aksi', name: 'aksi'},
                {width: '20%', data: 'username', name: 'username'},
                {width: '30%', data: 'nama', name: 'nama'},
                {width: '20%', data: 'alamat', name: 'alamat'},
                {width: '10%', data: 'telp', name: 'telp'},
                {width: '10%', data: 'role', name: 'role'},
            ],
            order: [1, 'asc'],
            responsive: true
        });
    }

    function tambahUser() {
            var settings = {
            "url": "{{ url ('api/v1/users')}}",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            data: {
                "username": $('#username').val(),
                "password": $('#password').val(),
                "password_confirmation": $('#password_confirmation').val(),
                "nama": $('#nama').val(),
                "alamat": $('#alamat').val(),
                "telp": $('#telp').val(),
                "role": $('#role').val()
            }
            };

            $.ajax(settings).done(function (msg) {
                $('#tambahUser').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("tambahUserForm").reset();
                get_data();
            })
                .fail(function (msg) {
                    swal.fire({
                        title: 'Error!',
                        text: 'Terjadi Kesalahan',
                        type: "error"
                    })

                    $.each(msg.responseJSON.errors, function (key, value) {
                        $("#" + key).addClass("is-invalid")
                    })
                });

    }
    function editUser(id_user) {
        var settings = {
            "url": BASE_URL_API + "/users/" + id_user,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                $('#edit-username').val(response.data.username)
                $('#edit-nama').val(response.data.nama)
                $('#edit-alamat').html(response.data.alamat)
                $('#edit-telp').val(response.data.telp)
                $('#edit-role').val(response.data.role)
                $('#update-button').val(response.data.username)
                $('#modal-edit-user').modal('show');

            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                })
            });
    }

    function updateUser(id_user) {
        var settings = {
            "url": BASE_URL_API + "/users/" + id_user,
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "username": $('#edit-username').val(),
                "password": $('#edit-password').val(),
                "password_confirmation": $('#edit-password_confirmation').val(),
                "nama": $('#edit-nama').val(),
                "alamat": $('#edit-alamat').val(),
                "telp": $('#edit-telp').val(),
                "role": $('#edit-role').val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
                $('#modal-edit-user').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-user").reset();
                get_data();
            })
            .fail(function (msg) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                })

                $.each(msg.responseJSON.errors, function (key, value) {
                    $("#edit-" + key).addClass("is-invalid")
                })
            });
    }

    function deleteUser(id_user) {
        var settings = {
            "url": BASE_URL_API + "/users/" + id_user,
            "method": "DELETE",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (msg) {
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                get_data();
            })
            .fail(function (msg) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                });
            });
    }

</script>
@stop
