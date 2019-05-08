@php
    $user = auth()->user();
$myTrips = $user->trips;
$myPosts = App\Post::where('owner_id', $user->id)->latest()->get();
$myDeliveries = App\Trip::where('owner_id', $user->id)->where('category_id', 3)->latest()->get();
@endphp
<div class="tabs is-centered is-toggle is-toggle-rounded">
    <ul>
        <li class="{{(Request::route()->getName() == 'home') ? 'is-active' : ''}}">
            <a href="{{route('home')}}">
                <span>Профиль</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'my.trips') ? 'is-active' : ''}}">
            <a href="{{route('my.trips')}}">
                <span class="has-badge-inline" data-badge="{{count($myTrips)}}">
                    Мои поездки
                </span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'my.entries') ? 'is-active' : ''}}">
            <a href="{{route('my.entries')}}">
                <span class="has-badge-inline" data-badge="{{count($myPosts)}}">
                    Мои записи
                </span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'my.posts') ? 'is-active' : ''}}">
            <a href="{{route('my.posts')}}">
                <span class="has-badge-inline" data-badge="{{count($myPosts)}}">Мои объявления</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'my.deliveries') ? 'is-active' : ''}}">
            <a href="{{route('my.deliveries')}}">
                <span class="has-badge-inline" data-badge="{{count($myDeliveries)}}">
                Мои передачки
                </span>
            </a>
        </li>
    </ul>
</div>