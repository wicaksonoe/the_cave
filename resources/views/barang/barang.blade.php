@extends('adminlte::page')

@section('title', 'DATA BARANG')

@section('content_header')
<h1>Data Barang</h1>
@stop

@section('content')

@include('barang.tambah-barang')
@include('barang.edit-barang')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a onclick="$('#tambahBarang').modal('show')"><button type="button" class="btn btn-primary"
                            style="margin-bottom: 10px">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah
                        </button></a>
                    <div class="table-responsive">
                        <table id="tabelBarang" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jenis</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Harga Pokok</th>
                                    <th>Harga Jual</th>
                                    <th>Tanggal</th>
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

    $('.number').on('change', (e) => {
        e.target.value = formatNumber(e.target.value)
    });

    $(document).ready(function () {
        $('#tanggal').val(formatDate());
        $('#edit-tanggal').val(formatDate());
        get_data();

        let settings = {
            width: 'resolve'
        };

        $('#id_jenis').select2(settings);
        $('#id_tipe').select2(settings);
        $('#id_sup').select2(settings);
        $('#edit-id_jenis').select2(settings);
        $('#edit-id_tipe').select2(settings);
        $('#edit-id_sup').select2(settings);
    });

    $(".form-control").focus(function(e){
        $('small.text-danger.' + e.target.id).html('');
        $(e.target).removeClass("is-invalid")
    })

    function tambahJenisBaru(param,e) {
	    if (evt.keyCode==13){
			return false;
		}
		
        let value;
        let id_elem;
        switch (param) {
            case "tambah":
                value = $('#input_new_jenis').val();
                id_elem = "id_jenis";
                break;

            case "edit":
                value = $('#edit-input_new_jenis').val();
                id_elem = "edit-id_jenis";
                break;
        }

        if (value == "") {
            swal.fire({
                title: 'Error!',
                text: "Nama jenis baru, tidak boleh kosong",
                type : "error"
            })
        } else {
            kirimDataBaru('jenis', value, id_elem);
        }
		return true;
    }

    function tambahTipeBaru(param,e) {
		e.preventDefault();
        let value;
        let id_elem;
        switch (param) {
            case "tambah":
                value = $('#input_new_tipe').val();
                id_elem = "id_tipe";
                break;

            case "edit":
                value = $('#edit-input_new_tipe').val();
                id_elem = "edit-id_tipe";
                break;
        }

        if (value == "") {
            swal.fire({
                title: 'Error!',
                text: "Nama tipe baru, tidak boleh kosong",
                type : "error"
            })
        } else {
            kirimDataBaru('tipe', value, id_elem);
        }
    }

    function kirimDataBaru(method, value, id_elem) {
        let url;
        switch (method) {
            case "jenis":
                url = BASE_URL_API + '/jenis/';
                break;

            case "tipe":
                url = BASE_URL_API + '/tipe/';
                break;
        }

        let settings = {
            "url": url,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
            "data": {
                "data": value
            }
        };

        $.ajax(settings)
            .done(function (response) {
                let new_opt;

                if (method === "jenis") {
                    $('#id_jenis').children().remove();
                    $('#edit-id_jenis').children().remove();

                    $('#id_jenis').append('<option selected disabled>Pilih Jenis Barang...</option>');
                    $('#edit-id_jenis').append('<option selected disabled>Pilih Jenis Barang...</option>');

                    $('#input_new_jenis').val('');
                    $('#edit-input_new_jenis').val('');
                } else if (method === "tipe") {
                    $('#id_tipe').children().remove();
                    $('#edit-id_tipe').children().remove();

                    $('#id_tipe').append('<option selected disabled>Pilih Tipe Barang...</option>');
                    $('#edit-id_tipe').append('<option selected disabled>Pilih Tipe Barang...</option>');

                    $('#input_new_tipe').val('');
                    $('#edit-input_new_tipe').val('');
                }

                $.each(response.data, function (index, value) {
                    let string;
                    if (method === "jenis") {
                        string = value.nama_jenis;
                        new_opt = '<option value="' + value.id + '">' + string[0].toUpperCase() + string.slice(1) + '</option>'
                        $('#id_jenis').append(new_opt);
                        $('#edit-id_jenis').append(new_opt);
                    } else if (method === "tipe") {
                        string = value.nama_tipe;
                        new_opt = '<option value="' + value.id + '">' + string[0].toUpperCase() + string.slice(1) + '</option>'
                        $('#id_tipe').append(new_opt);
                        $('#edit-id_tipe').append(new_opt);
                    }
                });

                swal.fire({
                    title: 'Success!',
                    text: response.message,
                    type : "success"
                });
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: response.responseJSON.message,
                    type : "error"
                })
            });
    }

    function get_data() {
        var settings = {
            "url": "{{ url('api/v1/barang') }}",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem('access_token')
            },
        };
        $('#tabelBarang').DataTable().clear().destroy();
        $('#tabelBarang').DataTable({
            processing: false,
            serverSide: true,
            ajax: settings,
            columns: [
                {width: '25%', data: 'namabrg', name: 'namabrg'},
                {width: '10%', data: 'jenis_barang', name: 'jenis_barang'},
                {width: '10%', data: 'tipe_barang', name: 'tipe_barang'},
                {width: '10%', data: 'jumlah', name: 'jumlah'},
                {width: '10%', data: 'hpp', name: 'hpp'},
                {width: '10%', data: 'hjual', name: 'hjual'},
                {width: '10%', data: 'tanggal', name: 'tanggal'},
                {width: '15%', data: 'aksi', name: 'aksi'},
            ],
            order: [0, 'asc'],
            responsive: true
        });
    }

