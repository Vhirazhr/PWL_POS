@extends('layouts.login')

@section('content')
<p class="login-box-msg">Masuk menggunakan akun PWL POS kamu.</p>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        {{ $errors->first() }}
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success" role="status">
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('login.submit') }}" method="POST">
    @csrf

    <div class="input-group mb-3">
        <input
            type="text"
            name="username"
            class="form-control @error('username') is-invalid @enderror"
            placeholder="Username"
            value="{{ old('username') }}"
            autocomplete="username"
            maxlength="20"
            required
            autofocus
        >
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>

    <div class="input-group mb-3">
        <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Password"
            autocomplete="current-password"
            required
        >
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block btn-login">
        Masuk
    </button>
</form>
@endsection
