@extends('adminlte::page')

@section('title', 'DATA BARANG')

@section('content_header')
    <h1>Data Barang</h1>
@stop

@section('content')

@include('tambah-barang')
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Barang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <a onclick="$('#tambahBarang').modal('show')"><button type="button" class="btn btn-primary" style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i>Tambah
                        </button></a>

                        <table id="tabel" class="table table-bordered table-striped">
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
    <script> console.log('Hi!'); </script>
    <script>
        function tambahBarang() {
            save_method ="tambah";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Tambah');
        }
    </script>
@stop
