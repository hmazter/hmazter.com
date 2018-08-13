---
permalink: 404.html
---

@extends('_layouts.master')

@section('body')
    <div>
        <h1 class="title is-1">Sorry, that page does not exists</h1>
        <p class="is-size-4">
            Try the <a href="{{ $page->baseUrl }}">start page</a>,
            or the latest blog post <a href="{{ $posts->first()->getUrl() }}">{{ $posts->first()->title }}</a>
        </p>
    </div>
@endsection