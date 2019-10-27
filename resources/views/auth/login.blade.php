@extends('auth.app')

@section('title', 'Sign in')

@section('content')
<div class="wrap-login100">
    <div class="login100-form-title" style="background-image: url({{ asset('auth/images/bg-01.jpg') }});">
        <span class="login100-form-title-1">
            Sign In
        </span>
    </div>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
            <span class="label-input100">Username</span>
                <input class="input100" type="text" name="username" placeholder="Enter username">
            <span class="focus-input100"></span>
        </div>

        <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
            <span class="label-input100">Password</span>
                <input class="input100" type="password" name="password" placeholder="Enter password">
            <span class="focus-input100"></span>
        </div>

        <div class="flex-sb-m w-full p-b-30">
            <div class="contact100-form-checkbox">
                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                <label class="label-checkbox100" for="ckb1">
                    Remember me
                </label>
            </div>

            <div>
                <a href="#" class="txt1">
                    Forgot Password?
                </a>
            </div>
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Sign In
            </button>
        </div>
    </form>
</div>
@endsection