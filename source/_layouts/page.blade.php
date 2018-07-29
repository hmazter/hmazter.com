@extends('_layouts.master')

@section('body')
    <h1>{{ $page->title }}</h1>

    @yield('content')
@endsection