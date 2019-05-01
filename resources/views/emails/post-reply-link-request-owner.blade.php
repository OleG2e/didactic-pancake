@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-info')
        @slot('header')
            Новый запрос контактных данных
        @endslot
        Пользователь {{Auth::user()->name}} хочет связаться с вами. Он запросил ваши данные из
        <a href="{{route('post.show',['posts' => $reply->post->id])}}" target="_blank">этого</a> обсуждения.
        Вот его данные для связи: {{Auth::user()->link}}
    @endcomponent
@endsection
