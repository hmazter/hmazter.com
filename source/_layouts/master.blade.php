<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="google-site-verification" content="FG8byi9oZ_6yNU_9PSFgl-mW21rF5Bx27mDIUDQRmiA" />

    @yield('meta')

    <title>{{ $page->title ? $page->title . ' | hmazter.com' : 'hmazter.com' }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
</head>
<body>

<section class="hero">
    <div class="hero-body">
        <div class="container">
            <a href="/"><h1 class="title is-uppercase has-text-weight-bold">Hmazter.com</h1></a>
            <h2 class="subtitle">Web and application development</h2>
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


<script src="{{ mix('js/main.js', 'assets/build') }}" async></script>

</body>
</html>
