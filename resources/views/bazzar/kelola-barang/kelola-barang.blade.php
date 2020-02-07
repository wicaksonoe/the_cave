@extends ('adminlte::page')

@section('title', 'KELOLA BARANG BAZZAR')

@section('content_header')
<h1>Kelola Barang Bazzar</h1>
@stop

@section('content')

@include('bazzar.kelola-barang.tambah-kelola-barang')
@include('bazzar.kelola-barang.edit-kelola-barang')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2><span class="badge badge-light">{{$bazzar->nama_bazar}}</span></h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahKelolaBarang').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <a href="{{ route('bazzar.kelola-staff', $id_bazzar) }}" class="btn btn-info"
                        style="margin-bottom: 10px">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Kelola Staff</a>
                    <table id="tabelKelolaBarang" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Tipe Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Harga Pokok Penjualan</th>
                                <th>Harga Jual <span class="badge badge-danger">{{$bazzar->potongan}}% Off</span></th>
                                <th>Tanggal Barang Keluar</th>
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
            "url": "{{ url('api/v1/bazzar/barang').'/'.$id_bazzar }}" ,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelKelolaBarang').DataTable().clear().destroy();
        $('#tabelKelolaBarang').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [

                {width: '15%', data: 'aksi', name: 'aksi'},
                {width: '20%', data: 'nama_barang', name: 'nama_barang'},
                {width: '10%', data: 'jenis_barang', name: 'jenis_barang'},
                {width: '10%', data: 'tipe_barang', name: 'tipe_barang'},
                {width: '10%', data: 'jumlah', name: 'jumlah'},
                {width: '10%', data: 'hpp', name: 'hpp'},
                {width: '10%', data: 'hjual', name: 'hjual'},
                {width: '15%', data: 'date', name: 'date'},

            ],
            order: [1, 'asc'],
            responsive: true
        });
    }

    function tambahKelolaBarang() {
            var settings = {
            "url": "{{ url ('api/v1/bazzar/barang').'/'.$id_bazzar }}" ,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            data: {
                "id_bazzar": $('#id_bazzar').val(),
                "date": $('#date').val(),
                "barcode": $('#barcode').val(),
                "jml": $('#jml').val(),
            }
            };

            $.ajax(settings).done(function (msg) {
                $('#tambahKelolaBarang').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("tambahKelolaBarangForm").reset();
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

    function editKelolaBarang(id_KelolaBarang) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/barang/"+ "{{$id_bazzar}}" + "/" + id_KelolaBarang,
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
                $('#edit-jml').val(response.data.jml)
                $('#edit-date').val(response.data.date)
                $('#update-button').val(response.data.id)
                $('#modal-edit-KelolaBarang').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                })
            });
    }

    function updateKelolaBarang(id_KelolaBarang) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/barang/"+ "{{$id_bazzar}}" + "/" + id_KelolaBarang,
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "barcode": $('#edit-barcode').val(),
                "jml": $('#edit-jml').val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
                $('#modal-edit-KelolaBarang').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-KelolaBarang").reset();
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

    function deleteKelolaBarang(id_KelolaBarang) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/barang/"+ "{{$id_bazzar}}" + "/" + id_KelolaBarang,
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
