<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="google-site-verification" content="FG8byi9oZ_6yNU_9PSFgl-mW21rF5Bx27mDIUDQRmiA" />

    @yield('meta')

    <title>{{ $page->title ? "{$page->title} | {$page->site_title}" : $page->site_title }}</title>

    <link rel="stylesheet" href="{{ mix('css/main.css') }}">

    <link rel="alternate" type="application/rss+xml" title="hmazter.com Feed" href="{{ $page->baseUrl }}/feed.xml" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

<section class="hero">
    <div class="hero-body">
        <div class="container">
            <a href="/"><h1 class="title is-uppercase has-text-weight-bold">{{ $page->site_title }}</h1></a>
            <h2 class="subtitle">{{ $page->site_description }}</h2>
        </div>
    </div>
</section>

@include('_partials.navigation')

<section class="section">
    <div class="container">
        <div class="columns">

            <div class="column is-three-quarters">
                @yield('body')
            </div>

            <div class="column is-one-quarter">
                @include('_partials.recent-posts')
            </div>

        </div>
    </div>
</section>

@include('_partials.footer')

<script src="{{ mix('js/main.js') }}" async></script>

</body>
</html>
