@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-info')
        @slot('header')
            Сброс пароля
        @endslot
        Для создания нового пароля перейдите по ссылке ниже
    @endcomponent
    @component('components.button', ['url' => '/password/reset/' . $token, 'type' => 'is-info'])
        Сбросить
    @endcomponent
@endsection
