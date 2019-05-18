<div class="tabs is-centered is-toggle is-toggle-rounded">
    <ul>
        <li class="{{(Request::route()->getName() == 'post.help') ? 'is-active' : ''}}">
            <a href="{{route('post.help')}}">
                <span class="icon is-small"><i class="fa fa-hand-holding-heart" aria-hidden="true"></i></span>
                <span>Помощь</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'post.pet') ? 'is-active' : ''}}">
            <a href="{{route('post.pet')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-paw"
                                       aria-hidden="true"></i>
                                </span>
                <span>Животные</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'post.loss') ? 'is-active' : ''}}">
            <a href="{{route('post.loss')}}">
                <span class="icon is-small"><i class="fa fa-key" aria-hidden="true"></i></span>
                <span>Потери/находки</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'post.buy') ? 'is-active' : ''}}">
            <a href="{{route('post.buy')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-money-bill" aria-hidden="true"></i>
                                </span>
                <span>Куплю</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'post.sell') ? 'is-active' : ''}}">
            <a href="{{route('post.sell')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-money-bill-wave"
                                       aria-hidden="true"></i>
                                </span>
                <span>Продам</span>
            </a>
        </li>
        <li class="{{(Request::route()->getName() == 'post.service') ? 'is-active' : ''}}">
            <a href="{{route('post.service')}}">
                <span class="icon is-small"><i class="fa fa-concierge-bell" aria-hidden="true"></i></span>
                <span>Услуги</span>
            </a>
        </li>
    </ul>
</div>