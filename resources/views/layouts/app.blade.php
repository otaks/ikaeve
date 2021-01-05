<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if (session('eventName') && session('event')) {{ session('eventName') }} @else {{ config('app.name', 'Laravel') }} @endif</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/all.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    <!-- datetimepicker -->
    <link href="{{ asset('css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.js') }}" defer></script>
    <script src="{{ asset('js/jquery.datetimepicker.full.js') }}" defer></script>
</head>
<body>
    <div id="app">
      @if (!Route::is('login') && !Route::is('register') && !Route::is('home') &&
      !Route::is('password.*') && Route::currentRouteName() != '')
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                @if (session('eventName') && session('event'))
                    <a class="navbar-brand noto" href="{{ route('event.detail', ['id' => session('event')]) }}">
                        <b>{{ session('eventName') }}</b>
                    </a>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <!--
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="mr-2"><a href="{{ route('event.index') }}">大会</a></li>
                        @endauth
                        @if (session('event'))
                          <li class="mr-2"><a href="{{ route('team.index') }}">チーム</a></li>
                        @endif
                    </ul>
                  -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                      @if ($isMobile)
                          @guest
                            <li class="nav-item">
                                <a href="{{ route('event.detail', ['id' => session('event')]) }}">大会</a>
                            </li>
                          @else
                            <li class="nav-item">
                                <a href="{{ route('event.index') }}">大会</a>
                            </li>
                          @endguest
                          @if (session('event'))
                            <li class="nav-item">
                                <a href="{{ route('team.index') }}">チーム</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('wanted.index') }}">メンバー募集</a>
                            </li>
                          @endif
                          @auth
                            <li class="nav-item">
                              <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">logout</a>
                            </li>
                          @endauth
                      @else
                      @endif
                    </ul>
                </div>
            </div>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endif
    @if (Route::is('login') || Route::is('register') || Route::is('home') ||
     Route::is('password.*') || Route:: currentRouteName() == '')
      <div class="app-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-5">
                  <div class="card">
                    @yield('content')
                  </div>
                </div>
              </div>
            </div>
          </div>
        @else
          @if ($isMobile)
            <div class="container">
              <div class="row">
                <div class="col-12">
                  @yield('content')
                </div>
              </div>
            </div>
          @else
            <div class="container">
              <div class="row">
                <div class="col-2 sidemenu mt-2">
                <!-- left menu -->
                @include('layouts/menu')
                </div>
                <div class="col-10">
                  @yield('content')
                </div>
              </div>
            </div>
          @endif
        @endif
    </div>
</body>
</html>
