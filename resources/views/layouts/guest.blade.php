<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/custom-pagination.css') }}" rel="stylesheet">
        <link href="{{ asset('css/recommended-products.css') }}" rel="stylesheet">
        <link href="{{ asset('css/products-page.css') }}" rel="stylesheet">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://assets.ubuntu.com/v1/vanilla-framework-version-3.9.0.min.css" />
        <!-- Fonts -->
        <style>

            .product a {
                display: block;
                text-align: center;
                color: #000;
                text-decoration: none;
            }

            .product img {
                width: 100%;
                height: auto;
            }

            .header {
                background-color: #f7f7f7;
                padding: 20px;
            }

            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                max-width: 1200px;
                margin: 0 auto;
            }

            .title {
                font-size: 24px;
                font-weight: bold;
                text-decoration: none;
            }



            .search-bar input {
                height: 40px;
                width: 100%;
                border: none;
                border-radius: 20px;
                padding: 0 20px;
                font-size: 16px;
                box-shadow: 0px 0px 5px #ccc;
            }

            .header-buttons {
                display: flex;
                align-items: center;
            }

            .button {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 40px;
                background-color: #fff;
                box-shadow: 0px 0px 5px #ccc;
                margin-left: 10px;
                text-align: center;
                font-size: 16px;
                text-decoration: none;
                color: #333;
                padding: 0 10px;
            }

            .button i {
                font-size: 20px;
                margin-right: 10px;
            }


        </style>
    </head>

    <body>
        <div style="margin-left:20px" class="font-sans text-gray-900 antialiased ">
            {{ $slot }}
        </div>
    </body>
</html>
