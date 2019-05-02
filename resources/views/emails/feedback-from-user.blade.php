@extends('layouts.mail.html.layout')
@section('content')
    @component('components.message')
        @slot('type', 'is-info')
        @slot('header')
            {{Auth::user()->name}} решил написать
        @endslot
        {{$message}}
    @endcomponent
    @component('components.button', ['url' => route('admin.feedback.form'), 'type' => 'is-info'])
        Ответить ему
    @endcomponent
@endsection
