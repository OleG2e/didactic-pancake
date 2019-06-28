@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-info')
        @slot('header')
            Подтверждение адреса электронной почты
        @endslot
        Для подтверждения адреса электронной почты перейдите по ссылке ниже
    @endcomponent
    @component('components.button', ['url' => $verificationUrl, 'type' => 'is-info'])
        Подтвердить
    @endcomponent
@endsection
