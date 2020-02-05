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
                    <a onclick="$('#tambahUser').modal('show')"><button type="button" class="btn btn-primary" style="margin-bottom: 10px">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                    </button></a>
                    <table id="tabelUser" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
    $(document).ready(function () {
        get_data();
    });

    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid")
    })

    function get_data() {
        var settings = {
            "url": "{{ url('api/v1/user') }}",
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
                {width: '10%', data: 'password', name: 'password'},
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
        $('#tambahUser').submit(function (e) {
            e.preventDefault();
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
        });
    }

</script>
@stop
