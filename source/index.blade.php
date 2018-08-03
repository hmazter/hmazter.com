---
pagination:
    collection: posts
    perPage: 3
---
@extends('_layouts.master')

@section('body')
    <div>
        @foreach ($pagination->items as $post)
            <div class="content post">
                <h1>{{ $post->title }}</h1>

                <div>{!! $post->getContent() !!}</div>

                <p class="author">This article was posted by {{ $post->author }} at {{ $post->date }}</p>
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
