@extends('frontend.app')

@section('title', 'Reset Password')

@section('content')
<section>
    <div class="container mt-5 mb-5">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        <div class="col-lg-10 mx-auto">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="form-group clearfix d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger">Send Password Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
