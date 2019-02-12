<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <header>
        <!-- TOP HEADER -->
        <div id="top-header">
            <div class="container">
                <ul class="header-links">
                    <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                    <li><a href="#"><i class="fas fa-at"></i> email@email.com</a></li>

                    @guest
                        @if (Route::has('register'))
                            <li class="float-right ml-4">
                                <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> {{ __('Register') }}</a>
                            </li>
                        @endif
                        <li class="float-right">
                            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown float-right">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user"></i>
                                {{ (Auth::user()->name) ? Auth::user()->name : "Admin" }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" style="background-color: black" aria-labelledby="navbarDropdown">
                                @auth
                                    <a class="dropdown-item" href="/shoppingcart">
                                        <i class="fas fa-shopping-cart"></i>
                                        {{ __('Shopping Cart') }}
                                    </a>
                                    <a class="dropdown-item" href="/orders">
                                            <i class="far fa-list-alt"></i>
                                            {{ __('Orders') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endauth

                            </div>
                        </li>
                    @endguest
                </ul>


            </div>
        </div>
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="/" class="logo">
                                <img style="max-height: 4rem" src="http://pluspng.com/img-png/logo-mongodb-png--1756.png" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    @if(isset($mainCategories) && !empty($mainCategories))
                        <search-bar :category="{{ $mainCategories[0] }}"></search-bar>
                    @else
                        <search-bar></search-bar>
                    @endif
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">
                            <!-- Wishlist -->
                            @auth()
                                <wish-list></wish-list>
                            @endauth
                            <!-- /Wishlist -->

                            <!-- Cart -->
                            <shopping-cart></shopping-cart>
                            <!-- /Cart -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>

    <nav id="navigation" class="navbar navbar-expand-md navbar-light navbar-laravel">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <li class="nav-item nav-link"><a class="navitemlink" href="/">Home</a></li>
                    <li class="nav-item nav-link dropdown">
                        <a class="navitemlink" id="dropdownMenuLink" data-toggle="dropdown" href="#" >Categories</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach($mainCategories as $c)
                                <a class="dropdown-item" href="/categories/{{ $c->id }}">{{ $c->name }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>

    {{--Putanja do kategorije/proizvoda--}}
    {{--Treba jos jedan if da se ispita da li je proizvod ili kategorija--}}
    @if(isset($path))
    <nav class="navbar-expand-md navbar-laravel border-bottom">
        <ul class="nav navbar-nav">
            <li><a class="nav-link navitemlink" href="/">Home</a></li>
            @foreach($path as $item)
                <li class="nav-link"><i class="fas fa-arrow-right"></i></li>
                <li><a class="nav-link navitemlink" href="/categories/{{ $item['id'] }}">{{ $item['name'] }}</a></li>
            @endforeach

            @if(isset($product))
                {{-- Ako je show za proizvod --}}
                <li class="nav-link"><i class="fas fa-arrow-right"></i></li>
                <li><a class="nav-link navitemlink" href="/categories/{{ $product->category->id }}">{{ $product->category->name }}</a></li>
                <li class="nav-link"><i class="fas fa-arrow-right"></i></li>
                <li><a class="nav-link font-weight-bold navitemlink" href="#">{{ $product->name }}</a></li>
            @elseif(isset($category))
                {{-- Ako je show za kategoriju --}}
                <li class="nav-link"><i class="fas fa-arrow-right"></i></li>
                <li><a class="nav-link font-weight-bold navitemlink" href="#">{{ $category->name }}</a></li>
            @endif
        </ul>
    </nav>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer id="footer">
        <!-- top footer -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="#">Hot deals</a></li>
                                <li><a href="#">Laptops</a></li>
                                <li><a href="#">Smartphones</a></li>
                                <li><a href="#">Cameras</a></li>
                                <li><a href="#">Accessories</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix visible-xs"></div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Information</h3>
                            <ul class="footer-links">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Orders and Returns</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Track My Order</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /top footer -->
    </footer>
</div>
</body>
</html>
