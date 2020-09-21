@extends('satu.layouts')

@php
    $imoticon = ['😀', '😂', '👌', '❤️', '😍', '🔥', '⚡️', '🚀', '🌄', '❤️', '💚', '💕', '💓', '💖', '🟢', '🔴', '✅', '💰', '💎', '🩸', '⛺️', '🥇', '🥉', '🏆', '🎨', '🎯', '🏅', '🥈', '🌈'];
    $imoticon = collect($imoticon)->shuffle()->take(5)->implode('');
@endphp

@section('head')
    <title>{{ $site_name }} {{ $imoticon }} Instagram hashtag Photos & Videos</title>
    <meta name="description" content="Discover the most popular Instagram users, hashtags, posts and stories anonymously. Analyze your Instagram account deeply with our unique profile statistics.">
@endsection

@section('content')

    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center border-bottom">
        <a class="navbar-brand" href="index.html">{{ $site_name }}</a>
    </nav>

    <div class="container py-5">
        <div class="text-center">
            <h2>Trending Hashtags</h2>
            <div class="mt-4">
                <ul class="list-inline">
                    @foreach (collect($all_files)->shuffle() as $item)
                        <li class="list-inline-item py-1 px-2 rounded bg-light mb-3 border">
                            <a href="{{ str_replace('.srz.php', '', $item) }}.html">#{{ str_replace('.srz.php', '', $item) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- <div class="bg-light">
        <div class="container py-5">
            <div class="row">
                <div class="col-12 mb-4 text-center">
                    <h2>Popular Posts</h2>
                </div>
                @foreach($file as $i => $data)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $data['image'] }}" class="card-img-top" alt="{{ $data['caption'] }}">
                            <div class="card-body">
                                <p class="card-text small text-muted" style="max-height: 5rem; overflow: auto;">{{ $data['caption'] }}</p>
                            </div>
                        </div>
                    </div>
                    @if($i % 6 == 0)
                        <div class="col-md-4 mb-3">
                            <!--ads/responsive-->
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div> --}}

    <footer class="footer border-top bg-light py-3">
        <div class="container">
            <ul class="list-inline m-0 text-center">
                @foreach($pages as $page)
                    <li class="list-inline-item">
                        <a class="text-muted" href="{{ $page . '.html' }}">{{ ucwords(str_replace('-', ' ', $page)) }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </footer>
@endsection
