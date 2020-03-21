@php
    $category = \App\Helpers::currentCategory();
    $route = route('post.all', $category);
@endphp
<div class="tabs is-centered is-toggle is-toggle-rounded is-hidden-touch">
    <ul>
        <li class="{{($category === 'all') ? 'is-active' : ''}}">
            <a href="{{route('post.all', 'all')}}">
                <span class="icon is-small"><i class="fa fa-table" aria-hidden="true"></i></span>
                <span>Все</span>
            </a>
        </li>
        <li class="{{($category === 'help') ? 'is-active' : ''}}">
            <a href="{{route('post.all', 'help')}}">
                <span class="icon is-small"><i class="fa fa-hand-holding-heart" aria-hidden="true"></i></span>
                <span>Помощь</span>
            </a>
        </li>
        <li class="{{($category === 'pet') ? 'is-active' : ''}}">
            <a href="{{route('post.all', 'pet')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-paw"
                                       aria-hidden="true"></i>
                                </span>
                <span>Животные</span>
            </a>
        </li>
        <li class="{{($category === 'loss') ? 'is-active' : ''}}">
            <a href="{{route('post.all', 'loss')}}">
                <span class="icon is-small"><i class="fa fa-key" aria-hidden="true"></i></span>
                <span>Потери/находки</span>
            </a>
        </li>
        <li class="{{($category === 'buy') ? 'is-active' : ''}}">
            <a href="{{route('post.all', 'buy')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-money-bill" aria-hidden="true"></i>
                                </span>
                <span>Куплю</span>
            </a>
        </li>
        <li class="{{($category === 'sell') ? 'is-active' : ''}}">
            <a href="{{route('post.all', 'sell')}}">
                                <span class="icon is-small">
                                    <i class="fa fa-money-bill-wave"
                                       aria-hidden="true"></i>
                                </span>
                <span>Продам</span>
            </a>
        </li>
        <li class="{{($category === 'service') ? 'is-active' : ''}}">
            <a href="{{route('post.all', 'service')}}">
                <span class="icon is-small"><i class="fa fa-concierge-bell" aria-hidden="true"></i></span>
                <span>Услуги</span>
            </a>
        </li>
    </ul>
</div>