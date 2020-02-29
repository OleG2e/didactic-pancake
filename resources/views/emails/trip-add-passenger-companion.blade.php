@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-success')
        @slot('header')
            Новая поездка в {{$trip->endpoint->title}} в {{$date->format('H:i m.d.Y')}}
        @endslot
        Вы присоединились к поездке
        <br>Связаться с хозяином объявления: {{$trip->owner->link}}
    @endcomponent
    @component('components.button', ['url' => route('trip.show', $trip->id), 'type' => 'is-success'])
        Перейти к объявлению
    @endcomponent
@endsection