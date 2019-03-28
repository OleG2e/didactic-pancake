@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post_all') }}
        @if (session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif
        <div class="tabs is-centered is-toggle is-toggle-rounded">
            <ul>
                <li>
                    <a href="/home">
                                <span class="icon is-small">
                                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                                </span>
                        <span>Профиль</span>
                    </a>
                </li>
                <li>
                    <a>
                                <span class="icon is-small">
                                    <i class="fas fa-calendar-alt"
                                       aria-hidden="true"></i>
                                </span>
                        <span>Мои записи</span>
                    </a>
                </li>
                <li class="is-active">
                    <a href="/home/posts">
                        <span class="icon is-small"><i class="far fa-file-alt" aria-hidden="true"></i></span>
                        <span>Мои объявления</span>
                    </a>
                </li>
            </ul>
        </div>
        <nav class="level">
            <div class="level-item level-left">
                <div class="control">
                    <p class="title">Мои объявления:</p>
                </div>
            </div>
            <div class="level-item" style="padding-bottom: 10px">
                <a class="button is-primary is-rounded" href="/posts/create">Создать объявление</a>
            </div>
        </nav>
        <div class="columns is-multiline">
            @foreach($myPosts as $post)
                <div class="column is-narrow">
                    <div class="box"
                         style="width: 250px; background-color: {{$post->relevance ? 'hsl(171, 100%, 41%)' : 'hsl(48, 100%, 67%)'}}">
                        <div class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <p class="title">{{$post->category->title}}</p>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <a class="delete modal-button" data-target="modal-bis-{{$post->id}}"></a>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="modal-bis-{{$post->id}}">
                            <div class="modal-background"></div>
                            <div class="modal-card">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">Подтверди удаление</p>
                                    <button class="delete" aria-label="close"></button>
                                </header>
                                <section class="modal-card-body">
                                    Удалить пост от {{$post->created_at}}?
                                </section>
                                <footer class="modal-card-foot">
                                    <form method="post" action="/posts/{{$post->id}}">
                                        @method('delete')
                                        @csrf
                                        <button class="button is-danger" type="submit">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                                    </span>
                                            <span>Удалить!</span>
                                        </button>
                                        <a class="button is-info">Отмена</a>
                                    </form>
                                </footer>
                            </div>
                        </div>
                        <p class="subtitle"><strong>{{$post->owner->name}}</strong>
                            <small> {{$post->created_at}}</small>
                        </p>
                        <div class="content">
                            <div class="more">{{$post->description}}</div>
                            <a href="/posts/{{$post->id}}">
                                Обсудить
                            </a>
                            <form method="post" action="/home/posts/{{$post->id}}">
                                @method('patch')
                                @csrf
                                <label class="checkbox">
                                    <input type="checkbox" name="relevance"
                                           onchange="this.form.submit()" {{$post->relevance ? 'checked' : ''}}>
                                    Показывать
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endcomponent
@endsection