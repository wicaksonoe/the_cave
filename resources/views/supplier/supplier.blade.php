@extends('adminlte::page')

@section('title', 'SUPPLIER')

@section('content_header')
<h1>Data Supplier</h1>
@stop

@section('content')

@include('supplier.edit-supplier')
@include('supplier.tambah-supplier')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Supplier</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahSupplier').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <div class="table-responsive">
                        <table id="tabelSupplier" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
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
            "url": "{{ url('api/v1/supplier') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelSupplier').DataTable().clear().destroy();
        $('#tabelSupplier').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '40%', data: 'nama', name: 'nama'},
                {width: '30%', data: 'alamat', name: 'alamat'},
                {width: '10%', data: 'telp', name: 'telp'},
                {width: '20%', data: 'aksi', name: 'aksi'},
            ],
            order: [0, 'asc'],
            responsive: true
        });
    }

    function tambahSupplier() {
            var settings = {
            "url": "{{ url ('api/v1/supplier/') }}",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            data: {
                "nama": $('#nama').val(),
                "alamat": $('#alamat').val(),
                "telp": $('#telp').val(),
            }
            };

            $.ajax(settings).done(function (msg) {
                    $('#tambahSupplier').modal('hide');
                    swal.fire({
                        title: 'Berhasil',
                        text: msg.message,
                        type: "success"
                    });
                    document.getElementById("tambahSupplierForm").reset();
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

    function editSupplier(id_supplier) {
        var settings = {
            "url": BASE_URL_API + "/supplier/" + id_supplier,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                $('#edit-nama').val(response.data.nama)
                $('#edit-alamat').html(response.data.alamat)
                $('#edit-telp').val(response.data.telp)
                $('#update-button').val(response.data.id)
                $('#modal-edit-supplier').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
    }

    function updateSupplier(id_supplier) {
        var settings = {
            "url": BASE_URL_API + "/supplier/" + id_supplier,
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "nama": $('#edit-nama').val(),
                "alamat": $('#edit-alamat').val(),
                "telp": $('#edit-telp').val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
                $('#modal-edit-supplier').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-supplier").reset();
                get_data();
            })
            .fail(function (msg) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type: "error"
                })

                $.each(msg.responseJSON.errors, function (key, value) {
                    $("#edit-" + key).addClass("is-invalid")
                })
            });
    }

    function deleteSupplier(id_supplier) {
        var settings = {
            "url": BASE_URL_API + "/supplier/" + id_supplier,
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