@extends('_layouts.master')

@section('body')
    <h1>{{ $page->title }}</h1>

    @yield('content')

    <p>Posted by {{ $page->author }} at {{ $page->date }}</p>
@endsection