//fungsi cari barcode	
	function caribarcode(evt){
	    if (evt.keyCode==13){
			var barcode=$('#barcode').val();
			var settings = {
				"url": BASE_URL_API + "/barang/" + barcode,
				"method": "GET",
				"timeout": 0,
				"headers": {
					"Accept": "application/json",
					"Authorization": "Bearer " + sessionStorage.getItem('access_token')
				},
			};

			$.ajax(settings)
				.done(function (response) {
					$('#barcode').val(response.data.barcode)
					$('#namabrg').val(response.data.namabrg)
					$('#id_jenis').val(response.data.id_jenis)
					$('#id_jenis').trigger('change')

					$('#id_tipe').val(response.data.id_tipe)
					$('#id_tipe').trigger('change')

					$('#id_sup').val(response.data.id_sup)
					$('#id_sup').trigger('change')
					
					$('#stok').val(formatNumber(response.data.jumlah))
					$('#hpp').val(formatNumber(response.data.hpp))
					$('#hjual').val(formatNumber(response.data.hjual))
					$('#grosir').val(formatNumber(response.data.grosir))
					$('#partai').val(formatNumber(response.data.partai))
					$("#btntambahbarang").attr("onclick","updateBarang('"+barcode+"','tbh')");
			})

			return true;
		}
		$("#btntambahbarang").attr("onclick","tambahBarang()");
		return false;
	}
	
    function tambahBarang() {
        var settings = {
        "url": "{{ url ('api/v1/barang')}}",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Accept": "application/json",
            "Content-Type": "application/x-www-form-urlencoded",
            "Authorization": "Bearer " + sessionStorage.getItem('access_token')
        },
        data: {
            "barcode" : $('#barcode').val(),
            "namabrg" : $('#namabrg').val(),
            "id_jenis": $('#id_jenis').val(),
            "id_tipe" : $('#id_tipe').val(),
            "id_sup"  : $('#id_sup').val(),
            "jumlah"  : $('#jumlah').val().replace(',',''),
            "hpp"     : $('#hpp').val().replace(',',''),
            "hjual"   : $('#hjual').val().replace(',',''),
            "grosir"  : $('#grosir').val().replace(',',''),
            "partai"  : $('#partai').val().replace(',',''),
        }
        };

        $.ajax(settings).done(function( msg ) {
                $('#tambahBarang').modal('hide')
                swal.fire({
                    title: 'Berhasil',
                    text: msg.message,
                    type : "success"
                });
                document.getElementById("tambahBarangForm").reset();
                $('#tanggal').val(formatDate());
                $('#edit-tanggal').val(formatDate());
                get_data();
            })
            .fail(function( msg ) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type : "error"
                })

                $.each(msg.responseJSON.errors, function(key, value){
                    $('small.' + key).html(value);
                    $("#"+key).addClass("is-invalid");
                })
            });

    }

    function editBarang(id_barang) {
        var settings = {
            "url": BASE_URL_API + "/barang/" + id_barang,
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
                $('#edit-namabrg').val(response.data.namabrg)
                $('#edit-id_jenis').val(response.data.id_jenis)
                $('#edit-id_tipe').val(response.data.id_tipe)
                $('#edit-id_sup').val(response.data.id_sup)
                $('#edit-jumlah').val(formatNumber(response.data.jumlah))
                $('#edit-hpp').val(formatNumber(response.data.hpp))
                $('#edit-hjual').val(formatNumber(response.data.hjual))
                $('#edit-grosir').val(formatNumber(response.data.grosir))
                $('#edit-partai').val(formatNumber(response.data.partai))
                $('#update-button').val(response.data.barcode)
                $('#modal-edit-barang').modal('show');
            })
            .fail(function (response) {
                swal.fire({
                    title: 'Error!',
                    text: msg.responseJSON.message,
                    type: "error"
                })
            });
    }

    function updateBarang(barcode,st) {
		if (st=="tbh"){
			var jumlah=parseInt($('#stok').val().replace(',',''))+parseInt($('#jumlah').val().replace(',',''))
			var settings = {
				"url": BASE_URL_API + "/barang/" + barcode,
				"method": "PUT",
				"timeout": 0,
				"headers": {
					"Accept": "application/json",
					"Content-Type": "application/x-www-form-urlencoded",
					"Authorization": "Bearer " + sessionStorage.getItem('access_token')
				},
				"data": {
					"barcode" : $('#barcode').val(),
					"namabrg" : $('#namabrg').val(),
					"id_jenis": $('#id_jenis').val(),
					"id_tipe" : $('#id_tipe').val(),
					"id_sup"  : $('#id_sup').val(),
					"jumlah"  : jumlah,
					"hpp"     : $('#hpp').val().replace(',',''),
					"hjual"   : $('#hjual').val().replace(',',''),
					"grosir"  : $('#grosir').val().replace(',',''),
					"partai"  : $('#partai').val().replace(',',''),
				}
			};

			$.ajax(settings)
				.done(function (msg) {
					$('#modal-edit-barang').modal('hide');
					swal.fire({
						title: 'Berhasil',
						text: msg.message,
						type: "success"
					});
					document.getElementById("tambahBarangForm").reset();
					$('#tanggal').val(formatDate());
					get_data();
					$("#tambahBarang").modal("hide")
				})
				.fail(function (msg) {
					swal.fire({
						title: 'Error!',
						text: msg.responseJSON.message,
						type: "error"
					})

					$.each(msg.responseJSON.errors, function (key, value) {
						$('small.edit-' + key).html(value);
						$("#edit-" + key).addClass("is-invalid")
					})
				});
		}else{
			var settings = {
				"url": BASE_URL_API + "/barang/" + barcode,
				"method": "PUT",
				"timeout": 0,
				"headers": {
					"Accept": "application/json",
					"Content-Type": "application/x-www-form-urlencoded",
					"Authorization": "Bearer " + sessionStorage.getItem('access_token')
				},
				"data": {
					"barcode" : $('#edit-barcode').val(),
					"namabrg" : $('#edit-namabrg').val(),
					"id_jenis": $('#edit-id_jenis').val(),
					"id_tipe" : $('#edit-id_tipe').val(),
					"id_sup"  : $('#edit-id_sup').val(),
					"jumlah"  : $('#edit-jumlah').val().replace(',',''),
					"hpp"     : $('#edit-hpp').val().replace(',',''),
					"hjual"   : $('#edit-hjual').val().replace(',',''),
					"grosir"  : $('#edit-grosir').val().replace(',',''),
					"partai"  : $('#edit-partai').val().replace(',',''),
				}
			};

			$.ajax(settings)
				.done(function (msg) {
					$('#modal-edit-barang').modal('hide');
					swal.fire({
						title: 'Berhasil',
						text: msg.message,
						type: "success"
					});
					document.getElementById("form-edit-barang").reset();
					$('#tanggal').val(formatDate());
					$('#edit-tanggal').val(formatDate());
					get_data();
				})
				.fail(function (msg) {
					swal.fire({
						title: 'Error!',
						text: msg.responseJSON.message,
						type: "error"
					})

					$.each(msg.responseJSON.errors, function (key, value) {
						$('small.edit-' + key).html(value);
						$("#edit-" + key).addClass("is-invalid")
					})
				});			
		}
    }

    function deleteBarang(id_barang) {
        var settings = {
            "url": BASE_URL_API + "/barang/" + id_barang,
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
