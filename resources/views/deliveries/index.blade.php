@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.all') }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
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
        <div class="title">Актуальные передачки:</div>
        <div class="columns is-multiline">
            @if (count($deliveries))
                @foreach($deliveries as $trip)
                    <div class="column is-narrow">
                        <div class="box" style="width: 250px">
                            <p class="title">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</p>
                            <p class="subtitle"><strong>{{$trip->owner->name}}</strong>
                                <small> {{$trip->updated_at->diffForHumans()}}</small>
                            </p>
                            @php
                                $dateTime = new DateTime($trip->date_time);
                            @endphp
                            Описание: {{$trip->description}}
                            <br>
                            <span> Дата: {{$dateTime->format('d.m.Y')}}
                                    <a href="{{route('delivery.show', $trip)}}">
                                        Посмотреть
                                    </a>
                                </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="container">
                    <div class="notification has-text-centered">
                        <span class="is-center">Объявлений пока что нет...</span>
                    </div>
                </div>
            @endif
        </div>
    @endcomponent
@endsection