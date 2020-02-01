@extends('adminlte::page')

@section('title', 'SUPPLIER')

@section('content_header')
<h1>Data Supplier</h1>
@stop

@section('content')

@include('supplier.tambah-supplier')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Supplier</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahSupplier').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <table id="tabel" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
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
    $('#tambahSupplier').submit(function(e) {
        e.preventDefault()
    })
    function tambahSupplier() {
        $.ajax({
            method: "POST",
            url: "{{ url ('api/v1/supplier')}}",
            data: {
                nama: $('#nama').val(),
                alamat: $('#alamat').val(),
                telp: $('#telp').val(),
            }
            })
            .done(function( msg ) {
                alert( "Data Disimpan: " + msg );
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
