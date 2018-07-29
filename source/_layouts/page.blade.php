@extends('_layouts.master')

@section('body')
    <section class="section page">
        <div class="container content">
            <h1>{{ $page->title }}</h1>

            @yield('content')
        </div>
    </section>
@endsection