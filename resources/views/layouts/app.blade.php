<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Laravel')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">

</head>
<body class="has-navbar-fixed-top">
<nav class="navbar is-transparent is-fixed-top is-dark" role="navigation" aria-label="dropdown navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }} </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-end">
            @guest
                <a class="navbar-item" href="{{ route('login') }}">Войти</a>
            @else
                <div class="navbar-item has-dropdown is-hoverable">
                    <div class="navbar-link">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="navbar-dropdown is-right is-boxed">
                        <a class="navbar-item" href="{{ route('home') }}">
                            <div>
                  <span class="icon is-small">
                    <i class="fa fa-user"></i>
                  </span>
                                Кабинет
                            </div>
                        </a>
                        <a class="navbar-item">
                            <div>
                  <span class="icon is-small">
                    <i class="fa fa-bug"></i>
                  </span>
                                Report bug
                            </div>
                        </a>
                        <a class="navbar-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <div>
                  <span class="icon is-small">
                    <i class="fa fa-sign-out-alt"></i>
                  </span>
                                Выйти
                            </div>
                        </a>
                    </div>
                </div>
        </div>
        @endguest
    </div>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">
    @csrf
</form>
@yield('content')
</body>
</html>
