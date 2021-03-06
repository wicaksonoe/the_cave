@extends('adminlte::page')

@section('title', 'USER')

@section('content_header')
<h1>Data User</h1>
@stop

@section('content')

@include('user.tambah-user')
@include('user.edit-user')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data User</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahUser').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <div class="table-responsive">
                        <table id="tabelUser" class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>

                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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
        $(e.target).removeClass("is-invalid").parent().children('.error-msg').remove()
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
                {width: '20%', data: 'username', name: 'username'},
                {width: '30%', data: 'nama', name: 'nama'},
                {width: '20%', data: 'alamat', name: 'alamat'},
                {width: '10%', data: 'telp', name: 'telp'},
                {width: '10%', data: 'role', name: 'role'},
                {width: '10%', data: 'aksi', name: 'aksi'},
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
                        text: msg.responseJSON.message,
                        type: "error"
                    })

                    $.each(msg.responseJSON.errors, function (key, value) {
                        let errorsMessage = "<small class='form-text text-danger error-msg'>" + value + "</small>"
                        $("#" + key).addClass("is-invalid").parent().append(errorsMessage)
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
            .fail(function (msg) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
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
                    text: msg.responseJSON.message,
                    type: "error"
                })

                $.each(msg.responseJSON.errors, function (key, value) {
                    let errorsMessage = "<small class='form-text text-danger error-msg'>" + value + "</small>"
                    $("#edit-" + key).addClass("is-invalid").parent().append(errorsMessage)
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
                    text: msg.responseJSON.message,
                    type: "error"
                });
            });
    }

</script>
@stop
