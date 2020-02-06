@extends('auth.master')

@section('classes_body', 'login-page')

@section('body')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
            <form id="formLogin" method="post">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control " placeholder="Username" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control " placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ __('adminlte::adminlte.sign_in') }}
                        </button>
                    </div>
                </div>
            </form>
            <br>
            @if (url('register'))
            <p class="mb-0">
                <a href="{{ url('/register') }}">
                    {{ __('adminlte::adminlte.register_a_new_membership') }}
                </a>
            </p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('adminlte_js')
<script>
    let TimeNow = new Date( Date.now() );
    TimeNow.setHours( TimeNow.getHours() + 1);

    $('.form-control').focus((el) => {
        $(el.target).removeClass('is-invalid');
    })

    $('#formLogin').submit((e) => {
        e.preventDefault();

        $.ajax({
            method: 'post',
            url: '{{ url("api/v1/login") }}',
            data: {
                username: $('[name="username"]').val(),
                password: $('[name="password"]').val(),
            },
            dataType: 'json'
        })
        .done(( response ) => {
            sessionStorage.setItem('access_token', response.access_token);
            // document.cookie = "access_token=" + response.access_token + '; expires=' + TimeNow.toUTCString();
            Swal.fire({
                title: 'Success!',
                text: 'Selamat datang.',
                type: 'success',
                onClose: () => {
                    window.location.replace('{{ url("/dashboard") }}')
                }
            });
        })
        .fail(( response ) => {
            Swal.fire({
                title: 'Failed!',
                text: 'Username atau password salah',
                type: 'error'
            });

            $('.form-control').addClass('is-invalid');
        });
    })
</script>
@endsection