@extends('adminlte::page')

@section('title', 'LAPORAN')

@section('content_header')
<div class="pl-4">
    <h1>Cetak Laporan</h1>
</div>
@stop

@section('content')
<div class="container p-4">
    <div class="row mb-4">
        <div class="col-3">
            <select name="bulan" id="bulan" class="form-control">
                <option value="" selected disabled>-- Pilih Bulan --</option>
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
        <div class="col-2">
            <select id="tahun" class="form-control">
                <option selected disabled>-- Pilih Tahun --</option>
                @for ($i = date('Y'); $i >= 2010; $i--) <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col">
            <button class="btn btn-primary" onclick="show()">Tampilkan</button>
            <button class="btn btn-warning" onclick="window.print()">Cetak</button>
        </div>
    </div>
    <div id="section-to-print">
        <div class="row mb-4 ml-2">
            <div class="col-12">
                <h2 id="headerLaporan"></h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="accordion" id="laporan">
                    <!-- card penjualan toko -->
                    <div class="card mb-0">
                        <div class="card-header" id="headingPenjualanToko">
                            <div class="row align-middle">
                                <div class="col-8 mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#penjualanToko" aria-expanded="true" aria-controls="penjualanToko">
                                        Penjualan Toko
                                    </button>
                                </div>
                                <div class="col-4 mb-0"
                                    style="display: flex; align-items: center; justify-content: flex-end;">
                                    <span id="valuePenjualanToko" class="float-right">Rp. -</span>
                                </div>
                            </div>
                        </div>

                        <div id="penjualanToko" class="collapse" aria-labelledby="headingPenjualanToko">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10 offset-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- card penjualan bazar -->
                    <div class="card mb-0">
                        <div class="card-header" id="headingPenjualanBazar">
                            <div class="row align-middle">
                                <div class="col-8 mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#penjualanBazar" aria-expanded="true"
                                        aria-controls="penjualanBazar">
                                        Penjualan Bazar
                                    </button>
                                </div>
                                <div class="col-4 mb-0"
                                    style="display: flex; align-items: center; justify-content: flex-end;">
                                    <span id="valuePenjualanBazar" class="float-right">Rp. -</span>
                                </div>
                            </div>
                        </div>

                        <div id="penjualanBazar" class="collapse" aria-labelledby="headingPenjualanBazar">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10 offset-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- card Biaya toko -->
                    <div class="card mb-0">
                        <div class="card-header" id="headingBiayaToko">
                            <div class="row align-middle">
                                <div class="col-8 mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#biayaToko" aria-expanded="true" aria-controls="biayaToko">
                                        Biaya Toko
                                    </button>
                                </div>
                                <div class="col-4 mb-0"
                                    style="display: flex; align-items: center; justify-content: flex-end;">
                                    <span id="valueBiayaToko" class="float-right">Rp. (-)</span>
                                </div>
                            </div>
                        </div>

                        <div id="biayaToko" class="collapse" aria-labelledby="headingBiayaToko">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10 offset-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- card Biaya bazar -->
                    <div class="card mb-0">
                        <div class="card-header" id="headingBiayaBazar">
                            <div class="row align-middle">
                                <div class="col-8 mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#biayaBazar" aria-expanded="true" aria-controls="biayaBazar">
                                        Biaya Bazar
                                    </button>
                                </div>
                                <div class="col-4 mb-0"
                                    style="display: flex; align-items: center; justify-content: flex-end;">
                                    <span id="valueBiayaBazar" class="float-right">Rp. (-)</span>
                                </div>
                            </div>
                        </div>

                        <div id="biayaBazar" class="collapse" aria-labelledby="headingBiayaBazar">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- card Total -->
                    <div class="card mb-0">
                        <div class="card-header" id="headingTotal">
                            <div class="row align-middle">
                                <div class="col-8 mb-0">
                                    <button class="btn btn-link text-left" type="button">
                                        Total Untung/Rugi
                                    </button>
                                </div>
                                <div class="col-4 mb-0"
                                    style="display: flex; align-items: center; justify-content: flex-end;">
                                    <span id="valueTotal" class="float-right">Rp. -</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    const BASE_URL = "{{ url('api/v1') }}"

    function resetForm() {
        $('#valueBiayaToko').html("Rp. (-)");
        $('#biayaToko').children().children().children().children().remove();

        $('#valueBiayaBazar').html("Rp. (-)");
        $('#biayaBazar').children().children().children().children().remove();

        $('#valuePenjualanBazar').html("Rp. -");
        $('#penjualanBazar').children().children().children().children().remove();

        $('#valuePenjualanToko').html("Rp. -");
        $('#penjualanToko').children().children().children().children().remove();

        $('#valueTotal').html("Rp. -");
    }

    function getBulan() {
        let namaBulan;

        switch ($('#bulan').val()) {
            case "01":
                namaBulan = "Januari";
                break;

            case "02":
                namaBulan = "Februari";
                break;

            case "03":
                namaBulan = "Maret";
                break;

            case "04":
                namaBulan = "April";
                break;

            case "05":
                namaBulan = "Mei";
                break;

            case "06":
                namaBulan = "Juni";
                break;

            case "07":
                namaBulan = "Juli";
                break;

            case "08":
                namaBulan = "Agustus";
                break;

            case "09":
                namaBulan = "September";
                break;

            case "10":
                namaBulan = "Oktober";
                break;

            case "11":
                namaBulan = "November";
                break;

            case "12":
                namaBulan = "Desember";
                break;
        }

        return namaBulan;
    }

    function show() {
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();

        if (bulan == null || tahun == null) {
            swal.fire({
                title: 'Error!',
                text: 'Mohon pilih bulan dan tahun terlebih dahulu',
                type: "error"
            });
            return;
        }

        resetForm();
        $(".collapse").removeClass('show');

        let settings = {
            "url": BASE_URL + '/laporan/penjualan/' + bulan.toString() + '/' + tahun.toString(),
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token'),
            },
        };

        $.ajax(settings)
            .done(function (response) {
                // card biaya toko
                let biayaToko = 0;
                $.each(response.data.biaya_toko, function (index, value) {
                    biayaToko += value.nominal;
                    let newElem = '<div class="row mt-1">' +
                        '<div class="col-8">' +
                        '<span>' + value.keterangan + '</span>' +
                        '</div>' +
                        '<div class="col-4">' +
                        '<span class="float-right">Rp. (' + value.nominal.toLocaleString() + ')</span>' +
                        '</div>' +
                        '</div>';

                    $('#biayaToko').children().children().children().append(newElem);
                });
                $('#valueBiayaToko').html("Rp. (" + biayaToko.toLocaleString() + ")");

                // card biaya toko
                let biayaBazar = 0;
                $.each(response.data.biaya_bazar, function (index, value) {
                    let id_bazar = value.id_bazar;
                    let newElem = '<div class="card mb-0"> \
                                        <div class="card-header" id="headingBiayaBazar' + id_bazar + '"> \
                                            <div class="row align-middle"> \
                                                <div class="col-8 offset-1 mb-0"> \
                                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse" \
                                                        data-target="#biayaBazar' + id_bazar + '" aria-expanded="true" aria-controls="biayaBazar' + value.id_bazar + '"> \
                                                        Biaya ' + value.nama_bazar +
                        '</button> \
                                                </div> \
                                                <div class="col-2 mb-0" \
                                                    style="display: flex; align-items: center; justify-content: flex-end;"> \
                                                    <span id="valueBiayaBazar' + id_bazar + '" class="float-right">Rp. (100000000)</span> \
                                                </div> \
                                            </div> \
                                        </div> \
                                        <div id="biayaBazar' + id_bazar + '" class="collapse" aria-labelledby="headingBiayaBazar' + value.id_bazar + '"> \
                                            <div class="card-body"> \
                                                <div class="row"> \
                                                    <div class="col-9 offset-1"></div> \
                                                </div> \
                                            </div> \
                                        </div> \
                                    </div>';

                    $('#biayaBazar').children().children().children().append(newElem);

                    let biayaSatuBazar = 0;
                    $.each(value.biaya, function (index, value) {
                        biayaSatuBazar += value.nominal;
                        let newElem = '<div class="row mt-1">' +
                            '<div class="col-8">' +
                            '<span>' + value.keterangan + '</span>' +
                            '</div>' +
                            '<div class="col-4">' +
                            '<span class="float-right">Rp. (' + value.nominal.toLocaleString() + ')</span>' +
                            '</div>' +
                            '</div>';
                        $('#biayaBazar' + id_bazar).children().children().children().append(newElem);
                    });
                    $('#valueBiayaBazar' + id_bazar).html("Rp. (" + biayaSatuBazar.toLocaleString() + ")");

                    biayaBazar += biayaSatuBazar;
                });
                $('#valueBiayaBazar').html("Rp. (" + biayaBazar.toLocaleString() + ")");

                // card penjualan bazar
                let rowPenjualanBazar = '<div class="row mt-1">' +
                    '<div class="col-8">' +
                    '<span>Total penjualan bazar bulan ' + getBulan() + '</span>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<span class="float-right">Rp. ' + response.data.penjualan_bazar.toLocaleString() + '</span>' +
                    '</div>' +
                    '</div>';

                $('#penjualanBazar').children().children().children().append(rowPenjualanBazar);
                $('#valuePenjualanBazar').html("Rp. " + response.data.penjualan_bazar.toLocaleString());

                // card penjualan toko
                let rowPenjualanToko = '<div class="row mt-1">' +
                    '<div class="col-8">' +
                    '<span>Total penjualan toko bulan ' + getBulan() + '</span>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<span class="float-right">Rp. ' + response.data.penjualan_toko.toLocaleString() + '</span>' +
                    '</div>' +
                    '</div>';

                $('#penjualanToko').children().children().children().append(rowPenjualanToko);
                $('#valuePenjualanToko').html("Rp. " + response.data.penjualan_toko.toLocaleString());

                // card total
                $('#headerLaporan').html("Laporan bulan " + getBulan() + " tahun " + $('#tahun').val() );
                let total_laba_rugi = (response.data.penjualan_toko + response.data.penjualan_bazar) - (biayaToko + biayaBazar)
                if (total_laba_rugi > 0) {
                    $('#valueTotal').html("Rp. " + total_laba_rugi.toLocaleString());
                } else {
                    $('#valueTotal').html("Rp. (" + total_laba_rugi.toLocaleString() + ")");
                }

                // collapse all card
                $(".collapse").addClass('show');

                // kasih tanda selesai
                swal.fire({
                    title: 'Success!',
                    text: "Data berhasil ditampilkan",
                    type: "success"
                })
            })
            .fail(function (response) {
                resetForm();
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });

    }
</script>
@stop

@section('css')
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #section-to-print,
        #section-to-print * {
            visibility: visible;
        }

        #section-to-print {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endsection
