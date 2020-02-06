@extends ('adminlte::page')

@section('title', 'KELOLA STAFF BAZZAR')

@section('content_header')
<h1>Kelola Staff Bazzar</h1>
@stop

@section('content')

@include('bazzar.kelola-staff.tambah-kelola-staff')
@include('bazzar.kelola-staff.edit-kelola-staff')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2><span class="badge badge-light">{{$bazzar->nama_bazar}}</span></h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahKelolaStaff').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i>Tambah
                        </button></a>
                    <table id="tabelKelolaStaff" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Staff</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
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
            "url": "{{ url('api/v1/bazzar/staff').'/'.$id_bazzar }}" ,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelKelolaStaff').DataTable().clear().destroy();
        $('#tabelKelolaStaff').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [

                {width: '15%', data: 'aksi', name: 'aksi'},
                {width: '20%', data: 'nama_pegawai', name: 'nama_pegawai'},
                {width: '10%', data: 'telp', name: 'telp'},
                {width: '10%', data: 'alamat', name: 'alamat'},

            ],
            order: [1, 'asc'],
            responsive: true
        });
    }

    function tambahKelolaStaff() {
        $('#tambahKelolaStaff').submit(function (e) {
            e.preventDefault();
            var settings = {
            "url": "{{ url ('api/v1/bazzar/staff').'/'.$id_bazzar }}" ,
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
                $('#tambahKelolaStaff').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("tambahKelolaStaffForm").reset();
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
        });
    }

    function editKelolaStaff(id_KelolaStaff) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/staff/"+ "{{$id_bazzar}}" + "/" + id_KelolaStaff,
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
                $('#modal-edit-KelolaStaff').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: 'Terjadi Kesalahan',
                    type: "error"
                })
            });
    }

    function updateKelolaStaff(id_KelolaStaff) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/staff/"+ "{{$id_bazzar}}" + "/" + id_KelolaStaff,
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
                $('#modal-edit-KelolaStaff').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-KelolaStaff").reset();
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

    function deleteKelolaStaff(id_KelolaStaff) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/staff/"+ "{{$id_bazzar}}" + "/" + id_KelolaStaff,
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
