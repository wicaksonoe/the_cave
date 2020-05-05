@extends ('adminlte::page')

@section('title', 'BAZAR')

@section('content')
<div class="container" id="section-to-print">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Laporan {{ $nama_bazar }}
                <button class="ml-4 btn btn-sm btn-warning hidden-print" onclick="window.print()">Cetak</button>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="accordion mb-4">
                {{-- card penjualan --}}
                <div class="card mb-0">
                    <div class="card-header" id="headingPenjualanBazar">
                        <div class="row align-middle">
                            <div class="col-8 mb-0">
                                <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                    data-target="#penjualanBazar" aria-expanded="true" aria-controls="penjualanBazar">
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
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-12"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- card biaya --}}
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
                                <span id="valueBiayaBazar" class="float-right">Rp. -</span>
                            </div>
                        </div>
                    </div>

                    <div id="biayaBazar" class="collapse" aria-labelledby="headingBiayaBazar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10 offset-1"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- total laba/rugi --}}
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
@stop

@section('js')
<script>
    const BASE_URL = "{{ url('api/v1') }}";

    $(document).ready(function () {
        let settings = {
            "url": BASE_URL + '/laporan/penjualan/bazar/{{ $id }}',
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token'),
            },
        }

        $.ajax(settings)
            .done(function (response) {
                // card biaya bazar
                let biayaBazar = 0;
                $.each(response.data.daftar_biaya, function (index, value) {
                    biayaBazar += value.nominal;
                    let newElem = '<div class="row mt-1">' +
                        '<div class="col-8">' +
                        '<span>' + value.keterangan + '</span>' +
                        '</div>' +
                        '<div class="col-4">' +
                        '<span class="float-right">Rp. (' + value.nominal.toLocaleString() + ')</span>' +
                        '</div>' +
                        '</div>';

                    $('#biayaBazar').children().children().children().append(newElem);
                });
                $('#valueBiayaBazar').html("Rp. (" + biayaBazar.toLocaleString() + ")");

                // card transaksi
                let totalTransaksi = 0;
                $.each(response.data.daftar_penjualan, function (index, value) {
                    let kode_trx = value.kode_trx;
                    let potongan = value.potongan;
                    let newElem = '<div class="card mb-0"> \
                                        <div class="card-header" id="headingPenjualanBazar' + kode_trx + '"> \
                                            <div class="row align-middle"> \
                                                <div class="col-8 offset-1 mb-0"> \
                                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse" \
                                                        data-target="#penjualanBazar' + kode_trx + '" aria-expanded="true" aria-controls="penjualanBazar' + kode_trx + '"> \
                                                        Total transaksi ' + kode_trx +
                        '</button> \
                                                </div> \
                                                <div class="col-2 mb-0" \
                                                    style="display: flex; align-items: center; justify-content: flex-end;"> \
                                                    <span id="valuePenjualanBazar' + kode_trx + '" class="float-right">Rp. (100000000)</span> \
                                                </div> \
                                            </div> \
                                        </div> \
                                        <div id="penjualanBazar' + kode_trx + '" class="collapse" aria-labelledby="headingPenjualanBazar' + kode_trx + '"> \
                                            <div class="card-body"> \
                                                <div class="row"> \
                                                    <div class="col-9 offset-1"></div> \
                                                </div> \
                                            </div> \
                                        </div> \
                                    </div>';

                    $('#penjualanBazar').children().children().children().append(newElem);

                    let totalTransaksiSatu = 0;
                    $.each(value.items, function (index, value) {
                        let subTotal = (value.hjual * value.jumlah) - potongan;
                        totalTransaksiSatu += subTotal;
                        let newElem = '<div class="row mt-1">' +
                            '<div class="col-8">' +
                            '<span>(' + value.barcode + ') ' + value.namabrg + ' @ ' + value.jumlah + ' pcs</span>' +
                            '</div>' +
                            '<div class="col-4">' +
                            '<span class="float-right">Rp. ' + subTotal.toLocaleString() + '</span>' +
                            '</div>' +
                            '</div>';
                        $('#penjualanBazar' + kode_trx).children().children().children().append(newElem);
                    });
                    $('#valuePenjualanBazar' + kode_trx).html("Rp. " + totalTransaksiSatu.toLocaleString());

                    totalTransaksi += totalTransaksiSatu;
                });
                $('#valuePenjualanBazar').html("Rp. " + totalTransaksi.toLocaleString());

                // done
                totalLabaRugi = totalTransaksi - biayaBazar;

                if (totalLabaRugi < 0) {
                    $('#valueTotal').html('Rp. (' + totalLabaRugi.toLocaleString() + ')')
                } else {
                    $('#valueTotal').html('Rp. ' + totalLabaRugi.toLocaleString())
                }
                $(".collapse").addClass('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type: "error"
                })
            });
    });
</script>
@stop


@section('css')
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .hidden-print {
            visibility: hidden !important;
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
