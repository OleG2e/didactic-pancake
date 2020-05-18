@extends('layouts.app')
@section('title', 'Детали передачки')
@section('og:title', 'Передачка')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.show', $delivery) }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <div class="box">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img src="{{$delivery->owner->avatar()}}" alt="{{$delivery->owner->username}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>{{$delivery->owner->username}}</strong>
                            <small>{{$delivery->updated_at->diffForHumans()}}</small>
                            @auth
                                <a title="Связаться" class="modal-button"
                                   data-target="modal-bis-connect-{{$delivery->id}}">
                                    <span class="icon is-small">
                                        <i class="fa fa-link"></i>
                                    </span>
                                </a>
                            @endauth
                            <br><span>{{$delivery->startpoint->title}} - {{$delivery->endpoint->title}}</span>
                            @isset($delivery->description)<br><span>Описание: {{$delivery->description}}</span>@endisset
                            <br><span>Дата: {{\App\Helpers::dateFormat($delivery->date_time,'d.m.Y')}}</span>
                        </p>
                    </div>
                    @auth
                        <div class="modal" id="modal-bis-connect-{{$delivery->id}}">
                            <div class="modal-background"></div>
                            <div class="modal-card">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">Связаться с {{$delivery->owner->username}}?</p>
                                    <button class="delete" aria-label="close"></button>
                                </header>
                                <section class="modal-card-body">
                                    Отправить ваши анкетные данные для связи
                                    пользователю {{$delivery->owner->username}}?
                                </section>
                                <footer class="modal-card-foot">
                                    <form method="post"
                                          action="{{route('delivery.link.request', $delivery)}}">
                                        @csrf
                                        <button class="button is-primary" type="submit">
                                            <span class="icon is-small">
                                                <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                            </span>
                                            <span>Отправить</span>
                                        </button>
                                        <a class="button is-info">Отмена</a>
                                    </form>
                                </footer>
                            </div>
                        </div>
                        @can('update', $delivery)
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    <a title="Редактировать" class="level-item"
                                       href="{{route('delivery.edit',$delivery)}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                    </a>
                                    <a title="Удалить" class="level-item modal-button"
                                       data-target="modal-bis-remove-{{$delivery->id}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </a>
                                    <div class="modal" id="modal-bis-remove-{{$delivery->id}}">
                                        <div class="modal-background"></div>
                                        <div class="modal-card">
                                            <header class="modal-card-head">
                                                <p class="modal-card-title">Подтверди удаление</p>
                                                <button class="delete" aria-label="close"></button>
                                            </header>
                                            <section class="modal-card-body">
                                                Удалить передачку {{$delivery->description}}?
                                            </section>
                                            <footer class="modal-card-foot">
                                                <form method="post"
                                                      action="{{route('delivery.destroy',$delivery)}}">
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
                                    @endcan
                                </div>
                            </nav>
                        @endauth
                        @include('components.reply', ['model_name' => \App\Delivery::MODEL_NAME, 'model_id' => $delivery->id])
                </div>
            </article>
        </div>
        @include('components.links', ['model' => $delivery->replies()])
        @include('components.reply-form', ['model_name' => \App\Delivery::MODEL_NAME, 'model_id' => $delivery->id])
        <a class="button is-info is-hovered" href="{{route('delivery.all')}}">Все доставки</a>
    @endcomponent
@endsection