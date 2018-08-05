@extends('_layouts.master')

@section('body')
    <div class="portfolio">
        <h1 class="title">{{ $page->title }}
            <small>{{ $page->date }}</small>
        </h1>

        <div class="content">
            @yield('content')
        </div>
    </div>
@endsection