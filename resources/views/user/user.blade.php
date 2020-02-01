@extends('adminlte::page')

@section('title', 'USER')

@section('content_header')
<h1>Data User</h1>
@stop

@section('content')

@include('user.tambah-user')
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
                    <table id="tabel" class="table table-bordered table-striped table-responsive">
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

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
<script>
    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid")
    })
    $('#tambahUser').submit(function(e) {
        e.preventDefault()
    })
    function tambahUser() {
        $.ajax({
            method: "POST",
            url: "{{ url ('api/v1/user')}}",
            data: {
                username: $('#username').val(),
                password: $('#password').val(),
                nama: $('#nama').val(),
                alamat: $('#alamat').val(),
                telp: $('#telp').val(),
                role: $('#role').val(),
            }
            })
            .done(function( msg ) {
                $('#tambahUser').modal('hide')
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type : "success"
                })
            })
            .fail(function( msg ) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type : "error"
                })

                $.each(msg.responseJSON.errors, function(key, value){
                    $("#"+key).addClass("is-invalid")
                })
            });

        }
</script>
@stop
