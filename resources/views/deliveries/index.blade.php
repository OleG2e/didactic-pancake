@extends('layouts.app')
@section('title', 'Актуальные передачки')
@section('og:title', 'Актуальные передачки')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.all') }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <nav class="level">
            <div class="level-item level-left field is-grouped">
                @auth
                    <div class="control">
                        <a class="button is-primary is-rounded" href="{{route('delivery.create')}}">Создать
                            передачку</a>
                    </div>
                @endauth
            </div>
        </nav>
        <h4 class="title is-size-4">Актуальные передачки:</h4>
        <div class="columns is-multiline">
            @if (count($deliveries))
                @foreach($deliveries as $delivery)
                    <div class="column is-narrow">
                        <div class="box" style="width: 250px">
                            <h4 class="title is-size-4">{{$delivery->startpoint->title}} - {{$delivery->endpoint->title}}</h4>
                            <p class="subtitle"><strong>{{$delivery->owner->name}}</strong>
                                <small> {{$delivery->updated_at->diffForHumans()}}</small>
                            </p>
                            @php
                                $timestamp = new DateTime($delivery->timestamp);
                            @endphp
                            <span> Дата: {{$timestamp->format('d.m.Y')}}</span>
                            <br><span>Описание: {{$delivery->description}}</span>
                            <br><a href="{{route('delivery.show', $delivery)}}">
                                Посмотреть
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                @component('components.empty-records')
                    Передачек нет
                @endcomponent
            @endif
        </div>
    @endcomponent
@endsection