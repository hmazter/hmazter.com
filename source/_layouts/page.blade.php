@extends('_layouts.master')

@section('body')
    <div class="page">
        <h1 class="title">{{ $page->title }}</h1>

        <div class="content">
            @yield('content')
        </div>
    </div>
@endsection