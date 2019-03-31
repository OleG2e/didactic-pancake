<div class="tabs is-centered is-toggle is-toggle-rounded">
    <ul>
        <li class="{{(request()->getRequestUri() == '/home') ? 'is-active' : ''}}">
            <a href="/home">
                                <span class="icon is-small">
                                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                                </span>
                <span>Профиль</span>
            </a>
        </li>
        <li class="{{(request()->getRequestUri() == '/home/trips') ? 'is-active' : ''}}">
            <a href="{{route('my.trips')}}">
                                <span class="icon is-small">
                                    <i class="fas fa-car"
                                       aria-hidden="true"></i>
                                </span>
                <span>Мои поездки</span>
            </a>
        </li>
        <li class="{{(request()->getRequestUri() == '/home/entries') ? 'is-active' : ''}}">
            <a href="{{route('my.entries')}}">
                                <span class="icon is-small">
                                    <i class="fas fa-calendar-alt"
                                       aria-hidden="true"></i>
                                </span>
                <span>Мои записи</span>
            </a>
        </li>
        <li class="{{(request()->getRequestUri() == '/home/posts') ? 'is-active' : ''}}">
            <a href="{{route('my.posts')}}">
                <span class="icon is-small"><i class="far fa-file-alt" aria-hidden="true"></i></span>
                <span>Мои объявления</span>
            </a>
        </li>
    </ul>
</div>