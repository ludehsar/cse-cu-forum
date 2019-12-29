@extends('frontend.app')

@section('title', 'Create a new post')

@section('content')

<!-- Main Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 mx-auto">
                <div class="clearfix">
                    <div id="showPostForm" data-post-id="{{ (isset($postId)) ? $postId : -1 }}"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
    