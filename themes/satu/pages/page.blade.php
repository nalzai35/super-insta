@extends('satu.layouts')

@section('head')
<title>{{ ucwords(str_replace('-', ' ', $page)) }}</title>
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center border-bottom">
        <a class="navbar-brand" href="index.html">{{ $site_name }}</a>
    </nav>
	<div class="container py-5">
        @include('satu.pages.' . $page)
    </div>
@endsection
