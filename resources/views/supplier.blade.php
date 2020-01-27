@extends('adminlte::page')

@section('title', 'SUPPLIER')

@section('content_header')
    <h1>Data Supplier</h1>
@stop

@section('content')
    <p>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Supplier</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="?page=tambah-penyakit&level=admin"><button type="button" style="margin-bottom: 10px" class="btn btn-primary">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                </button></a>
                <table id="tabel" class="table table-bordered table-striped">
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
        <script>

        </script>

    </p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
