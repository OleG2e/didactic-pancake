@extends('layouts.app')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <article class="container is-fluid box">
                {{ Breadcrumbs::render('home') }}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="tabs is-centered is-toggle is-toggle-rounded">
                    <ul>
                        <li class="is-active">
                            <a>
                                <span class="icon is-small"><i class="fas fa-image" aria-hidden="true"></i></span>
                                <span>Профиль</span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="icon is-small"><i class="fas fa-film" aria-hidden="true"></i></span>
                                <span>Videos</span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="icon is-small"><i class="far fa-file-alt" aria-hidden="true"></i></span>
                                <span>Мои объявления</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-128x128">
                            <img src="https://bulma.io/images/placeholders/128x128.png">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong>{{$user->name}}</strong>
                                <small>{{$user->email}}</small>
                                <br>
                                @isset($user->about)
                                    <span>Обо мне: <br>{{$user->about}}</span>
                                @endisset
                                @isset($user->phone)
                                    <br>
                                    <span>Номер телефона: <br> {{$user->phone}}</span>
                                @endisset
                            </p>
                        </div>
                    </div>
                </article>
                <article class="media">
                    <form method="post" action="/home">
                        @csrf
                        <div class="field">
                            <label class="label">Телефон:</label>
                            <div class="control">
                                <input class="input" type="text" name="phone" placeholder="Номер телефона"
                                       value="{{$user->phone}}">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Обо мне:</label>
                            <div class="control">
                                <textarea class="textarea" name="about"
                                          placeholder="Обо мне">{{$user->about}}</textarea>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </article>
            </article>
        </div>
    </section>
@endsection
