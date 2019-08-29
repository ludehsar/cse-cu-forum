@extends('frontend.app')

@section('title', 'Home')

@section('content')
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('frontend/img/home-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>CSE CU Forum</h1>
                        <span class="subheading text-capitalize">Inspire the future and lead the generation</span>
                        <button class="btn btn-outline-light m-4">Launch Admin Panel</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-10 mx-auto">
                <div class="clearfix">
                    <a class="btn btn-primary float-right" href="#">Create New Post</a>
                </div>
                <div class="post-preview">
                    <a href="post.html">
                        <h2 class="post-title">
                            Man must explore, and this is exploration at its greatest
                        </h2>
                        <h3 class="post-subtitle">
                            Problems look mighty small from 150 miles up
                        </h3>
                    </a>
                    <p class="post-meta">Posted by
                        <a href="#">Start Bootstrap</a>
                        on September 24, 2019
                    </p>
                </div>
                <hr>

                <!-- Pager -->
                <div class="clearfix">
                    <a class="btn btn-primary float-left" href="#">&larr; Previous Posts</a>
                    <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
                </div>
            </div>
        </div>
    </div>
@endsection
