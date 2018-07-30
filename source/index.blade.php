@extends('_layouts.master')

@section('body')
    <section class="section">
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
    </section>
@endsection
