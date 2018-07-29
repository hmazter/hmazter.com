@extends('_layouts.master')

@section('body')
    Posts:
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ $post->getUrl() }}">
                {{ $post->title }}
                </a>
            </li>
        @endforeach
    </ul>

    Portfolio:
    <ul>
        @foreach ($portfolio as $item)
            <li>
                <a href="{{ $item->getUrl() }}">
                {{ $item->title }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection
