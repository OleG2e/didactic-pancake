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
                                       onclick="preventDefault();$('#add-user-form').submit();">
                                        Я поеду!
                                    </a>
                                @elseif(count($trip->users) and $trip->owner->id !== auth()->id())
                                    @if (count($trip->users()->where('user_id',auth()->id())->get()))
                                        <a title="Не поеду!" class="level-item button is-danger"
                                           onclick="preventDefault();$('#add-user-form').submit();">
                                            Я передумал ехать!
                                        </a>
                                    @else
                                        <a title="Поеду!" class="level-item button is-primary"
                                           onclick="preventDefault();$('#add-user-form').submit();">
                                            Я поеду!
                                        </a>
                                    @endif
                                @endif
                                @can('update', $trip)
                                    <a class="level-item" href="{{route('trip.edit',$trip)}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                    </a>
                                    <a class="level-item" onclick="event.preventDefault();
                              document.getElementById('delete-trip-form').submit();">
                                        <span class="icon is-small">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </a>
                                @endcan
                            </div>
                        </nav>
                    @endauth
                    @include('components.reply', ['model_name' => \App\Trip::MODEL_NAME, 'model_id' => $trip->id])
                </div>
            </article>
        </div>
        @include('components.links', ['model' => $trip])
        @include('components.reply-form', ['model_name' => \App\Trip::MODEL_NAME, 'model_id' => $trip->id])
        <a class="button is-info is-hovered" href="{{route('trip.all')}}">Все поездки</a>
    @endcomponent
    <form id="delete-trip-form" method="post" action="{{route('trip.destroy',$trip)}}">
        @method('delete')
        @csrf
    </form>
    <form id="add-user-form" method="post" action="{{route('trip.add.user', $trip)}}">
        @method('patch')
        @csrf
    </form>
    <form id="remove-user-form" method="post" action="{{route('trip.remove.user', $trip)}}">
        @method('delete')
        @csrf
    </form>
@endsection