@extends('adminlte::page')

@section('title', 'BIAYA')

@section('content_header')
<h1>BIAYA</h1>
@stop

@section('content')

@include('biaya.edit-biaya')
@include('biaya.tambah-biaya')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Biaya</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahBiaya').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <div class="table-responsive">
                        <table id="tabelBiaya" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID Biaya</th>
                                    <th class="text-center">Bazar</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Nominal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
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
            "url": "{{ url('api/v1/biaya') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelBiaya').DataTable().clear().destroy();
        $('#tabelBiaya').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '10%', data: 'id', name: 'id'},
                {width: '20%', data: 'nama_bazar', name: 'nama_bazar'},
                {width: '30%', data: 'keterangan', name: 'keterangan'},
                {width: '20%', data: 'nominal', name: 'nominal'},
                {width: '20%', data: 'aksi', name: 'aksi'},
            ],
            order: [0, 'asc'],
            responsive: true
        });
    }

    function tambahBiaya() {
        let id_bazar = $('#nama_bazar').val();

        if (id_bazar == 0) {
            var settings = {
                "method": "POST",
                "url": "{{ url('api/v1/biaya') }}",
                "timeout": 0,
                "headers": {
                    "Accept": "application/json",
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Authorization": "Bearer " + sessionStorage.getItem('access_token')
                },
                data: {
                    "id": $('#id').val(),
                    "keterangan": $('#keterangan').val(),
                    "nominal": $('#nominal').val(),
                }
            };

            $.ajax(settings).done(function (msg) {
                    $('#tambahBiaya').modal('hide');
                    swal.fire({
                        title: 'Berhasil',
                        text: msg.message,
                        type: "success"
                    });
                    document.getElementById("tambahBiayaForm").reset();
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
        } else {
            var settings = {
                "method": "POST",
                "url": "{{ url('api/v1/biaya/bazar').'/' }}" + id_bazar,
                "timeout": 0,
                "headers": {
                    "Accept": "application/json",
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Authorization": "Bearer " + sessionStorage.getItem('access_token')
                },
                data: {
                    "id": $('#id').val(),
                    "nama_bazar": $('#nama_bazar').val(),
                    "keterangan": $('#keterangan').val(),
                    "nominal": $('#nominal').val(),
                }
            };

            $.ajax(settings).done(function (msg) {
                    $('#tambahBiaya').modal('hide');
                    swal.fire({
                        title: 'Berhasil',
                        text: msg.message,
                        type: "success"
                    });
                    document.getElementById("tambahBiayaForm").reset();
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


    }

    function editBiaya(id_biaya) {
        var settings = {
            "url": BASE_URL_API + "/biaya/" + id_biaya,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                $('#edit-id_biaya').val(response.data.id_biaya)
                $('#edit-id_bazar').val(response.data.id_bazar)
                $('#edit-keterangan').val(response.data.keterangan)
                $('#edit-nominal').val(response.data.nominal)
                $('#update-button').val(response.data.barcode)
                $('#modal-edit-biaya').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type: "error"
                })
            });
    }

    function updateBiaya(barcode) {
        var settings = {
            "url": BASE_URL_API + "/biaya/" + id_biaya,
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "id_biaya": $('#id_biaya-barcode').val(),
                "id_bazar" : $('#edit-id_bazar').val(),
                "keterangan": $('#edit-keterangan').val(),
                "nominal" : $('#edit-nominal').val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
                $('#modal-edit-biaya').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-biaya").reset();
                $('#tanggal').val(formatDate());
                $('#edit-tanggal').val(formatDate());
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


</script>
@stop
