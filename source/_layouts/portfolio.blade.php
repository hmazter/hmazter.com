@extends('_layouts.master')

@section('body')

    <section class="section portfolio">
        <div class="container">
            <h1>{{ $page->title }}
                <small>{{ $page->date }}</small>
            </h1>

            @yield('content')
        </div>
    </section>
@endsection