@extends('frontend.app')

@section('title', $name)

@section('content')
<section>
    <div class="container">
        <div id="settings" data-user-id="{{ $userId }}"></div>
    </div>
</section>
@endsection
