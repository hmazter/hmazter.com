@extends('_layouts.master')

@section('body')
    <section class="section">
        <div class="container">
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
        </div>
    </section>
@endsection
