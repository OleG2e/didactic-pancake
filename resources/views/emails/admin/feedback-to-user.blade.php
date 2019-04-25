@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-success')
        @slot('header')
            Ответ на твоё сообщение
        @endslot
        {{$message}}
    @endcomponent
@endsection
