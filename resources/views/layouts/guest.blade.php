<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://assets.ubuntu.com/v1/vanilla-framework-version-3.9.0.min.css" />
        <!-- Fonts -->

    </head>

    <body>
        <div style="margin-left:20px" class="font-sans text-gray-900 antialiased ">
            {{ $slot }}
        </div>
    </body>
</html>
