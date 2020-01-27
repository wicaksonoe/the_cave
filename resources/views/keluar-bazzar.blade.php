@extends('adminlte::page')

@section('title', 'BARANG KELUAR BAZZAR')

@section('content_header')
    <h1>Bazzar</h1>
@stop

@section('content')
    <p>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">BARANG KELUAR BAZZAR</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input class="form-control" id="id" placeholder="ID Keluar Bazzar">
                </div>
                <div class="form-group">
                    <label for="id_bazzar">ID Bazzar</label>
                    <input type="number" hidden readonly id="id_bazzar" >
                </div>
                <div class="form-group">
                    <label for="nama_bazzar">Nama Bazzar</label>
                    <input class="form-control" readonly name="nama_bazzar" id="nama_bazzar" placeholder="Nama Bazar">
                </div>

                <div class="form-group">
                    <label for="tanggal"> Tanggal</label>
                    <input type = 'date' class="form-control" id="tgl" placeholder="Tanggal Barang Dikeluarkan">
                </div>

                <div class="form-group">
                    <label for="barcode"> Barcode</label>
                </div>

                <div class="form-group">
                    <label for="jumlah"> Jumlah </label><br>
                    <input type="number" class="form-control" name="jumlah" id="jml" placeholder="Jumlah Barang Keluar">
                </div>

                <button type="button" style="margin-bottom: 10px" class="btn btn-primary" onClick="RegisterBazzar()">
                    Simpan
                </button>
            </div>
            <!-- /.card-body -->
        </div>

    </p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@stop



