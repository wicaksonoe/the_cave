@extends('adminlte::page')

@section('title', 'SUPPLIER')

@section('content_header')
<h1>Data Supplier</h1>
@stop

@section('content')

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
                    <table id="tabelSupplier" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
                {width: '10%', data: 'id', name: 'id'},
                {width: '40%', data: 'nama', name: 'nama'},
                {width: '40%', data: 'alamat', name: 'alamat'},
                {width: '10%', data: 'telp', name: 'telp'},
            ],
            order: [1, 'asc'],
            responsive: true
        });
    }

    function tambahSupplier() {
        $('#tambahSupplier').submit(function (e) {
            e.preventDefault();
            var settings = {
            "url": "{{ url ('api/v1/supplier')}}",
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
                "potongan": $('#potongan').val()
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
                        text: 'Terjadi Kesalahan',
                        type: "error"
                    })

                    $.each(msg.responseJSON.errors, function (key, value) {
                        $("#" + key).addClass("is-invalid")
                    })
                });
        });
    }

</script>
@stop
