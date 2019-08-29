@extends('auth.app')

@section('title', 'Sign up')

@section('content')
<div class="wrap-login100">
    <div class="login100-form-title" style="background-image: url({{ asset('auth/images/bg-01.jpg') }});">
        <span class="login100-form-title-1">
            Sign Up
        </span>
    </div>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    <form class="login100-form validate-form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="wrap-input100 validate-input m-b-26" data-validate="Name is required">
            <span class="label-input100">Full Name</span>
                <input class="input100" type="text" name="name" placeholder="Enter your full name">
            <span class="focus-input100"></span>
        </div>

        <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
            <span class="label-input100">Email</span>
                <input class="input100" type="email" name="email" placeholder="Enter your email address">
            <span class="focus-input100"></span>
        </div>

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

        <div class="wrap-input100 validate-input m-b-18" data-validate = "Confirm Password">
            <span class="label-input100">Confirm Password</span>
                <input class="input100" type="password" name="password_confirmation" placeholder="Confirm password">
            <span class="focus-input100"></span>
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Sign Up
            </button>
        </div>
    </form>
</div>
@endsection

