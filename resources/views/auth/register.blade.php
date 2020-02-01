@extends('auth.master')

@section('classes_body', 'register-page')

@section('body')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url('/') }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">{{ __('adminlte::adminlte.register_message') }}</p>
            <form method="post" id="formRegister">
                {{ csrf_field() }}

                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <textarea name="alamat" class="form-control" placeholder="Alamat"></textarea>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-map-marker-alt"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="number" name="telp" class="form-control" placeholder="No. Telepon">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone-alt"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select name="role" class="form-control">
                        <option disbled selected>Pilih Jabatan...</option>
                        <option value="admin">Admin</option>
                        <option value="pegawai">Pegawai</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-list"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Re-enter Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    {{ __('adminlte::adminlte.register') }}
                </button>
            </form>
            <p class="mt-2 mb-1">
                <a href="{{ url('/login') }}">
                    {{ __('adminlte::adminlte.i_already_have_a_membership') }}
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@section('adminlte_js')
<script>
    $('.form-control').focus((el) => {
        $(el.target).removeClass('is-invalid');
    })

    $('#formRegister').submit((e) => {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: '{{ url("api/v1/register") }}',
            data: {
                username             : $('[name="username"]').val(),
                password             : $('[name="password"]').val(),
                password_confirmation: $('[name="password_confirmation"]').val(),
                nama                 : $('[name="nama"]').val(),
                alamat               : $('[name="alamat"]').val(),
                telp                 : $('[name="telp"]').val(),
                role                 : $('[name="role"]').val(),
            }
        })
            .done((e) => {
                Swal.fire({
                    title: 'Success!',
                    text: e.message,
                    type: 'success',
                    onClose: () => {
                        window.location.replace('{{ url("/login") }}')
                    }
                })
            })
            .fail((e) => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan.',
                    type: 'error'
                })

                $.each(e.responseJSON.errors, function(key, value) {
                    $('[name="' + key + '"]').addClass('is-invalid')
                })
            })
    });
</script>
@endsection