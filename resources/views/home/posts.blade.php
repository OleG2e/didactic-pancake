@extends('layouts.app')
@section('title', 'Мои объявления')
@section('og:title', 'Мои объявления')
@section('content')
    @component('components.hero')
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('components.home-nav')
        <nav class="level">
            <div class="level-item level-left">
                <div class="control">
                    <h4 class="title is-size-4">Мои объявления:</h4>
                </div>
            </div>
            <div class="level-item" style="padding-bottom: 10px">
                <a class="button is-primary is-rounded" href="{{route('post.create')}}">Создать объявление</a>
            </div>
        </nav>
        <div class="columns is-multiline">
            @if(count($myPosts))
                @foreach($myPosts as $post)
                    <div class="column is-narrow">
                        <div class="box">
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <h4 class="title is-size-4">{{$post->category->title}}</h4>
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
                                        <form method="post" action="{{route('post.destroy', $post)}}">
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
                            <h6 class="subtitle is-6">Дата:
                                <br>{{$post->created_at}}</h6>
                            <div class="content">
                                <div class="more">{{$post->description}}</div>
                                <a href="{{route('post.show', $post)}}">
                                    Обсудить
                                </a>
                                <form method="post" action="{{route('update.relevance.post', $post)}}">
                                    @method('patch')
                                    @csrf
                                    <div class="field">
                                        <input id="switch-{{$post->id}}" type="checkbox" name="relevance" class="switch"
                                               onchange="this.form.submit()" {{$post->relevance ? 'checked' : ''}}>
                                        <label for="switch-{{$post->id}}">Показ</label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @component('components.empty-records')
                    Объявлений, размещённых вами, нет
                @endcomponent
            @endif
        </div>
    @endcomponent
@endsection