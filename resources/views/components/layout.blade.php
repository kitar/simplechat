<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ asset('/js/app.js') }}" defer></script>
  </head>
  <body class="text-gray-600">
    {{ $slot }}
  </body>
</html>
