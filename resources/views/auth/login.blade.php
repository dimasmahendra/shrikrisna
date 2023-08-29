@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-8 p-r-35 p-l-35">
            <img src="{{ url('auth/img/logo-auth.svg'); }}" class="logo-auth" alt="Login Logo">
            <img src="{{ url('auth/img/img-login.png'); }}" class="logo" alt="Login Logo">
            <p class="m-b-35 font-subtitle">Login to your account</p>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group first">
                    <span class="icon-span">
                        <i class="icon-message"></i>
                    </span>
                    <input type="text" class="form-control text-army p-l-70" name="email" placeholder="Email" id="email" required>
                </div>
                <div class="pb-3">
                    <div class="form-group icon-div">
                        <span class="icon-span">
                            <i class="icon-lock"></i>
                        </span>
                        <span class="btn-show-pass">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                        <input type="password" class="form-control text-army p-l-70" name="password" placeholder="Password" id="password" required>
                    </div>
                </div>
                <button class="btn btn-block btn-ky-warning" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
