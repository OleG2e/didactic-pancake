@extends('layouts.app')
@section('title', 'Письмо админу')
@section('og:title', 'Письмо админу')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('feedback.form') }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{session('message')}}
            @endcomponent
        @endif
        <form method="post" action="{{route('feedback.submit')}}">
            @csrf
            <div class="field">
                <label class="label">Сообщение</label>
                <div class="control">
                    <textarea class="textarea" placeholder="Текст" name="message"></textarea>
                </div>
            </div>
            <button class="button is-success" type="submit">Отправить</button>
        </form>
    @endcomponent
@endsection