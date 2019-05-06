<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Laravel')</title>

    <!-- Scripts -->
    <script defer src="{{ asset('js/app.js') }}"></script>
    <script defer src="http://code.jquery.com/jquery-3.3.1.js"></script>
    <script defer src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pickadate@3.6.0/lib/compressed/picker.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pickadate@3.6.0/lib/compressed/picker.date.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pickadate@3.6.0/lib/compressed/picker.time.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pickadate@3.6.0/lib/compressed/legacy.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="has-navbar-fixed-top">
<div id="app">
    <nav class="navbar is-transparent is-fixed-top is-dark" role="navigation" aria-label="dropdown navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }} </a>
            <div id="navbar-burger-id" class="navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="navbar-menu" id="navbar-menu-id">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Категории
                    </a>
                    <div class="navbar-dropdown is-right is-boxed">
                        <a class="navbar-item" href="{{ route('post.all') }}">
                            <div>
                  <span class="icon is-small">
                    <i class="fa fa-table"></i>
                  </span>
                                Объявления
                            </div>
                        </a>
                        <a class="navbar-item" href="{{route('trip.all')}}">
                            <div>
                  <span class="icon is-small">
                    <i class="fa fa-car"></i>
                  </span>
                                Поездки
                            </div>
                        </a>
                        <a class="navbar-item" href="{{ route('delivery.all') }}">
                            <div>
                  <span class="icon is-small">
                    <i class="fa fa-cube"></i>
                  </span>
                                Передачки
                            </div>
                        </a>
                        <a class="navbar-item" href="{{ route('bus.schedule') }}">
                            <div>
                  <span class="icon is-small">
                    <i class="fa fa-bus"></i>
                  </span>
                                Расписание
                            </div>
                        </a>
                    </div>
                </div>
            </div>
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
                                    Мой кабинет
                                </div>
                            </a>
                            <a class="navbar-item" href="{{ route('feedback.form') }}">
                                <div>
                                    <span class="icon is-small">
                    <i class="fa fa-envelope"></i>
                  </span>
                                    Написать админу
                                </div>
                            </a>
                            <hr class="navbar-divider">
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
    <div id="button-up">
        Наверх
    </div>
</div>
</body>
</html>