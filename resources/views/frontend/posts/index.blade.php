@extends('frontend.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section-->
<section style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(/frontend/img/hero.jpg); background-size: cover; background-position: center center" class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1>CSECU Forum - Freedom of speech</a>
            </div>
        </div>
        <a href=".featured-posts" class="continue link-scroll"><i class="fa fa-long-arrow-down"></i> Scroll Down</a>
    </div>
</section>
@auth
    @if (Auth::user()->is_verified)
    <div class="container clearfix mt-5">
        <a class="btn btn-danger float-right p-3" href="{{ route('post.create') }}">Create new post</a>
    </div>
    @endif
@endauth
<section class="featured-posts">
    <div id="homepage"></div>
</section>
@endsection
    