@extends('adminlte::page')

@section('title', 'TAMBAH BAZZAR')

@section('content_header')
    <h1>Bazzar</h1>
@stop

@section('content')
    <p>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Bazzar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="form-group">
                    <label for="nama">Nama Bazzar</label>
                    <input class="form-control" id="nama_bazzar" placeholder="Nama Bazzar">
                </div>
                <div class="form-group">
                    <label for="alamat"> Alamat Bazzar</label>
                    <textarea class="form-control" rows="3" id="alamat" placeholder="Alamat Bazzar"></textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal"> Tanggal</label>
                    <input type = 'date' class="form-control" id="tgl" placeholder="Tanggal Bazzar">
                </div>

                <div class="form-group">
                    <label for="potongan"> Potongan</label>
                    <input class="form-control"  id="potongan" placeholder="Potongan Harga">
                </div>
                <div class="form-group">
                    <label for="status"> Status</label><br>
                    <input type="checkbox" checked class="form-control" data-toggle="toggle"  id="status" placeholder="Status Bazzar">

                </div>

                <a href="{{ url ('/bazzar/tambah/barang-keluar') }}" button type="button" style="margin-bottom: 10px" class="btn btn-primary" >
                    Simpan dan Lanjut
                </button></a>
            </div>
            <!-- /.card-body -->
        </div>

    </p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(".form-control").focus(function(e){
            $(e.target).removeClass("is-invalid")
        })
        $('#tambahBazzar').submit(function(e) {
            e.preventDefault()
        })
        function tambahBarang() {
            $.ajax({
                method: "POST",
                url: "{{ url ('api/v1/barang')}}",
                data: {
                    barcode: $('#barcode').val(),
                    namabrg: $('#namabrg').val(),
                    id_jenis: $('#id_jenis').val(),
                    id_tipe: $('#id_tipe').val(),
                    id_sup: $('#id_sup').val(),
                    jumlah: $('#jumlah').val(),
                    hpp: $('#hpp').val(),
                    hjual: $('#hjual').val(),
                    grosir: $('#grosir').val(),
                    partai: $('#partai').val(),
                    tgl: $('#tgl').val(),
                }
                })
                .done(function( msg ) {
                    $('#tambahBarang').modal('hide')
                    swal.fire({
                        title: 'Berhasil',
                        text: msg.message,
                        type : "success"
                    })
                })
                .fail(function( msg ) {
                    swal.fire({
                        title: 'Error!',
                        text: 'Terjadi Kesalahan',
                        type : "error"
                    })

                    $.each(msg.responseJSON.errors, function(key, value){
                        $("#"+key).addClass("is-invalid")
                    })
                });
            }
    </script>
@stop


