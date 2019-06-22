@extends('layouts.app')
@section('title', 'AdminFeedback')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('admin.feedback.form') }}
        @if (session('message'))
            <div class="notification is-success">
                {{session('message')}}
            </div>
        @endif
        <form method="post" action="{{route('admin.feedback.submit')}}">
            @csrf
            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left has-icons-right">
                    <input class="input" type="email" placeholder="Email input" name="email">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>
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