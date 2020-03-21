@php
    extract(\App\Helpers::countMyAds());
@endphp
<div class="tabs is-centered is-toggle is-toggle-rounded is-hidden-touch">
    <ul>
        <li class="{{(Request::route()->getName() == 'home') ? 'is-active' : ''}}">
            <a href="{{route('home')}}">
                <span>Профиль</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'my.trips') ? 'is-active' : ''}}">
            <a href="{{route('my.trips')}}">
                <span class="has-badge-inline" data-badge="{{$myTrips}}">
                    Мои поездки
                </span>
            </a>
        </li>
        {{--        <li class="{{(Request::route()->getName() == 'my.entries') ? 'is-active' : ''}}">--}}
        {{--            <a href="{{route('my.entries')}}">--}}
        {{--                <span class="has-badge-inline" data-badge="{{count($myPosts)}}">--}}
        {{--                    Мои записи--}}
        {{--                </span>--}}
        {{--            </a>--}}
        {{--        </li>--}}
        <li class="{{(Request::route()->getName() == 'my.posts') ? 'is-active' : ''}}">
            <a href="{{route('my.posts')}}">
                <span class="has-badge-inline" data-badge="{{$myPosts}}">Мои объявления</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'my.deliveries') ? 'is-active' : ''}}">
            <a href="{{route('my.deliveries')}}">
                <span class="has-badge-inline" data-badge="{{$myDeliveries}}">
                Мои передачки
                </span>
            </a>
        </li>
    </ul>
</div>