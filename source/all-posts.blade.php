@extends('_layouts.master')

@section('meta')
    <meta name="description" content="{{ $page->site_description }}">

    <!-- Facebook/Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $page->site_title }}" />
    <meta property="og:description" content="{{ $page->site_description }}" />
    <meta property="og:url" content="{{ $page->baseUrl }}" />
    <meta property="og:type" content="website" />

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ $page->site_title }}">
    <meta itemprop="description" content="{{ $page->site_description }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="@Hmazter">
@endsection

@section('body')
    <div>
        @foreach ($posts as $post)
            <div class="post mb-10">
                <p class="publish-date">{{ date('Y-m-d', $post->date) }}</p>

                <a href="{{ $post->getUrl() }}" class="has-text-dark is-size-4">
                    {{ $post->title }}
                </a>
            </div>
        @endforeach
    </div>
@endsection
