@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('home') }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('subview.home-nav')
        <article class="media">
            <figure class="media-left">
                <p class="image is-128x128">
                    <img src="{{Auth::user()->avatar()}}">
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
        <div class="media">
            <div class="columns">
                <div class="column is-narrow">
                    <form method="post" action="{{route('home.store')}}">
                        @csrf
                        <div class="field">
                            <label class="label">Данные для связи:</label>
                            <div class="control">
                                <textarea class="textarea" name="link"
                                          placeholder="Соц.профиль или номер телефона">{{$user->link}}</textarea>
                            </div>
                            @if ($errors->has('link'))
                                <p class="help is-danger">{{ $errors->first('link') }}</p>
                            @endif
                        </div>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="column">
                    <form method="post" action="{{route('home.image.upload')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="field">
                            <label class="label">Аватар:</label>
                            <div class="control">
                                <input class="file" type="file" name="avatar" accept="image/jpeg">
                            </div>
                            @if ($errors->has('avatar'))
                                <p class="help is-danger">{{ $errors->first('avatar') }}</p>
                            @endif
                        </div>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link">Загрузить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcomponent
@endsection