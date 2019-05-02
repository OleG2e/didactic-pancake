<div class="tabs is-centered is-toggle is-toggle-rounded">
    <ul>
        <li class="{{(request()->getRequestUri() == '/home') ? 'is-active' : ''}}">
            <a href="/home">
                                <span class="icon is-small">
                                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                                </span>
                <span>Профиль</span>
            </a>
        </li>
        <li class="{{(request()->getRequestUri() == '/home/trips') ? 'is-active' : ''}}">
            <a href="{{route('my.trips')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-car"
                                       aria-hidden="true"></i>
                                </span>
                <span>Мои поездки</span>
            </a>
        </li>
        <li class="{{(request()->getRequestUri() == '/home/entries') ? 'is-active' : ''}}">
            <a href="{{route('my.entries')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-calendar-alt"
                                       aria-hidden="true"></i>
                                </span>
                <span>Мои записи</span>
            </a>
        </li>
        <li class="{{(request()->getRequestUri() == '/home/posts') ? 'is-active' : ''}}">
            <a href="{{route('my.posts')}}">
                <span class="icon is-small"><i class="fa fa-file-alt" aria-hidden="true"></i></span>
                <span>Мои объявления</span>
            </a>
        </li>
        <li class="{{(request()->getRequestUri() == '/home/deliveries') ? 'is-active' : ''}}">
            <a href="{{route('my.deliveries')}}">
                <span class="icon is-small"><i class="fa fa-cube" aria-hidden="true"></i></span>
                <span>Мои передачки</span>
            </a>
        </li>
    </ul>
</div>