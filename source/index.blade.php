@extends('_layouts.master')

@section('body')
    <h2>Posts</h2>
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
