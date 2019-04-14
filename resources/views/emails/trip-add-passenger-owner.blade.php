@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-success')
        @slot('header')
            Новый пассажир к поездке в {{$trip->endpoint->title}} в {{$date->format('H:i m.d.Y')}}
        @endslot
        У вас появился новый пассажир <strong>{{$user->name}}</strong>.
        <br>Связаться с ним: {{$user->link}}
    @endcomponent
    @component('components.button', ['url' => route('trip.show', ['trips' => $trip->id]), 'type' => 'is-success'])
        Перейти к объявлению
    @endcomponent
@endsection
