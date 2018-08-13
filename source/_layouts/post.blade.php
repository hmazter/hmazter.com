@extends('_layouts.master')

@section('meta')
    <meta name="description" content="{{ $page->postDescription() }}">

    <!-- Facebook/Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $page->title }} | {{ $page->site_title }}" />
    <meta property="og:description" content="{{ $page->postDescription() }}">
    <meta property="og:url" content="{{ $page->getUrl() }}" />
    <meta property="og:type" content="article" />
    <meta property="article:published_time" content="{{ date('c', $page->date) }}" />
    <meta property="article:author" content="{{ $page->author }}" />

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ $page->title }} | {{ $page->site_title }}">
    <meta itemprop="description" content="{{ $page->postDescription() }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="@hmazter">
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