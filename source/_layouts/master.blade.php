<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

    <title>{{ $page->title ? $page->title . ' | hmazter.com' : 'hmazter.com' }}</title>
</head>
<body>

<section class="hero">
    <div class="hero-body">
        <div class="container">
            <a href="/"><h1 class="title">Hmazter.com</h1></a>
            <h2 class="subtitle">Web and application development</h2>
        </div>
    </div>
</section>

@include('_partials.navigation')

@yield('body')

</body>
</html>
