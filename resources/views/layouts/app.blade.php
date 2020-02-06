<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--  Scripts  -->
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'signedIn' => auth()->check(),
            'user' => Auth::user(),
        ]) !!};
    </script>
    <style>
        body { padding-bottom: 100px; }
        .level { display: flex; align-items: center; }
        .flex { flex: 1; }
        .level-item { margin-right: 1em; }
        .ml-a { margin-left: auto; }
        [v-cloak] { display: none; }
        .ais-highlight > em { background: yellow; font-style: normal; }
        input.ais-refinement-list__checkbox { margin-right: .4em; }
    </style>

    @yield('head')
</head>
<body class="@yield('bodyClass')">
    <div id="app">
        @yield('body')

        <flash message="{{ session('flash') }}"></flash>
    </div>

    <!-- Svg sprite -->
    {!! file_get_contents(asset('images/svg-sprite/sprite.svg')) !!}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @yield('scripts')
</body>
</html>
