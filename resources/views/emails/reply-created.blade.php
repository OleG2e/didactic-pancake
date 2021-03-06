@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-info')
        @slot('header')
            Появился новый комментарий к твоему объявлению
        @endslot
        Чтобы посмотреть детали нажми на кнопку ниже
    @endcomponent
    @component('components.button', ['url' => route('post.show', $reply->post->id), 'type' => 'is-info'])
        Перейти к объявлению
    @endcomponent
@endsection