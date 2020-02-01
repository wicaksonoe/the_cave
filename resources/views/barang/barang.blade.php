@extends('adminlte::page')

@section('title', 'DATA BARANG')

@section('content_header')
<h1>Data Barang</h1>
@stop

@section('content')

@include('barang.tambah-barang')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahBarang').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>

                    <table id="tabel" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

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
    $('#tambahBarang').submit(function(e) {
        e.preventDefault()
    })
    function tambahBarang() {
        $.ajax({
            method: "POST",
            url: "{{ url ('api/v1/barang')}}",
            data: {
                barcode: $('#barcode').val(),
                namabrg: $('#namabrg').val(),
                id_jenis: $('#id_jenis').val(),
                id_tipe: $('#id_tipe').val(),
                id_sup: $('#id_sup').val(),
                jumlah: $('#jumlah').val(),
                hpp: $('#hpp').val(),
                hjual: $('#hjual').val(),
                grosir: $('#grosir').val(),
                partai: $('#partai').val(),
                tgl: $('#tgl').val(),
            }
            })
            .done(function( msg ) {
                $('#tambahBarang').modal('hide')
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