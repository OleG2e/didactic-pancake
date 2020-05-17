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
        @auth
            <nav class="level">
                <div class="level-item level-left field is-grouped">
                    <div class="control">
                        <a class="button is-primary is-rounded" href="{{route('delivery.create')}}">Создать
                            передачку</a>
                    </div>
                </div>
            </nav>
        @endauth
        <p class="title is-size-4">Актуальные передачки:</p>
        <div class="columns is-multiline">
            @if (count($deliveries))
                @foreach($deliveries as $delivery)
                    <div class="column is-narrow is-one-quarter">
                        <div class="box">
                            <p class="title is-size-4">{{$delivery->startpoint->title}}
                                - {{$delivery->endpoint->title}}</p>
                            <p class="subtitle"><strong>{{$delivery->owner->username}}</strong>
                                <small class="is-size-6"> {{$delivery->updated_at->diffForHumans()}}</small>
                            </p>
                            <span>Дата: {{\App\Helpers::dateFormat($delivery->date_time,'d.m.Y')}}</span>
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