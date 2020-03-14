@extends ('adminlte::page')

@section('title', 'BAZAR')

@section('content_header')
<h1>Data Bazar</h1>
@stop

@section('content')

@include('bazar.tambah-bazar')
@include('bazar.edit-bazar')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Bazar</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahBazar').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <div class="table-responsive">
                        <table id="tabelBazar" class="table table-bordered table-striped">
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
            "url": BASE_URL_API + '/bazar/barang/' + id_bazar,
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
            "url": "{{ url('api/v1/bazar') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelBazar').DataTable().clear().destroy();
        $('#tabelBazar').DataTable({
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

    function tambahBazar() {
            var settings = {
            "url": "{{ url ('api/v1/bazar')}}",
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
                $('#tambahBazar').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("tambahBazarForm").reset();
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

    function editBazar(id_bazar) {
        var settings = {
            "url": BASE_URL_API + "/bazar/" + id_bazar,
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
                $('#modal-edit-bazar').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
    }

    function updateBazar(id_bazar) {
        var settings = {
            "url": BASE_URL_API + "/bazar/" + id_bazar,
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
                $('#modal-edit-bazar').modal('hide');
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type: "success"
                });
                document.getElementById("form-edit-bazar").reset();
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

    function deleteBazar(id_bazar) {
        var settings = {
            "url": BASE_URL_API + "/bazar/" + id_bazar,
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
