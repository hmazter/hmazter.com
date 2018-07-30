@extends('_layouts.master')

@section('body')
    <div class="content post">
        <h1>{{ $page->title }}</h1>

        @yield('content')

        <p class="author">This article was posted by {{ $page->author }} at {{ $page->date }}</p>
    </div>
@endsection