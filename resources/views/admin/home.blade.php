<!DOCTYPE html>
<html style="height: 100%" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="height:100%">
<div id="app" style="height:100%">
    <header class="header">
        <nav style="background-color: #d1374d" class="navbar navbar-toggleable-md navbar-light pt-0 pb-0 ">
            <a class="navbar-brand p-0 mr-5" style="font-size: 2rem; color: white" href="/"><i class="fas fa-home"></i> MONGO-SHOP</a>
            <a class="float-right" style="font-size: 2rem; color:white;" href="{{ route('admin.logout') }}"
               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"
            >
                <i class="fas fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </header>
    <admin-panel></admin-panel>
</div>
</body>
</html>