@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-warning')
        @slot('header')
            От поездки в {{$trip->endpoint->title}} в {{$date->format('H:i m.d.Y')}} отказался пассажир
        @endslot
        <strong>{{$user->name}}</strong> передумал ехать...
        <br>Связаться с ним и переубедить: {{$user->link}}
    @endcomponent
    @component('components.button', ['url' => route('trip.show', $trip->id), 'type' => 'is-warning'])
        Перейти к объявлению
    @endcomponent
@endsection