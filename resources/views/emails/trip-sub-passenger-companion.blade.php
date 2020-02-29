@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-warning')
        @slot('header')
            Вы отказались от поездки в {{$trip->endpoint->title}} в {{$date->format('H:i m.d.Y')}}
        @endslot
        Если передумаете, то перейдите по ссылке ниже
    @endcomponent
    @component('components.button', ['url' => route('trip.show', $trip->id), 'type' => 'is-warning'])
        Перейти к объявлению
    @endcomponent
@endsection