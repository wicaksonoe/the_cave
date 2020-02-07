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

                    <table id="tabelBarang" class="table table-bordered table-striped table-responsive">
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

@section('js')
<script>
    const BASE_URL_API = "{{ url('api/v1/') }}"
    $(document).ready(function () {
        get_data();
    });
    $(".form-control").focus(function(e){
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
                {width: '10%', data: 'aksi', name: 'aksi'},
                {width: '30%', data: 'namabrg', name: 'namabrg'},
                {width: '10%', data: 'jenis_barang', name: 'jenis_barang'},
                {width: '10%', data: 'tipe_barang', name: 'tipe_barang'},
                {width: '10%', data: 'jumlah', name: 'jumlah'},
                {width: '10%', data: 'hpp', name: 'hpp'},
                {width: '10%', data: 'hjual', name: 'hjual'},
                {width: '10%', data: 'tgl', name: 'tgl'},
            ],
            order: [1, 'asc'],
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
            "barcode": $('#barcode').val(),
            "namabrg": $('#namabrg').val(),
            "id_jenis": $('#id_jenis').val(),
            "id_tipe": $('#id_tipe').val(),
            "id_sup": $('#id_sup').val(),
            "jumlah": $('#jumlah').val(),
            "hpp": $('#hpp').val(),
            "hjual": $('#hjual').val(),
            "grosir": $('#grosir').val(),
            "partai": $('#partai').val(),
            "tgl": $('#tgl').val(),
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
                get_data();
            })
            .fail(function( msg ) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type : "error"
                })

                $.each(msg.responseJSON.errors, function(key, value){
                    $("#"+key).addClass("is-invalid")
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
                $('#edit-jumlah').val(response.data.jumlah)
                $('#edit-hpp').val(response.data.hpp)
                $('#edit-hjual').val(response.data.hjual)
                $('#edit-grosir').val(response.data.grosir)
                $('#edit-partai').val(response.data.partai)
                $('#edit-tgl').val(response.data.tgl)
                $('#update-button').val(response.data.id)
                $('#modal-edit-barang').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                })
            });
    }

    function updateBarang(id_barang) {
        var settings = {
            "url": BASE_URL_API + "/barang/" + id_barang,
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "barcode": $('#barcode').val(),
                "namabrg": $('#namabrg').val(),
                "id_jenis": $('#id_jenis').val(),
                "id_tipe": $('#id_tipe').val(),
                "id_sup": $('#id_sup').val(),
                "jumlah": $('#jumlah').val(),
                "hpp": $('#hpp').val(),
                "hjual": $('#hjual').val(),
                "grosir": $('#grosir').val(),
                "partai": $('#partai').val(),
                "tgl": $('#tgl').val(),
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
                get_data();
            })
            .fail(function (msg) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                })

                $.each(msg.responseJSON.errors, function (key, value) {
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
                    text: 'Terjadi Kesalahan',
                    type: "error"
                });
            });
    }

</script>
@stop
