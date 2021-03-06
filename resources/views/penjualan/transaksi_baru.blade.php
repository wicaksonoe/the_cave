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
                        <div class="table-responsive">
                            <table id="tabel_transaksi_baru" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 20%">Barcode</th>
                                        <th class="text-center" style="width: 20%">Nama Barang</th>
                                        <th class="text-center" style="width: 10%">Jumlah</th>
                                        <th class="text-center" style="width: 5%">Harga Partai</th>
                                        <th class="text-center" style="width: 20%">Harga</th>
                                        <th class="text-center" style="width: 20%">Total</th>
                                        <th class="text-center" style="width: 5%">Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="konten_tambah_barang"></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total bayar</th>
                                        <th colspan="2" id="total_bayar">-</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="tambahTransaksi()">Simpan</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
    const BASE_URL_API = "{{ url('api/v1/') }}";
    let rowCounter = 0;
    let dataBarang = {};

    // const input = document.querySelector('input.jumlah');
    $(document.body).on('input', 'input:checkbox',  function() {

        let parentTD = $(this).parent();
        let barcode = parentTD.parent().prop('id');

        if ($(this).prop('checked')) {
            let total = dataBarang[barcode].jumlah * (dataBarang[barcode].partai.split(',').join(''))
            $(parentTD[0]).siblings('.total').html( 'Rp. ' + total.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,') );
            $(parentTD[0]).siblings('.harga').html( 'Rp. ' + dataBarang[barcode].partai);
            dataBarang[barcode].statusharga=1;
        } else {
            dataBarang[barcode].statusharga=0;
            if (dataBarang[barcode].jumlah >= 12) {

                let total = dataBarang[barcode].jumlah * (dataBarang[barcode].grosir.split(',').join(''))
                $(parentTD[0]).siblings('.total').html( 'Rp. ' + total.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,') );
                $(parentTD[0]).siblings('.harga').html( 'Rp. ' + dataBarang[barcode].grosir);
                parentTD.siblings('.partai').children('input:first').prop('checked', false)
                parentTD.siblings('.partai').children('input:first').attr('disabled', true)

                if (dataBarang[barcode].jumlah >= 100) {
                    parentTD.siblings('.partai').children('input:first').removeAttr('disabled')
                }
            } else {
                parentTD.siblings('.partai').children('input:first').prop('checked', false)
                parentTD.siblings('.partai').children('input:first').attr('disabled', true)
                let total = dataBarang[barcode].jumlah * (dataBarang[barcode].hjual.split(',').join(''))
                $(parentTD[0]).siblings('.total').html( 'Rp. ' + total.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,') );
                $(parentTD[0]).siblings('.harga').html( 'Rp. ' + dataBarang[barcode].hjual);
            }
        }

        $('#total_bayar').html(
            function() {
                let total_bayar = 0;
                $.each(dataBarang, function(key, value) {
                    if (value.jumlah >= 100 && value.statusharga == 1) {
                        total_bayar += value.jumlah * value.partai.split(',').join('');
                    } else {
                        if (value.jumlah >= 12) {
                            total_bayar += value.jumlah * value.grosir.split(',').join('');
                        } else {
                        total_bayar += value.jumlah * value.hjual.split(',').join('');
                        }
                    }
                });
                return "Rp. " + total_bayar.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,');
            }
        );

    });

    $(document.body).on('input', '.jumlah',  function () {
        let parentTD = $(this).parent();
        let barcode = parentTD.parent().prop('id');
        dataBarang[barcode].jumlah = this.value;

        let jumlah = Number(this.value);

        if (jumlah >= 12) {

            let total = dataBarang[barcode].jumlah * (dataBarang[barcode].grosir.split(',').join(''))
            $(parentTD[0]).siblings('.total').html( 'Rp. ' + total.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,') );
            $(parentTD[0]).siblings('.harga').html( 'Rp. ' + dataBarang[barcode].grosir);
            parentTD.siblings('.partai').children('input:first').prop('checked', false)
            parentTD.siblings('.partai').children('input:first').attr('disabled', true)

            if (jumlah >= 100) {
                parentTD.siblings('.partai').children('input:first').removeAttr('disabled')
            }
        } else {
            dataBarang[barcode].statusharga=0;
            parentTD.siblings('.partai').children('input:first').prop('checked', false)
            parentTD.siblings('.partai').children('input:first').attr('disabled', true)
            let total = dataBarang[barcode].jumlah * (dataBarang[barcode].hjual.split(',').join(''))
            $(parentTD[0]).siblings('.total').html( 'Rp. ' + total.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,') );
            $(parentTD[0]).siblings('.harga').html( 'Rp. ' + dataBarang[barcode].hjual);
        }


        $('#total_bayar').html(
            function() {
                let total_bayar = 0;
                $.each(dataBarang, function(key, value) {
                    if (value.jumlah >= 100 && value.statusharga == 1) {
                        total_bayar += value.jumlah * value.partai.split(',').join('');
                    } else {
                        if (value.jumlah >= 12) {
                            total_bayar += value.jumlah * value.grosir.split(',').join('');
                        } else {
                        total_bayar += value.jumlah * value.hjual.split(',').join('');
                        }
                    }
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
                        'partai' : response.data.partai,
                        'grosir' : response.data.grosir,
                        'statusharga' : 0,
                    };

                let newRow = '<tr id="' + barcode + '">' +
                                '<td><input type="text" name="barcode[]" class="form-control" value="' + barcode + '" readonly></td>' +
                                '<td>' + response.data.namabrg + '</td>' +
                                '<td><input type="text" id="'+ barcode+'jumlah" name="jumlah[]" class="form-control jumlah"></td>' +
                                `<td class="partai"><input id="row_${rowCounter}" type="checkbox" name="partai[]" class="form-control" value="1" disabled><input id="rowHidden_${rowCounter}" type="hidden" name="partai[]" value="0"></td>` +
                                '<td class="harga">Rp. ' + response.data.hjual + '</td>' +
                                '<td class="total">Rp.0</td>' +
                                '<td><button class="btn btn-sm btn-danger" value="'+ barcode + '" onclick="deleteBarang(this.value)"><i class="fas fa-trash-alt"></i></button></td>' +
                            '</tr>';

                if ( $('#' + barcode).length ) {
                    swal.fire({
                        title: 'Error!',
                        text: 'Barang ini sudah anda tambahkan di keranjang',
                        type: "error"
                    })
                } else {
                    $('#konten_tambah_barang').append(newRow);
                    rowCounter++;
                }

                $('#barcode_scan').val('');

                document.getElementById(barcode + "jumlah").focus();

            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });


    }

    function tambahTransaksi() {
        let barcode = [];
        let jumlah = [];
        let harga_partai = [];

        $.each(dataBarang, function(keyBarcode, barang) {
            barcode.push(keyBarcode);
            jumlah.push(barang['jumlah']);
            harga_partai.push(barang['statusharga']);
            console.log(barang['statusharga']);
            // if (barang['statusharga'] == 1 ) {
            //     harga_partai.push('ya');
            // } else if (barang['statusharga'] == 0 ) {
            //     harga_partai.push('tidak');
            // };

        });
            var settings = {
                "url": BASE_URL_API + "/penjualan/",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Accept": "application/json",
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Authorization": "Bearer " + sessionStorage.getItem('access_token')
                },
                'data' : {
                    'barcode': barcode,
                    'jumlah': jumlah,
                    'harga_partai': harga_partai,
                },
            };

            $.ajax(settings).done(function (msg) {
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                $('#konten_tambah_barang').children().remove();

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

    function deleteBarang(barcode) {
        $('#' + barcode).remove();
        delete dataBarang[barcode];

        $('#total_bayar').html(
            function() {
                let total_bayar = 0;
                $.each(dataBarang, function(key, value) {
                    if (value.jumlah >= 100 && value.statusharga == 1) {
                        total_bayar += value.jumlah * value.partai.split(',').join('');
                    } else {
                        if (value.jumlah >= 12) {
                            total_bayar += value.jumlah * value.grosir.split(',').join('');
                        } else {
                        total_bayar += value.jumlah * value.hjual.split(',').join('');
                        }
                    }
                });
                return "Rp. " + total_bayar.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1,');
            }
        );

    }


</script>

@stop
