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
                @include('subview.home-nav')
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-128x128">
                            <img src="{{asset('/storage/avatars/'.auth()->id().'/avatar.jpg')}}">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong>{{$user->name}}</strong>
                                <small>{{$user->email}}</small>
                                <br>
                                @isset($user->link)
                                    <br>
                                    <span>Данные для связи: <br> {{$user->link}}</span>
                                @endisset
                            </p>
                        </div>
                    </div>
                </article>
                <article class="media">
                    <form method="post" action="{{route('home.store')}}">
                        @csrf
                        {{--                        <div class="field">--}}
                        {{--                            <label class="label">Данные для связи:</label>--}}
                        {{--                            <div class="control">--}}
                        {{--                                <input class="input" type="text" name="link" placeholder="Соц.профиль или номер телефона"--}}
                        {{--                                       value="{{$user->link}}">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="field">
                            <label class="label">Данные для связи:</label>
                            <div class="control">
                                <textarea class="textarea" name="link"
                                          placeholder="Соц.профиль или номер телефона">{{$user->link}}</textarea>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link">Сохранить</button>
                            </div>
                        </div>
                    </form>
                    <form method="post" action="{{route('image.upload')}}" enctype="multipart/form-data"
                          style="margin-left: 20px">
                        @csrf
                        <div class="field">
                            <label class="label">Аватар:</label>
                            <div class="control">
                                <input class="file" type="file" name="avatar" accept="image/jpeg">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link">Загрузить</button>
                            </div>
                        </div>
                    </form>
                </article>
            </article>
        </div>
    </section>
@endsection