@extends('adminlte::page')

@section('title', 'PENJUALAN')

@section('content_header')
<h1>Transaksi Penjualan</h1>
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
                    <form id="tambahKelolaBarangForm">
                        <div class="form-group">
                            <label for="barcode_scan">Barcode</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="barcode_scan" id="barcode_scan" class="form-control">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-info"
                                        onclick="get_nama_barang( $('#barcode_scan').val() )">Tambah</button>
                                </div>
                            </div>
                        </div>
                        <table id="tabel_tambah_barang" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10%">Jumlah</th>
                                    <th class="text-center" style="width: 40%">Nama Barang</th>
                                    <th class="text-center" style="width: 25%">Harga</th>
                                    <th class="text-center" style="width: 25%">Total</th>
                                </tr>
                            </thead>
                            <tbody id="konten_tambah_barang"></tbody>
                        </table>



                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

<script>

</script>
@stop

@section('js')
<script>
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
</script>
@stop
