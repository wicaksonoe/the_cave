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
                    <h3 class="card-title">Kelola Barang Bazzar</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahKelolaBarang').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <table id="tabelKelolaBarang" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Barcode</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Tipe Barang</th>
                                <th>Jumlah Barang</th>
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
            "url": "{{ url('api/v1/bazzar/barang/{id_bazzar}') }}",
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

                {width: '10%', data: 'aksi', name: 'aksi'},
                {width: '10%', data: 'barcode', name: 'barcode'},
                {width: '35%', data: 'namabrg', name: 'namabrg'},
                {width: '10%', data: 'id_jenis', name: 'id_jenis'},
                {width: '10%', data: 'id_tipe', name: 'id_tipe'},
                {width: '10%', data: 'jml', name: 'jml'},
                {width: '15%', data: 'date', name: 'date'},

            ],
            order: [1, 'asc'],
            responsive: true
        });
    }

    function tambahKelolaBarang() {
        $('#tambahKelolaBarang').submit(function (e) {
            e.preventDefault();
            var settings = {
            "url": "{{ url ('api/v1/bazzar/barang/{id_bazzar}')}}",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            data: {
                "id_bazzar": $('#id_bazzar').val()
                "date": $('#date').val()
                "barcode": $('#barcode').val()
                "jml": $('#jml').val()
            }
            };

            $.ajax(settings).done(function (msg) {
                $('#tambahKelolaBazzar').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("tambahKelolaBazzarForm").reset();
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

    function editKelolaBazzar(id_KelolaBazzar) {
        var settings = {
            "url": BASE_URL_API + "/KelolaBazzar/" + id_KelolaBazzar,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                $('#edit-nama_bazar').val(response.data.nama_bazar)
                $('#edit-alamat').html(response.data.alamat)
                $('#edit-tgl').val(response.data.tgl)
                $('#edit-potongan').val(response.data.potongan)
                $('#update-button').val(response.data.id)
                $('#modal-edit-KelolaBazzar').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                })
            });
    }

    function updateKelolaBazzar(id_KelolaBazzar) {
        var settings = {
            "url": BASE_URL_API + "/KelolaBazzar/" + id_KelolaBazzar,
            "method": "PUT",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "nama_bazar": $('#edit-nama_bazar').val(),
                "alamat": $('#edit-alamat').val(),
                "tgl": $('#edit-tgl').val(),
                "potongan": $('#edit-potongan').val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
                $('#modal-edit-KelolaBazzar').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-KelolaBazzar").reset();
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

    function deleteKelolaBazzar(id_KelolaBazzar) {
        var settings = {
            "url": BASE_URL_API + "/supplier/" + id_KelolaBazzar,
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
