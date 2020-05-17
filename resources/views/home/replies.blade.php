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
                    <p class="title is-size-4">Мои ответы:</p>
                </div>
            </div>
        </nav>
        <div class="columns is-multiline">
            @if($myReplies->count())
                @foreach($myReplies as $reply)
                    @php
                        $parent = $reply->parent($reply->model_name);
                        $routeParameters = [$reply->model_name, $parent->id, $reply];
                    @endphp
                    <div class="column is-narrow is-one-quarter">
                        <div class="box">
                            <div class="level is-mobile">
                                <div class="level-left">
                                    <div class="level-item">
                                        <p class="title is-size-5">{{$parent->category->title}}</p>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <a class="delete modal-button" data-target="modal-bis-{{$parent->id}}"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal" id="modal-bis-{{$parent->id}}">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                        <p class="modal-card-title">Подтверди удаление</p>
                                        <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Удалить ответ {{$reply->description}}?
                                    </section>
                                    <footer class="modal-card-foot">
                                        <form method="post"
                                              action="{{route('reply.destroy', $routeParameters)}}">
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
                            <p class="subtitle is-6">Дата:
                                <br>{{$reply->created_at}}</p>
                            <div class="content">
                                {{\Illuminate\Support\Str::words($reply->description, 20)}}
                                @if($parent instanceof \App\Post)
                                    <br>
                                    <a href="{{route("{$reply->model_name}.show", [$parent->category->slug, $parent])}}">
                                        Перейти к объявлению
                                    </a>
                                @else
                                    <br>
                                    <a href="{{route("{$reply->model_name}.show", $parent)}}">
                                        Перейти к объявлению
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @component('components.empty-records')
                    Ответов, размещённых вами, нет
                @endcomponent
            @endif
        </div>
    @endcomponent
@endsection