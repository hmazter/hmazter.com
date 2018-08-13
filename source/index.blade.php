---
pagination:
    collection: posts
    perPage: 3
---
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
        @foreach ($pagination->items as $post)
            <div class="post">
                <p class="publish-date">{{ date('Y-m-d', $post->date) }}</p>

                <h1 class="title">
                    <a href="{{ $post->getUrl() }}">
                        {{ $post->title }}
                    </a>
                </h1>

                <div class="content">{!! $post->getContent() !!}</div>
            </div>
            <hr>
        @endforeach
    </div>

    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        @if ($previous = $pagination->previous)
            <a href="{{ $page->baseUrl }}{{ $previous }}" class="pagination-previous">Previous</a>
        @else
            <a class="pagination-previous" disabled>previous</a>
        @endif

        @if ($next = $pagination->next)
            <a href="{{ $page->baseUrl }}{{ $next }}" class="pagination-next">Next</a>
        @endif

        <ul class="pagination-list">
            @foreach ($pagination->pages as $pageNumber => $path)
                <li>
                    <a href="{{ $page->baseUrl }}{{ $path }}"
                       class="pagination-link  {{ $pagination->currentPage == $pageNumber ? 'is-current' : '' }}">
                        {{ $pageNumber }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endsection
