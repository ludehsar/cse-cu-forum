@extends('frontend.app')

@section('title', $postTitle)

@section('content')
<section>
    <div class="container">
        <div id="showPost" data-post-id="{{ $postId }}"></div>
    </div>
</section>
@endsection
