@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Example single danger button -->
                    <div class="form-group row">
                        <div class="col-3">
                            <select id="bulan" class="form-control">
                                <option selected disabled>Bulan</option>
                                <option>Januari</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="tahun" class="form-control">
                                <option selected disabled>Tahun</option>
                                <option>2020</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="penjualan" class="form-control">
                                <option selected disabled>Jenis Penjualan</option>
                                <option>Semua</option>
                                <option>Bazar</option>
                                <option>Global</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-outline-primary" style="">Cari</button>
                    </div>
                    <div class="table-responsive">
                        <table id="barangTerlaris" class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@stop
