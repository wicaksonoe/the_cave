@extends('adminlte::page')

@section('title', 'DETIL TRANSAKSI PENJUALAN')

@section('content_header')
<h1>Detil Transaksi Penjualan</h1>
@stop

@section('content')

@include('penjualan.retur_barang')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3><span class="badge badge-light" id="kode_trx"></span></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabelDetilTransaksi" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Barcode</th>
                                    <th class="text-center align-middle">Nama Barang</th>
                                    <th class="text-center align-middle">Jumlah</th>
                                    <th class="text-center align-middle">Harga</th>
                                    <th class="text-center align-middle">Total</th>
                                    <th class="text-center align-middle">Aksi</th>
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
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3><span class="badge badge-light">Retur Barang</span></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabelRetur" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Barang Yang Diretur</th>
                                    <th class="text-center align-middle">Nama Barang Pengganti</th>
                                    <th class="text-center align-middle">Jumlah</th>
                                    <th class="text-center align-middle">Harga Barang Pengganti</th>
                                    <th class="text-center align-middle">Total</th>
                                    <th class="text-center align-middle">Aksi</th>
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
    let objBarang = {};

    $(document).ready(function () {
        get_data();
    });

    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid").parent().children('.error-msg').remove()
    })

    function show_retur(barcode) {
        let dataBarang = objBarang[barcode];

        $('#barcode').val(dataBarang.barcode);
        $('#nama_barang').val(dataBarang.nama_barang);
        $('#jumlah').val(dataBarang.jumlah);

        $('#returBarang').modal('show');
    }

    function get_data() {
        var settings = {
            "url": BASE_URL_API + "/penjualan/" + "{{ $kode_trx }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
       $.ajax(settings)
        .done(function (response){
            console.log(response)
            $('#kode_trx').html('Kode ' + response.data.kode_trx);

            $.each(response.data.barang.real, function (key, value) {
                let harga;
                let total;
                if (value.harga_partai == 1) {
                    harga = value.partai
                } else if (value.harga_partai == 0 && value.jumlah >= 12) {
                    harga = value.grosir
                } else {
                    harga = value.hjual
                }
                total = harga*value.jumlah

                objBarang[value.barcode] = {
                    'nama_barang': value.nama_barang,
                    'barcode': value.barcode,
                    'jumlah': value.jumlah
                }

                let newRow = "<tr>" +
                    "<td>" + value.barcode + "</td>" +
                    "<td>" + value.nama_barang + "</td>" +
                    "<td>" + value.jumlah + "</td>" +
                    "<td>" + "Rp. " + harga + "</td>" +
                    "<td>" + "Rp. " + total + "</td>" +
                    "<td><button onclick='show_retur(\"" + value.barcode + "\")' type='button' class='btn btn-primary'>Retur</button></td>" +
                    "</tr>";

                $('#tabelDetilTransaksi').children('tbody').append(newRow);
            });
        })
    }

    function returBarang() {
            var settings = {
                "url": BASE_URL_API + "/penjualan/" + "{{ $kode_trx }}",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Accept": "application/json",
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Authorization": "Bearer " + sessionStorage.getItem('access_token')
                },
                "data": $('#returBarangForm').serialize()
            };

            $.ajax(settings).done(function (msg) {
                $('#returBarang').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("returBarangForm").reset();
                get_data();
            })
                .fail(function (msg) {
                    console.log(msg)
                    swal.fire({
                        title: 'Error!',
                        text: msg.responseJSON.message,
                        type: "error"
                    })

                    $.each(msg.responseJSON.errors, function (key, value) {
                        $("#" + key).addClass("is-invalid")
                    })
                });

    }
</script>
@stop
