@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.all') }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('subview.home-nav')
        <nav class="level">
            <div class="level-item level-left">
                <div class="control">
                    <p class="title">Мои объявления:</p>
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
                            <p class="subtitle"><strong>{{$post->owner->name}}</strong>
                                <small> {{$post->created_at}}</small>
                            </p>
                            <div class="content">
                                <div class="more">{{$post->description}}</div>
                                <a href="{{route('post.show', $post)}}">
                                    Обсудить
                                </a>
                                <form method="post" action="{{route('update.relevance.post', $post)}}">
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
            @else
                @component('components.empty-records')
                    Объявлений, размещённых вами, нет
                @endcomponent
            @endif
        </div>
    @endcomponent
@endsection