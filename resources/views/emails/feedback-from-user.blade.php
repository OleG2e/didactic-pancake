@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-success')
        @slot('header')
            {{Auth::user()->name}} решил написать
        @endslot
        {{$message}}
    @endcomponent
    @component('components.button', ['url' => route('post.show', ['posts' => $reply->post->id]), 'type' => 'is-info'])
        Ответить ему
    @endcomponent
@endsection
