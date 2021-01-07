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
    <script src="{{ asset('js/menu.js') }}" defer></script>

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
      <div id="navArea">

        <nav>
          <div class="inner">
            <ul>
              <li><a href="{{ route('event.index') }}">大会一覧</a></li>
              @if (session('event'))
                <li><a href="{{ route('event.detail', ['id' => session('event')]) }}">大会詳細</a></li>
                <li><a href="{{ route('team.index') }}">チーム</a></li>
                <li><a href="{{ route('wanted.index') }}">メンバー募集</a></li>
              @endif
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">logout</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </div>
        </nav>

        <div class="toggle_btn">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <div id="mask"></div>

        <main>
          <h4>{{ session('eventName') ?? '' }}</h4>
        </main>

      </div>
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
            <div class="container">
              <div class="row">
                <div class="col-12">
                  @yield('content')
                </div>
              </div>
            </div>
        @endif
    </div>
</body>
</html>
