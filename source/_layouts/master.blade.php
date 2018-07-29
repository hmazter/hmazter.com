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
<a href="/"><h1 class="site-header">Hmazter.com</h1></a>

@yield('body')

</body>
</html>
