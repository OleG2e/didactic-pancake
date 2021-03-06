<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="yandex-verification" content="ae868d3a9193d7b4"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta property="og:title" content="@yield('og:title', config('app.name'))"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="@yield('og:url', url()->current())"/>
    <meta property="og:image" content="@yield('og:image', 'images/label.jpg')"/>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=6319abd4-bea3-4ffa-8af2-8925eac4fa94&lang=ru_RU" type="text/javascript"></script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(54254332, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true
        });
    </script>
    <script type="text/javascript">
        function callbackThen(response){
            // read HTTP status
            console.log(response.status);

            // read Promise object
            response.json().then(function(data){
                console.log(data);
            });
        }
        function callbackCatch(error){
            console.error('Error:', error)
        }
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/54254332" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href=​"https://mikun.info/favicon.ico" type="image/x-icon">
    {!! htmlScriptTagJsApi([
            'action' => 'homepage',
            'callback_then' => 'callbackThen',
            'callback_catch' => 'callbackCatch'
        ]) !!}
    @csrf
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
                    <div class="navbar-link">
                        <span>Категории</span>
                    </div>
                    @php
                        if (Auth::guest()) {
                            extract(\App\Helpers::countAds());
                        } else {
                            extract(\App\Helpers::countMyAds());
                            extract(\App\Helpers::countAds());
                        }
                    @endphp
                    <ul class="menu-list">
                        <li>
                            <div class="navbar-dropdown is-right is-boxed">
                                <div class="navbar-item">
                                    <a href="{{route('post.all', 'all')}}">
                                        <span class="icon is-small"><i class="fa fa-table"
                                                                       aria-hidden="true"></i></span>
                                        <span class="has-badge-inline" data-badge="{{$all}}">Объявления</span>
                                    </a>
                                </div>
                                <ul>
                                    <li>
                                        <a href="{{route('post.all', 'help')}}">
                                            <span class="icon is-small"><i class="fa fa-hand-holding-heart"
                                                                           aria-hidden="true"></i></span>
                                            <span class="has-badge-inline" data-badge="{{$helps}}">Помощь</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('post.all', 'pet')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-paw"
                                       aria-hidden="true"></i>
                                </span>
                                            <span class="has-badge-inline" data-badge="{{$pets}}">Животные</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('post.all', 'loss')}}">
                                            <span class="icon is-small"><i class="fa fa-key"
                                                                           aria-hidden="true"></i></span>
                                            <span class="has-badge-inline" data-badge="{{$losses}}">Потери</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('post.all', 'buy')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-money-bill" aria-hidden="true"></i>
                                </span>
                                            <span class="has-badge-inline" data-badge="{{$buys}}">Куплю</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('post.all', 'sell')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-money-bill-wave"
                                       aria-hidden="true"></i>
                                </span>
                                            <span class="has-badge-inline" data-badge="{{$sells}}">Продам</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('post.all', 'service')}}">
                                            <span class="icon is-small"><i class="fa fa-concierge-bell"
                                                                           aria-hidden="true"></i></span>
                                            <span class="has-badge-inline" data-badge="{{$services}}">Услуги</span>
                                        </a>
                                    </li>
                                </ul>
                                <a class="navbar-item" href="{{route('trip.all')}}">
                                    <div>
                                      <span class="icon is-small">
                                        <i class="fa fa-car"></i>
                                      </span>
                                        <span class="has-badge-inline" data-badge="{{$trips}}">Поездки</span>
                                    </div>
                                </a>
                                <a class="navbar-item" href="{{ route('delivery.all') }}">
                                    <div>
                                      <span class="icon is-small">
                                        <i class="fa fa-cube"></i>
                                      </span>
                                        <span class="has-badge-inline" data-badge="{{$deliveries}}">Передачки</span>
                                    </div>
                                </a>
                                <a class="navbar-item" href="{{ route('bus.schedule') }}">
                                    <div>
                                      <span class="icon is-small">
                                        <i class="fa fa-bus"></i>
                                      </span>
                                        <span>Расписание</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-end">
                @guest
                    <a class="navbar-item" href="{{ route('login') }}">Войти</a>
                @else
                    <div class="navbar-item has-dropdown is-hoverable">
                        <div class="navbar-link">
                            {{ Auth::user()->username }}
                        </div>
                        <div class="navbar-dropdown is-right is-boxed">
                            <ul class="menu-list">
                                <li>
                                    <a class="navbar-item" href="{{ route('home') }}">
                                        <div>
                                            <span class="icon is-small">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <span>Мой кабинет</span>
                                        </div>
                                    </a>
                                    <ul>
                                        <li>
                                            <a class="navbar-item" href="{{route('my.trips')}}">
                                            <span class="has-badge-inline" data-badge="{{$myTrips}}">
                                               Мои поездки
                                            </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="navbar-item" href="{{route('my.posts')}}">
                                            <span class="has-badge-inline"
                                                  data-badge="{{$myPosts}}">
                                                Мои объявления
                                            </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="navbar-item" href="{{route('my.deliveries')}}">
                                            <span class="has-badge-inline" data-badge="{{$myDeliveries}}">
                                                Мои передачки
                                            </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="navbar-item" href="{{route('my.replies')}}">
                                            <span class="has-badge-inline" data-badge="{{$myReplies}}">
                                                Мои ответы
                                            </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <a class="navbar-item" href="{{ route('feedback.form') }}">
                                        <div>
                                    <span class="icon is-small">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                            <span>Написать админу</span>
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
                                            <span>Выйти</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
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
    {{--    <div id="button-up">--}}
    {{--        Наверх--}}
    {{--    </div>--}}
</div>
</body>
</html>