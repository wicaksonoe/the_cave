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
                    <div class="table-responsive">
                        <table id="tabelRiwayatTransaksi" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
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

@section('js')
<script>

const BASE_URL_API = "{{ url('api/v1/') }}"
$(document).ready(function () {
        get_data();
    });

    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid").parent().children('.error-msg').remove()
    })

    function get_data() {
        var settings = {
            "url": BASE_URL_API + "/penjualan",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelRiwayatTransaksi').DataTable().clear().destroy();
        $('#tabelRiwayatTransaksi').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '20%', data: 'kode_trx', name: 'kode_trx'},
                {width: '20%', data: 'created_at', name: 'created_at'},
                {width: '10%', data: 'aksi', name: 'aksi'},
            ],
            order: [1, 'asc'],
            responsive: true
        });
    }
</script>
@endsection
