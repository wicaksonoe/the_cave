@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Example single danger button -->
                    <div class="form-group row">
                        <div class="col-3">
                            <select id="bulan" class="form-control">
                                <option selected disabled>Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="tahun" class="form-control">
                                <option selected disabled>Tahun</option>
                                @for ($i = 2010; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="penjualan" class="form-control">
                                <option selected disabled>Jenis Penjualan</option>
                                <option value="all">Semua</option>
                                <option value="bazar">Bazar</option>
                                <option value="global">Global</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="button" id="cari" class="btn btn-outline-primary">Cari</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="barangTerlaris" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="bodyBarangTerlaris"></tbody>
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
    const BASE_URL = "{{ url('api/v1') }}"
    $(document).ready(function () {

        $('button#cari').on('click', function () {
            if ($('#bulan').val() == null) {
                swal.fire({
                    title: 'Error!',
                    text: 'Mohon pilih bulan terlebih dahulu',
                    type: "error"
                })
                return;
            }

            if ($('#tahun').val() == null) {
                swal.fire({
                    title: 'Error!',
                    text: 'Mohon pilih tahun terlebih dahulu',
                    type: "error"
                })
                return;
            }

            if ($('#penjualan').val() == null) {
                swal.fire({
                    title: 'Error!',
                    text: 'Mohon pilih jenis penjualan terlebih dahulu',
                    type: "error"
                })
                return;
            }

            let bulan = $('#bulan').val().toString();
            let tahun = $('#tahun').val().toString();
            let penjualan = $('#penjualan').val().toString();

            let request = bulan + '/' + tahun + '/' + penjualan;

            let settings = {
                "url": BASE_URL + '/laporan/terlaris/' + request,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Accept": "application/json",
                    "Authorization": "Bearer " + sessionStorage.getItem('access_token'),
                },
            };

            $.ajax(settings)
                .done(function (response) {
                    $('#bodyBarangTerlaris').children().remove();
                    let newRow;

                    $.each(response.data, function (index, value) {
                        newRow = "<tr>" +
                            "<td>" + value.barcode + "</td>" +
                            "<td>" + value.nama_barang + "</td>" +
                            "<td>" + value.jumlah + "</td>" +
                            "</tr>"

                        $('#bodyBarangTerlaris').append(newRow);
                    });

                    swal.fire({
                        title: 'Success!',
                        text: "Data berhasil diterima. Terdapat " + response.jumlah_data.toString() + " barang",
                        type: "success"
                    })
                })
                .fail(function (response) {
                    $('#bodyBarangTerlaris').children().remove();
                    swal.fire({
                        title: 'Error!',
                        text: response.responseJSON.message,
                        type: "error"
                    })
                });
        });

    })
</script>
@stop
