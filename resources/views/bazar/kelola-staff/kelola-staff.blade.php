@extends ('adminlte::page')

@section('title', 'KELOLA STAFF BAZAR')

@section('content_header')
<h1>Kelola Staff Bazar</h1>
@stop

@section('content')

@include('bazar.kelola-staff.tambah-kelola-staff')
{{-- @include('bazar.kelola-staff.edit-kelola-staff') --}}
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2><span class="badge badge-light">{{$bazar->nama_bazar}}</span></h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahKelolaStaff').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
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
            "url": "{{ url('api/v1/bazar/staff').'/'.$id_bazar }}" ,
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
            var settings = {
            "url": "{{ url ('api/v1/bazar/staff').'/'.$id_bazar }}" ,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            data: {
                "id_bazar": $('#id_bazar').val(),
                "username": $('#username').val(),
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
    }

    function deleteKelolaStaff(id_KelolaStaff) {
        var settings = {
            "url": BASE_URL_API + "/bazar/staff/"+ "{{$id_bazar}}" + "/" + id_KelolaStaff,
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
