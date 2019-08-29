@extends('auth.app')

@section('title', 'Verify email')

@section('content')
<div class="wrap-login100">
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            A fresh verification link has been sent to your email address.
        </div>
    @endif
    <div class="login100-form-title" style="background-image: url({{ asset('auth/images/bg-01.jpg') }});">
        <span class="login100-form-title-1">
            Verify Your Email Address
        </span>
    </div>
    <div class="m-4 text-center">
        <p>Before proceeding, please check your email for a verification link.</p>
        <p>If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to request another</a>.</p>
    </div>
</div>
@endsection

