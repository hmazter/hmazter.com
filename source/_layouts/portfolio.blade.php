@extends('_layouts.master')

@section('body')
    <h1>{{ $page->title }} <small>{{ $page->date }}</small></h1>

    @yield('content')
@endsection