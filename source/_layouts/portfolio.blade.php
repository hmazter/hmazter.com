@extends('_layouts.master')

@section('body')

    <section class="section portfolio">
        <div class="container content">
            <h1>{{ $page->title }}
                <small>{{ $page->date }}</small>
            </h1>

            @yield('content')
        </div>
    </section>
@endsection