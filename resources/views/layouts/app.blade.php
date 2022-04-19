<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style type="text/css">
        .sidebar li .submenu {
            list-style: none;
            margin: 0;
            padding: 0;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: var(--bs-dark);
        }

        .sidebar .nav-link:hover {
            color: var(--bs-primary);
        }
    </style>

    @livewireStyles
</head>

<body>
    <div id="app">
        @include('layouts.layouts.header')
        @auth
        @include('layouts.layouts.sidebar')

        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    @livewireScripts

</body>

</html>