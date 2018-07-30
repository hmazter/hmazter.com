@extends('_layouts.master')

@section('body')
    <div class="content portfolio">
        <h1>{{ $page->title }}
            <small>{{ $page->date }}</small>
        </h1>

        @yield('content')
    </div>
@endsection