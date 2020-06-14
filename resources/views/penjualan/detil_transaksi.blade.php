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
                            <tbody id="bodyTabelDetilTransaksi">
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
                                    <th class="text-center align-middle">Jumlah</th>
                                    <th class="text-center align-middle">Harga</th>
                                    <th class="text-center align-middle">Total</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTabelRetur">
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
    let jumlahBarangRetur = 0;
    let objBarang = {};

    $(document).ready(function () {
        get_data();
    });

    $(".form-control").focus(function (e) {
        $(e.target).removeClass("is-invalid").parent().children('.error-msg').remove()
    })

    $("#returBarang").on('hide.bs.modal', function (event) {
        $('#barcode').val("");
        $('#barcode_retur').val("");
        $('#jumlah').val("");
        $('#nama_barang').val("");
        $('#barcode_scan').val("");

        $("#kontenReturBarang").children().remove();
    });

    function show_retur(barcode) {
        let dataBarang = objBarang[barcode];

        $('#barcode').val(dataBarang.barcode);
        $('#jumlah').val(dataBarang.jumlah);
        $('#nama_barang').val(dataBarang.nama_barang);

        $('#returBarang').modal('show');
    }

    function get_nama_barang(barcode) {
        if (jumlahBarangRetur > 0) {
            swal.fire({
                title: 'Error!',
                text: "Barang retur tidak boleh lebih dari satu",
                type: "error"
            })
            return;
        }

        if (barcode == $('#barcode').val()) {
            swal.fire({
                title: 'Error!',
                text: "Barang retur tidak boleh barang yang sama",
                type: "error"
            })
            return;
        }

        var settings = {
            "url": BASE_URL_API + "/barang/" + barcode,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        }

        $.ajax(settings)
            .done(function (response) {
                $('#barcode_retur').val(response.data.barcode);
                let rowBarang = "<tr>" +
                    "<td>" + response.data.barcode + "</td>" +
                    "<td>" + response.data.namabrg + "</td>" +
                    "<td>" + $('#jumlah').val(); + "</td>" +
                    "</tr>";

                $("#kontenReturBarang").append(rowBarang);
                jumlahBarangRetur++;
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            })
    }

    function get_data() {
        $("#bodyTabelDetilTransaksi").children().remove();
        $("#bodyTabelRetur").children().remove();

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
            .done(function (response) {
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
                    total = harga * value.jumlah

                    objBarang[value.barcode] = {
                        'nama_barang': value.nama_barang,
                        'barcode': value.barcode,
                        'jumlah': value.jumlah
                    }

                    let newRow = "<tr>" +
                        "<td>" + value.barcode + "</td>" +
                        "<td>" + value.nama_barang + "</td>" +
                        "<td>" + value.jumlah + "</td>" +
                        "<td>" + "Rp. " + harga.toLocaleString() + "</td>" +
                        "<td>" + "Rp. " + total.toLocaleString() + "</td>" +
                        "<td><button onclick='show_retur(\"" + value.barcode + "\")' type='button' class='btn btn-primary'>Retur</button></td>" +
                        "</tr>";

                    $('#bodyTabelDetilTransaksi').append(newRow);
                });

                $.each(response.data.barang.retur, function (key, value) {
                    let harga;
                    let total;
                    if (value.harga_partai == 1) {
                        harga = value.partai
                    } else if (value.harga_partai == 0 && value.jumlah >= 12) {
                        harga = value.grosir
                    } else {
                        harga = value.hjual
                    }
                    total = harga * value.jumlah

                    let newRow = "<tr>" +
                        "<td>" + value.nama_barang + "</td>" +
                        "<td>" + value.jumlah + "</td>" +
                        "<td>" + "Rp. " + harga.toLocaleString() + "</td>" +
                        "<td>" + "Rp. " + total.toLocaleString() + "</td>" +
                        "</tr>";

                    $('#bodyTabelRetur').append(newRow);
                });
            })
    }

    function returBarang() {
        let tabelBarangRetur = $("#kontenReturBarang").children()

        if (tabelBarangRetur.length == 0) {
            swal.fire({
                title: 'Error!',
                text: "Barang retur harus dipilih",
                type: "error"
            })
            return;
        }

        var settings = {
            "url": BASE_URL_API + "/penjualan/retur/" + "{{ $kode_trx }}",
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                'barcode'          : $("#barcode").val(),
                'barcode_pengganti': $("#barcode_retur").val(),
                'jumlah'           : $("#jumlah").val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
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
