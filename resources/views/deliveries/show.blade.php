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
                        <img src="{{$delivery->owner->avatar()}}" alt="{{$delivery->owner->name}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <div style="white-space:pre-line">
                            <strong>{{$delivery->owner->name}}</strong>
                            <small>{{$delivery->updated_at->diffForHumans()}}</small>
                            <br><span>{{$delivery->startpoint->title}} - {{$delivery->endpoint->title}}</span>
                            @isset($delivery->description)<br><span>Описание: {{$delivery->description}}</span>@endisset
                            <br><span>Дата: {{$dateTime->format('d.m.Y')}}</span>
                            @auth
                                <form method="post" action="{{route('delivery.link.request', $delivery)}}">
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
                    @can('update', $delivery)
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <div class="buttons are-small">
                                    <a class="button" href="{{route('delivery.edit',$delivery)}}">
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
                    @include('components.reply', ['model_name' => \App\Delivery::MODEL_NAME, 'model_id' => $delivery->id])
                </div>
            </article>
            @include('components.reply-form', ['model_name' => \App\Delivery::MODEL_NAME, 'model_id' => $delivery->id])
            <br>
            <a class="button is-info is-hovered" href="{{route('delivery.all')}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-delivery-form" method="post" action="{{route('delivery.destroy',$delivery)}}">
        @method('delete')
        @csrf
    </form>
@endsection