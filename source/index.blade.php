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
@endsection
