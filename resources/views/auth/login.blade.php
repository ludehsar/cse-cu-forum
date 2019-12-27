@extends('frontend.app')

@section('title', 'Sign in')

@section('content')
<section>
    <div class="container mt-5 mb-5">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        <div class="col-lg-10 mx-auto">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Please enter your username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    <span class="focus-input100"></span>
                </div>
        
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <div class="form-group clearfix d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger">Log in</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
