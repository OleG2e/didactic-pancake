@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-success')
        @slot('header')
            Поездка опубликована
        @endslot
        Ваша поездка в {{$trip->endpoint->title}} в {{$date->format('H:i m.d.Y')}} опубликована
    @endcomponent
    @component('components.button', ['url' => route('trip.show', ['trips' => $trip->id]), 'type' => 'is-success'])
        Перейти к объявлению
    @endcomponent
@endsection
