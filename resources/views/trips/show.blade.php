@extends('layouts.app')
@section('title', 'Детали поездки')
@php
    $dateTime = \App\Helpers::dateFormat($trip->date_time);
@endphp
@section('og:title', "{$dateTime} {$trip->startpoint->title} - {$trip->endpoint->title}")
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip.show', $trip) }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <div class="box">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img src="{{$trip->owner->avatar()}}" alt="{{$trip->owner->username}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>{{$trip->owner->username}}</strong>
                            <small>{{$trip->updated_at->diffForHumans()}}</small>
                            @isset($trip->description)<br><span>Описание: {{$trip->description}}</span>@endisset
                            <br><span>{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</span>
                            <br><span>Дата поездки: {{$dateTime}}</span>
                            @if($trip->passengers_count)<br>
                            <span>Осталось мест: {{$trip->passengers_count}}</span>@endif
                            <br><span>Стоимость: {{$trip->price}}</span>
                        </p>
                    </div>
                    @auth
                        <nav class="level is-mobile">
                            <div class="level-left">
                                @if (count($trip->users)==false and $trip->owner->id !== auth()->id())
                                    <a title="Поеду!" class="level-item button is-primary"
                                       onclick="event.preventDefault();$('#add-user-form').submit();">
                                        Я поеду!
                                    </a>
                                @elseif(count($trip->users) and $trip->owner->id !== auth()->id())
                                    @if (count($trip->users()->where('user_id',auth()->id())->get()))
                                        <a title="Не поеду!" class="level-item button is-danger"
                                           onclick="event.preventDefault();$('#remove-user-form').submit();">
                                            Я передумал ехать!
                                        </a>
                                    @else
                                        <a title="Поеду!" class="level-item button is-primary"
                                           onclick="event.preventDefault();$('#add-user-form').submit();">
                                            Я поеду!
                                        </a>
                                    @endif
                                @endif
                                @can('update', $trip)
                                    <a title="Редактировать" class="level-item" href="{{route('trip.edit',$trip)}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                    </a>
                                    <a title="Удалить" class="level-item modal-button"
                                       data-target="modal-bis-remove-{{$trip->id}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </a>
                                    <div class="modal" id="modal-bis-remove-{{$trip->id}}">
                                        <div class="modal-background"></div>
                                        <div class="modal-card">
                                            <header class="modal-card-head">
                                                <p class="modal-card-title">Подтверди удаление</p>
                                                <button class="delete" aria-label="close"></button>
                                            </header>
                                            <section class="modal-card-body">
                                                Удалить поездку {{$trip->startpoint->title}}
                                                - {{$trip->endpoint->title}} {{$dateTime}}?
                                            </section>
                                            <footer class="modal-card-foot">
                                                <form method="post"
                                                      action="{{route('trip.destroy',$trip)}}">
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
                        <form id="add-user-form" method="post" action="{{route('trip.add.user', $trip)}}">
                            @method('patch')
                            @csrf
                        </form>
                        <form id="remove-user-form" method="post" action="{{route('trip.remove.user', $trip)}}">
                            @method('delete')
                            @csrf
                        </form>
                    @endauth
                    @include('components.reply', ['model_name' => \App\Trip::MODEL_NAME, 'model_id' => $trip->id])
                </div>
            </article>
        </div>
        @include('components.links', ['model' => $trip->replies()])
        @include('components.reply-form', ['model_name' => \App\Trip::MODEL_NAME, 'model_id' => $trip->id])
        <a class="button is-info is-hovered" href="{{route('trip.all')}}">Все поездки</a>
    @endcomponent
@endsection