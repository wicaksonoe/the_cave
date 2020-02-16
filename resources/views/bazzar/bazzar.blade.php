@extends ('adminlte::page')

@section('title', 'BAZZAR')

@section('content_header')
<h1>Data Bazar</h1>
@stop

@section('content')

@include('bazzar.summary-delete-bazar')
@include('bazzar.tambah-bazzar')
@include('bazzar.edit-bazzar')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Bazar</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahBazzar').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <div class="table-responsive">
                        <table id="tabelBazzar" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Bazar</th>
                                    <th>Alamat</th>
                                    <th>Potongan (Rp. )</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Akhir</th>
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

    $('.number').on('change', (e) => {
        e.target.value = formatNumber(e.target.value)
    });

    $(document).ready(function () {
        get_data();
    });

    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid")
    })

    function summaryDelete(id_bazar) {
        var settings = {
            "url": BASE_URL_API + '/bazzar/barang/' + id_bazar,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabel_hapus_bazar').DataTable().clear().destroy();
        $('#tabel_hapus_bazar').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '40%', data: 'barcode', name: 'barcode'},
                {width: '40%', data: 'nama_barang', name: 'nama_barang'},
                {width: '20%', data: 'jumlah', name: 'jumlah'},
            ],
            order: [0, 'asc'],
            responsive: true
        });
        $('#confirmDelete').val(id_bazar);
        $('#summaryDeleteBazar').modal('show');
    }

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
                {width: '20%', data: 'nama_bazar', name: 'nama_bazar'},
                {width: '30%', data: 'alamat', name: 'alamat'},
                {width: '10%', data: 'potongan_harga', name: 'potongan_harga'},
                {width: '10%', data: 'tgl_mulai', name: 'tgl_mulai'},
                {width: '10%', data: 'tgl_akhir', name: 'tgl_akhir'},
                {width: '30%', data: 'aksi', name: 'aksi'},
            ],
            order: [0, 'asc'],
            responsive: true
        });
    }

    function tambahBazzar() {
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
                "nama_bazar": $('#nama_bazar').val(),
                "alamat"    : $('#alamat').val(),
                "tgl_mulai" : $('#tgl_mulai').val(),
                "tgl_akhir" : $('#tgl_akhir').val(),
                "potongan"  : $('#potongan').val().replace(',', '')
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
                        text: msg.responseJSON.message,
                        type: "error"
                    })

                    $.each(msg.responseJSON.errors, function (key, value) {
                        $("#" + key).addClass("is-invalid")
                    })
                });

    }

    function editBazzar(id_bazzar) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/" + id_bazzar,
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
                $('#edit-tgl_mulai').val(response.data.tgl_mulai)
                $('#edit-tgl_akhir').val(response.data.tgl_akhir)
                $('#edit-potongan').val(formatNumber(response.data.potongan))
                $('#update-button').val(response.data.id)
                $('#modal-edit-bazzar').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
    }

    function updateBazzar(id_bazzar) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/" + id_bazzar,
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
                "tgl_mulai": $('#edit-tgl_mulai').val().replace(',', ''),
                "tgl_akhir": $('#edit-tgl_ahir').val().replace(',', ''),
                "potongan": $('#edit-potongan').val(),
            }
        };

        $.ajax(settings)
            .done(function (msg) {
                $('#modal-edit-bazzar').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-bazzar").reset();
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

    function deleteBazzar(id_bazzar) {
        var settings = {
            "url": BASE_URL_API + "/bazzar/" + id_bazzar,
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
                $('#summaryDeleteBazar').modal('hide');
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