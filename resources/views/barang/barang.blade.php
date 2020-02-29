@extends('adminlte::page')

@section('title', 'DATA BARANG')

@section('content_header')
<h1>Data Barang</h1>
@stop

@section('content')

@include('barang.tambah-barang')
@include('barang.edit-barang')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
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

@section('js')
<script>
    const BASE_URL_API = "{{ url('api/v1/') }}"

    function formatNumber(num) {
        return num.toString().replace(',', '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function formatDate() {
        var d = new Date(Date.now()),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    $('.number').on('change', (e) => {
        e.target.value = formatNumber(e.target.value)
    });

    $(document).ready(function () {
        $('#tgl').val(formatDate());
        $('#edit-tgl').val(formatDate());
        get_data();
    });

    $(".form-control").focus(function(e){
        $('small.text-danger.' + e.target.id).html('');
        $(e.target).removeClass("is-invalid")
    })

    function get_data() {
        var settings = {
            "url": "{{ url('api/v1/barang') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelBarang').DataTable().clear().destroy();
        $('#tabelBarang').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '25%', data: 'namabrg', name: 'namabrg'},
                {width: '10%', data: 'jenis_barang', name: 'jenis_barang'},
                {width: '10%', data: 'tipe_barang', name: 'tipe_barang'},
                {width: '10%', data: 'jumlah', name: 'jumlah'},
                {width: '10%', data: 'hpp', name: 'hpp'},
                {width: '10%', data: 'hjual', name: 'hjual'},
                {width: '10%', data: 'tgl', name: 'tgl'},
                {width: '15%', data: 'aksi', name: 'aksi'},
            ],
            order: [0, 'asc'],
            responsive: true
        });
    }

    function tambahBarang() {
        var settings = {
        "url": "{{ url ('api/v1/barang')}}",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Accept": "application/json",
            "Content-Type": "application/x-www-form-urlencoded",
            "Authorization": "Bearer " + sessionStorage.getItem('access_token')
        },
        data: {
            "barcode" : $('#barcode').val(),
            "namabrg" : $('#namabrg').val(),
            "id_jenis": $('#id_jenis').val(),
            "id_tipe" : $('#id_tipe').val(),
            "id_sup"  : $('#id_sup').val(),
            "jumlah"  : $('#jumlah').val().replace(',',''),
            "hpp"     : $('#hpp').val().replace(',',''),
            "hjual"   : $('#hjual').val().replace(',',''),
            "grosir"  : $('#grosir').val().replace(',',''),
            "partai"  : $('#partai').val().replace(',',''),
            "tgl"     : $('#tgl').val(),
        }
        };

        $.ajax(settings).done(function( msg ) {
                $('#tambahBarang').modal('hide')
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type : "success"
                });
                document.getElementById("tambahBarangForm").reset();
                $('#tgl').val(formatDate());
                $('#edit-tgl').val(formatDate());
                get_data();
            })
            .fail(function( msg ) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type : "error"
                })

                $.each(msg.responseJSON.errors, function(key, value){
                    $('small.' + key).html(value);
                    $("#"+key).addClass("is-invalid");
                })
            });

    }

    function editBarang(id_barang) {
        var settings = {
            "url": BASE_URL_API + "/barang/" + id_barang,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                $('#edit-barcode').val(response.data.barcode)
                $('#edit-namabrg').val(response.data.namabrg)
                $('#edit-id_jenis').val(response.data.id_jenis)
                $('#edit-id_tipe').val(response.data.id_tipe)
                $('#edit-id_sup').val(response.data.id_sup)
                $('#edit-jumlah').val(formatNumber(response.data.jumlah))
                $('#edit-hpp').val(formatNumber(response.data.hpp))
                $('#edit-hjual').val(formatNumber(response.data.hjual))
                $('#edit-grosir').val(formatNumber(response.data.grosir))
                $('#edit-partai').val(formatNumber(response.data.partai))
                $('#update-button').val(response.data.barcode)
                $('#modal-edit-barang').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type: "error"
                })
            });
    }

    function updateBarang(barcode) {
        var settings = {
            "url": BASE_URL_API + "/barang/" + barcode,
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "barcode" : $('#edit-barcode').val(),
                "namabrg" : $('#edit-namabrg').val(),
                "id_jenis": $('#edit-id_jenis').val(),
                "id_tipe" : $('#edit-id_tipe').val(),
                "id_sup"  : $('#edit-id_sup').val(),
                "jumlah"  : $('#edit-jumlah').val().replace(',',''),
                "hpp"     : $('#edit-hpp').val().replace(',',''),
                "hjual"   : $('#edit-hjual').val().replace(',',''),
                "grosir"  : $('#edit-grosir').val().replace(',',''),
                "partai"  : $('#edit-partai').val().replace(',',''),
                "tgl"     : $('#edit-tgl').val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
                $('#modal-edit-barang').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-barang").reset();
                $('#tgl').val(formatDate());
                $('#edit-tgl').val(formatDate());
                get_data();
            })
            .fail(function (msg) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type: "error"
                })

                $.each(msg.responseJSON.errors, function (key, value) {
                    $('small.edit-' + key).html(value);
                    $("#edit-" + key).addClass("is-invalid")
                })
            });
    }

    function deleteBarang(id_barang) {
        var settings = {
            "url": BASE_URL_API + "/barang/" + id_barang,
            "method": "DELETE",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (msg) {
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                get_data();
            })
            .fail(function (msg) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type: "error"
                });
            });
    }

</script>
@stop
