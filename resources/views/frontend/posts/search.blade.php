@extends('frontend.app')

@section('title', 'Posts')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <main class="posts-listing col-lg-8">
                    <div class="widget search">
                        <header>
                            <h3 class="h6">Search</h3>
                        </header>
                        <form action="{{ route('search') }}" method="get" class="search-form">
                            <div class="form-group">
                                <input type="search" name="search" placeholder="What are you looking for?" value="{{ request()->search }}" />
                                <button type="submit" class="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <section class="featured-posts no-padding-top">
                        <div class="container">
                            @foreach ($frontendPosts as $post)
                                <div class="row d-flex align-items-stretch">
                                    <div class="text w-100">
                                        <div class="text-inner d-flex align-items-center">
                                            <div class="content">
                                                <header class="post-header">
                                                    <a href="{{ '/posts/' . $post->slug }}"><h2 class="h4">{{ $post->title}}</h2></a>
                                                </header>
                                                <p>{{ $post->subtitle }}</p>
                                                <footer class="post-footer d-flex align-items-center">
                                                    <div class="date"><i class="icon-clock"></i> {{ $post->created_at->diffForHumans() }}</div>
                                                    <div class="contributions"> <i class="fab fa-cuttlefish"></i> {{ $post->total_contribution }} contribuions</div>
                                                    <div class="love"><i class="far fa-grin-hearts"></i> {{ $post->total_love }}</div>
                                                    <div class="wow"><i class="far fa-grin-stars"></i> {{ $post->total_wow }}</div>
                                                    <div class="haha"><i class="far fa-laugh-squint"></i> {{ $post->total_haha }}</div>
                                                    <div class="angry"><i class="far fa-angry"></i> {{ $post->total_angry }}</div>
                                                </footer>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center mt-3">
                                {{ $frontendPosts->appends(['search' => request('search')])->links() }}
                            </div>
                        </div>
                    </section>
                </main>
                <aside class="col-lg-4">
                    <div class="widget categories">
                        <header>
                            <h3 class="h6">Categories</h3>
                        </header>
                        @foreach ($categories as $category)
                            <div class="item d-flex justify-content-between"><a href="{{ '/posts?search=' . $category->slug }}">{{ $category->name }}</a></div>
                        @endforeach
                    </div>
                    <div class="widget tags">       
                        <header>
                            <h3 class="h6">Tags</h3>
                        </header>
                        <ul class="list-inline">
                            @foreach ($tags as $tag)
                                <li class="list-inline-item"><a href="{{ '/posts?search=' . $tag->slug }}" class="tag"># {{ $tag->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
