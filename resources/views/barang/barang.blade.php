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

                    <table id="tabelBarang" class="table table-bordered table-striped table-responsive">
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
            "url": "{{ url('api/v1/barang') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelBarang').DataTable().clear().destroy();
        $('#tabelBarang').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '10%', data: 'barcode', name: 'barcode'},
                {width: '30%', data: 'namabrg', name: 'namabrg'},
                {width: '10%', data: 'id_jenis', name: 'id_jenis'},
                {width: '10%', data: 'id_tipe', name: 'id_tipe'},
                {width: '10%', data: 'jumlah', name: 'jumlah'},
                {width: '10%', data: 'hpp', name: 'hpp'},
                {width: '10%', data: 'hjual', name: 'hjual'},
                {width: '10%', data: 'tgl', name: 'tgl'},
            ],
            order: [1, 'asc'],
            responsive: true
        });
    }

    function tambahBarang() {
        $('#tambahBarang').submit(function(e) {
        e.preventDefault();
        var settings = {
        "url": "{{ url ('api/v1/barang')}}",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Accept": "application/json",
            "Content-Type": "application/x-www-form-urlencoded",
            "Authorization": "Bearer " + sessionStorage.getItem('access_token')
        },
        data: {
            "barcode": $('#barcode').val(),
            "namabrg": $('#namabrg').val(),
            "id_jenis": $('#id_jenis').val(),
            "id_tipe": $('#id_tipe').val(),
            "id_sup": $('#id_sup').val(),
            "jumlah": $('#jumlah').val(),
            "hpp": $('#hpp').val(),
            "hjual": $('#hjual').val(),
            "grosir": $('#grosir').val(),
            "partai": $('#partai').val(),
            "tgl": $('#tgl').val(),
        }
        };

        $.ajax(settings).done(function( msg ) {
                $('#tambahBarang').modal('hide')
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type : "success"
                });
                document.getElementById("tambahBarangForm").reset();
                get_data();
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
        });
    }
</script>
@stop
