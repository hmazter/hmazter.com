@extends('_layouts.master')

@section('body')
    <div class="content page">
        <h1>{{ $page->title }}</h1>

        @yield('content')
    </div>
@endsection