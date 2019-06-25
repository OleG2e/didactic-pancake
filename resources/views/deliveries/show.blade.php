@extends('layouts.app')
@section('title', 'Детали передачки')
@section('og:title', 'Передачка')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.show', $trip) }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <div class="box">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img src="{{$trip->owner->avatar()}}" alt="{{$trip->owner->name}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        @php
                            $dateTime = new DateTime($trip->date_time);
                        @endphp
                        <div style="white-space:pre-line">
                            <strong>{{$trip->owner->name}}</strong>
                            <small>{{$trip->updated_at->diffForHumans()}}</small>
                            <br><span>{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</span>
                            @isset($trip->description)<br><span>Описание: {{$trip->description}}</span>@endisset
                            <br><span>Дата: {{$dateTime->format('d.m.Y')}}</span>
                            @auth
                                <form method="post" action="{{route('delivery.link.request', $trip)}}">
                                    @csrf
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" title="Связаться" class="button is-small">
                                            <span class="icon is-small">
                                                <i class="fa fa-link"></i>
                                            </span>
                                                <span>Связаться</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endauth
                        </div>
                    </div>
                    @can('update', $trip)
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <div class="buttons are-small">
                                    <a class="button" href="{{route('delivery.edit',$trip)}}">
                                    <span class="icon is-small">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                    </a>
                                    <a class="button" onclick="event.preventDefault();
                                        document.getElementById('delete-delivery-form').submit();">
                                    <span class="icon is-small">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                    </a>
                                </div>
                            </div>
                        </nav>
                    @endcan
                    @include('components.reply', ['post'=> $trip])
                </div>
            </article>
            @include('components.reply-form', ['post' => $trip])
            <br>
            <a class="button is-info is-hovered" href="{{route('delivery.all')}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-delivery-form" method="post" action="{{route('delivery.destroy',$trip)}}">
        @method('delete')
        @csrf
    </form>
@endsection