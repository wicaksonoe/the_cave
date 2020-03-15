@extends('adminlte::page')

@section('title', 'PENJUALAN')

@section('content_header')
<h1>TRANSAKSI PENJUALAN</h1>
@stop

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi Penjualan</h3>
                </div>
                <div class="card-body">
                    <form id="transaksiPenjualan" onsubmit="event.preventDefault()">
                        <div class="form-group">
                            <label for="barcode_scan">Barcode</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="barcode_scan" id="barcode_scan" class="form-control">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-info" id="tambah"
                                    onclick="get_nama_barang( $('#barcode_scan').val() )">Tambah</button>
                                </div>
                            </div>
                        </div>
                        <table id="tabel_transaksi_baru" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 30%">Nama Barang</th>
                                    <th class="text-center" style="width: 10%">Jumlah</th>
                                    <th class="text-center" style="width: 10%">Harga Partai</th>
                                    <th class="text-center" style="width: 25%">Harga</th>
                                    <th class="text-center" style="width: 20%">Total</th>
                                    <th class="text-center" style="width: 5%">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="konten_tambah_barang"></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total bayar</th>
                                    <th colspan="2" id="total_bayar">-</th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
{{-- <script>
    const BASE_URL_API = "{{ url('api/v1/') }}"

    let settings = {
            "url": BASE_URL_API + "/barang/" + barcode ,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                let barcode = response.data.barcode;
                let newRow = '<tr id="' + barcode + '">' +
                                '<td><input type="text" name="barcode[]" class="form-control" value="' + barcode + '" readonly></td>' +
                                '<td>' + response.data.namabrg + '</td>' +
                                '<td><input type="text" name="jml[]" class="form-control number"></td>' +
                                '<td><button class="btn btn-sm btn-danger" onclick="delete_nama_barang(' + barcode + ')"><i class="fas fa-trash-alt"></i></button></td>' +
                            '</tr>';

                if ( $('#' + barcode).length ) {
                    swal.fire({
                        title: 'Error!',
                        text: 'Barang ini sudah anda tambahkan di keranjang',
                        type: "error"
                    })
                } else {
                    $('#konten_tambah_barang').append(newRow);
                }

                $('#barcode_scan').val('');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
</script> --}}
<script>
    const BASE_URL_API = "{{ url('api/v1/') }}";
    let dataBarang = {};

    // const input = document.querySelector('input.jumlah');
    $(document.body).on('input', '.jumlah',  function() {
        let parentTD = $(this).parent();
        let barcode = parentTD.parent().prop('id');
        dataBarang[barcode].jumlah = this.value;

        let total = dataBarang[barcode].jumlah * (dataBarang[barcode].hjual.split(',').join(''))

        $(parentTD[0]).siblings('.total').html( 'Rp. ' + total.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,') );

        $('#total_bayar').html(
            function() {
                let total_bayar = 0;
                $.each(dataBarang, function(key, value) {
                    total_bayar += value.jumlah * value.hjual.split(',').join('');
                });
                return "Rp. " + total_bayar.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,');
            }
        );
    });


    function get_nama_barang(barcode) {
        if (barcode == '') {
            swal.fire({
                title: 'Error!',
                text: 'Mohon isi barcode terlebih dahulu',
                type: "error"
            });

            return false;
        }

        let settings = {
            "url": BASE_URL_API + "/barang/" + barcode ,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                let barcode = response.data.barcode;
                dataBarang[barcode] =  {
                        'jumlah': 0,
                        'hjual': response.data.hjual,
                        'hpartai' : response.data.partai,
                    };

                let newRow = '<tr id="' + barcode + '">' +
                                '<td>' + response.data.namabrg + '</td>' +
                                '<td><input type="text" name="jumlah[]" class="form-control jumlah"></td>' +
                                '<td><input type="checkbox" name="harga_parta[]"></td>' +
                                '<td>Rp. ' + response.data.hjual + '</td>' +
                                '<td class="total">Rp.0</td>' +
                                '<td><button class="btn btn-sm btn-danger" onclick="delete_nama_barang(' + barcode + ')"><i class="fas fa-trash-alt"></i></button></td>' +
                            '</tr>';

                if ( $('#' + barcode).length ) {
                    swal.fire({
                        title: 'Error!',
                        text: 'Barang ini sudah anda tambahkan di keranjang',
                        type: "error"
                    })
                } else {
                    $('#konten_tambah_barang').append(newRow);
                }

                $('#barcode_scan').val('');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
    }
</script>

@stop
