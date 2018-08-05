@extends('_layouts.master')

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