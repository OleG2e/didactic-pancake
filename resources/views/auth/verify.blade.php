@extends('layouts.app')
@section('title', 'Подтверждение почты')
@section('og:title', 'Подтверждение почты')
@section('content')
    <section class="hero is-primary is-bold is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <article class="message is-info">
                    <div class="message-header">
                        <p>{{ __('Проверьте свою электронную почту') }}</p>
                    </div>
                    <div class="message-body">
                        @if (session('resent'))
                            @component('components.flash-message', ['type'=>'is-success'])
                                {{ __('Новая ссылка для активации аккаунта была отправлена') }}
                            @endcomponent
                        @endif
                        {{ __('Перед продолжением, пожалуйста, проверьте свою почту. Для входа в личный кабинет вам нужно перейти по ссылке из письма.') }}
                        {{ __('Если вы не получили письмо, то') }} <a
                                href="{{ route('verification.resend') }}">{{ __('нажмите сюда для повторной отправки') }}</a>.
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
