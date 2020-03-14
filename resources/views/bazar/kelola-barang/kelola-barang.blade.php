@extends ('adminlte::page')

@section('title', 'KELOLA BARANG BAZAR')

@section('content_header')
<h1>Kelola Barang Bazar</h1>
@stop

@section('content')

@include('bazar.kelola-barang.tambah-kelola-barang')
@include('bazar.kelola-barang.edit-kelola-barang')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2><span class="badge badge-light">{{$bazar->nama_bazar}}</span></h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahKelolaBarang').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <a href="{{ route('bazar.kelola-staff', $id_bazar) }}" class="btn btn-info"
                        style="margin-bottom: 10px">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Kelola Staff</a>
                    <div class="table-responsive">
                        <table id="tabelKelolaBarang" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Tipe Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Pokok Penjualan</th>
                                    <th>Harga Jual <span class="badge badge-danger">Rp.
                                            {{ number_format($bazar->potongan, 0, '.', ',') }} Off</span></th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
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

    function formatDate() {
        var d = new Date(Date.now()),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    $(document).ready(function () {
        $('#date').val(formatDate());
        get_data();
    });

    $(".form-control").focus(function(e){
        $(e.target).removeClass("is-invalid")
    })

    $('#tambahKelolaBarangForm').submit((e) => {
        e.preventDefault();
    })

    $('#tambahKelolaBarang').on('hide.bs.modal', (e) => {
        $('#konten_tambah_barang').empty();
    });

    $('#tambahKelolaBarang').on('show.bs.modal', (e) => {
        $('#date').val(formatDate());
    });

    function get_nama_barang(barcode) {
        if (barcode == '') {
            swal.fire({
                title: 'Error!',
                text: 'Mohon isi barcode terlebih dahulu',
                type: "error"
            });

            return false;
        }

        let settings = {
            "url": BASE_URL_API + "/barang/" + barcode ,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };

        $.ajax(settings)
            .done(function (response) {
                let barcode = response.data.barcode;
                let newRow = '<tr id="' + barcode + '">' +
                                '<td><input type="text" name="barcode[]" class="form-control" value="' + barcode + '" readonly></td>' +
                                '<td>' + response.data.namabrg + '</td>' +
                                '<td><input type="text" name="jumlah[]" class="form-control number"></td>' +
                                '<td><button class="btn btn-sm btn-danger" onclick="delete_nama_barang(' + barcode + ')"><i class="fas fa-trash-alt"></i></button></td>' +
                            '</tr>';

                if ( $('#' + barcode).length ) {
                    swal.fire({
                        title: 'Error!',
                        text: 'Barang ini sudah anda tambahkan di keranjang',
                        type: "error"
                    })
                } else {
                    $('#konten_tambah_barang').append(newRow);
                }

                $('#barcode_scan').val('');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
    }

    function delete_nama_barang(barcode) {
        $('#' + barcode).remove();
    }


    function get_data() {
        var settings = {
            "url": "{{ url('api/v1/bazar/barang').'/'.$id_bazar }}" ,
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
                {width: '15%', data: 'nama_barang', name: 'nama_barang'},
                {width: '10%', data: 'jenis_barang', name: 'jenis_barang'},
                {width: '15%', data: 'tipe_barang', name: 'tipe_barang'},
                {width: '10%', data: 'jumlah', name: 'jumlah'},
                {width: '10%', data: 'hpp', name: 'hpp'},
                {width: '10%', data: 'hjual', name: 'hjual'},
                {width: '15%', data: 'date', name: 'date'},
                {width: '15%', data: 'aksi', name: 'aksi'},

            ],
            order: [0, 'asc'],
            responsive: true
        });
    }

    function tambahKelolaBarang() {
            var settings = {
                "url": "{{ url ('api/v1/bazar/barang').'/'.$id_bazar }}" ,
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Accept": "application/json",
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Authorization": "Bearer " + sessionStorage.getItem('access_token')
                },
                "data": $('#tambahKelolaBarangForm').serialize()
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
            "url": BASE_URL_API + "/bazar/barang/"+ "{{$id_bazar}}" + "/" + id_KelolaBarang,
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
                $('#update-button').val(response.data.id)
                $('#modal-edit-KelolaBarang').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
    }

    function updateKelolaBarang(id_KelolaBarang) {
        var settings = {
            "url": BASE_URL_API + "/bazar/barang/"+ "{{$id_bazar}}" + "/" + id_KelolaBarang,
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
                    text: msg.responseJSON.message,
                    type: "error"
                })

                $.each(msg.responseJSON.errors, function (key, value) {
                    $("#edit-" + key).addClass("is-invalid")
                })
            });
    }

    function deleteKelolaBarang(id_KelolaBarang) {
        var settings = {
            "url": BASE_URL_API + "/bazar/barang/"+ "{{$id_bazar}}" + "/" + id_KelolaBarang,
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
