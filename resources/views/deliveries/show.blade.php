@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.show', $trip) }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
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
                        <p style="word-wrap: break-word;">
                            <strong>{{$trip->owner->name}}</strong>
                            <small>{{$trip->updated_at->diffForHumans()}}</small>
                            @auth
                                <a title="Связаться" class="button is-small"
                                   href="{{route('delivery.link.request', $trip)}}">
                                    <span class="icon is-small">
                                        <i class="fa fa-link"></i>
                                    </span>
                                </a>
                            @endauth
                            <br>
                            <span>{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</span>
                            @isset($trip->description)<br> Описание: {{$trip->description}}@endisset
                            <br>Дата: {{$dateTime->format('d.m.Y')}}
                        </p>
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
                    @include('subview.reply', ['post'=> $trip])
                </div>
            </article>
            @include('subview.reply-form', ['post' => $trip])
            <br>
            <a class="button is-info is-hovered" href="{{route('delivery.all')}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-delivery-form" method="post" action="{{route('delivery.destroy',$trip)}}">
        @method('delete')
        @csrf
    </form>
@endsection