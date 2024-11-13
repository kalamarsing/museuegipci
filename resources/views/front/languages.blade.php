<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/sass/front.scss', 'resources/js/app.jsx'])
        @include('layouts.includes.jconst')

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main class="main-bk-image">
                <div class="content-wrapper">
                    <div class="languages">
                        @foreach ($languages as $lang)
                        
                            <a href="{{$lang->iso}}/enter-code" class="square">{{$lang->iso}}</a>
                        @endforeach

                    </div>
                    <div class="image-container">
                        <img 
                            src="/storage/images/logo_museu_portada.png" 
                            srcset="
                                /storage/images/logo_museu_portada.png 1x, 
                                /storage/images/logo_museu_portada@2x.png 2x, 
                                /storage/images/logo_museu_portada@3x.png 3x, 
                                /storage/images/logo_museu_portada@4x.png 4x" 
                            alt="Descripción de la imagen" 
                        >
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
