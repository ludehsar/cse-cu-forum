@extends('frontend.app')

@section('title', 'Verify email')

@section('content')
    <section>
        <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 400px;">
            <h2>
                Verify Your Email Address
            </h2>
            <div>
                <p>Before proceeding, please check your email for a verification link. If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to request another</a>.</p>
            </div>
        </div>
    </section>
@endsection

