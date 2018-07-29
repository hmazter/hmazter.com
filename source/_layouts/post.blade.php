@extends('_layouts.master')

@section('body')
    <section class="section post">
        <div class="container">
            <h1>{{ $page->title }}</h1>

            @yield('content')

            <p class="author">This article was posted by {{ $page->author }} at {{ $page->date }}</p>
        </div>
    </section>
@endsection