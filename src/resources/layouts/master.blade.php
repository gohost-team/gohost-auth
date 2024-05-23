<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:title" content="GoHost" />

    <title>GoHost</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:200,300,400,500,600,700,800,900,200i,300i,400i" rel="stylesheet" />

    <!-- Scripts -->
    @yield(['resources/css/app.css',
            'resources/js/app.js',
            'resources/scss/app.scss'])
  </head>
  <body>
    @section('content')
  </body>
</html>
 