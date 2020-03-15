@extends('adminlte::page')

@section('title', 'RIWAYAT TRANSAKSI PENJUALAN')

@section('content_header')
<h1>Riwayat Transaksi Penjualan</h1>
@stop

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">RIWAYAT TRANSAKSI PENJUALAN</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahBarang').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <div class="table-responsive">
                        <table id="tabelBarang" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jenis</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Harga Pokok</th>
                                    <th>Harga Jual</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
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
</div>
@stop
