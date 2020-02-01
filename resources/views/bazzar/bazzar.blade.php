@extends ('adminlte::page')

@section('title', 'BAZZAR')

@section('content_header')
<h1>Data Bazzar</h1>
@stop

@section('content')

@include('bazzar.tambah-bazzar')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Bazzar</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahBazzar').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <table id="tabelBazzar" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Bazzar</th>
                                <th>Alamat</th>
                                <th>Potongan</th>
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
    $(document).ready(function () {
        get_data();
    });

    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid")
    })

    function get_data() {
        var settings = {
            "url": "{{ url('api/v1/bazzar') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelBazzar').DataTable().clear().destroy();
        $('#tabelBazzar').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '10%', data: 'aksi', name: 'aksi'},
                {width: '30%', data: 'nama_bazar', name: 'nama_bazar'},
                {width: '30%', data: 'alamat', name: 'alamat'},
                {width: '10%', data: 'potongan', name: 'potongan'},
                {width: '20%', data: 'tgl', name: 'tgl'},
            ],
            order: [1, 'asc'],
            responsive: true
        });
    }

    function tambahBazzar() {
        $('#tambahBazzar').submit(function (e) {
            e.preventDefault();
            var settings = {
            "url": "{{ url ('api/v1/bazzar')}}",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            data: {
                "nama_bazar": $('#nama_bazzar').val(),
                "alamat": $('#alamat').val(),
                "tgl": $('#tgl').val(),
                "potongan": $('#potongan').val()
            }
            };

            $.ajax(settings).done(function (msg) {
                $('#tambahBazzar').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("tambahBazzarForm").reset();
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
