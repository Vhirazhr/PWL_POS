@extends('layouts.login')

@section('content')
<p class="login-box-msg">Silakan login untuk masuk</p>

<form action="{{ route('login') }}" method="post">
    @csrf
    <div class="input-group mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-login">Login</button>
        </div>
    </div>
</form>
@endsection