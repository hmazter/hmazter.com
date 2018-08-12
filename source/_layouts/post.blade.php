@extends('_layouts.master')

@section('meta')
    <meta property="og:title" content="{{ $page->title }} | hmazter.com" />
    <meta property="og:url" content="{{ $page->getUrl() }}" />
    <meta property="og:type" content="article" />
    <meta property="article:published_time" content="{{ date('c', $page->date) }}" />
    <meta property="article:author" content="{{ $page->author }}" />

    <meta itemprop="name" content="{{ $page->title }} | hmazter.com">
@endsection

@section('body')
    <div class="post">
        <p class="publish-date">{{ date('Y-m-d', $page->date) }}</p>

        <h1 class="title">{{ $page->title }}</h1>

        <div class="content">
        @yield('content')
        </div>

        @if ($page->getNext())
            <p>
                Read something more:
                <a href="{{ $page->getNext()->getPath() }}">{{ $page->getNext()->title }}</a>
            </p>
        @endif
    </div>
@endsection