@extends('_layouts.master')

@section('body')
    <section class="section page">
        <div class="container">
            <h1>{{ $page->title }}</h1>

            @yield('content')
        </div>
    </section>
@endsection