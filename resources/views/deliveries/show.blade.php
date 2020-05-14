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
                            <br><span>{{$delivery->startpoint->title}} - {{$delivery->endpoint->title}}</span>
                            @isset($delivery->description)<br><span>Описание: {{$delivery->description}}</span>@endisset
                            <br><span>Дата: {{\App\Helpers::dateFormat($delivery->date_time,'d.m.Y')}}</span>
                        </p>
                    </div>
                    @auth
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <a title="Связаться" class="level-item"
                                   onclick="preventDefault();$('#connect-delivery-form').submit();">
                                    <span class="icon is-small">
                                        <i class="fa fa-link"></i>
                                    </span>
                                </a>
                                @can('update', $delivery)
                                    <a title="Редактировать" class="level-item"
                                       href="{{route('delivery.edit',$delivery)}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                    </a>
                                    <a title="Удалить" class="level-item"
                                       onclick="preventDefault();$('#delete-delivery-form').submit();">
                                        <span class="icon is-small">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </a>
                                @endcan
                            </div>
                        </nav>
                    @endauth
                    @include('components.reply', ['model_name' => \App\Delivery::MODEL_NAME, 'model_id' => $delivery->id])
                </div>
            </article>
        </div>
        @include('components.links', ['model' => $delivery])
        @include('components.reply-form', ['model_name' => \App\Delivery::MODEL_NAME, 'model_id' => $delivery->id])
        <a class="button is-info is-hovered" href="{{route('delivery.all')}}">Все доставки</a>
    @endcomponent
    <form id="delete-delivery-form" method="post" action="{{route('delivery.destroy',$delivery)}}">
        @method('delete')
        @csrf
    </form>
    <form id="connect-delivery-form" method="post" action="{{route('delivery.link.request', $delivery)}}">
        @csrf
    </form>
@endsection