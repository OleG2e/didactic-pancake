@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Проверьте свою электронную почту') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Новая ссылка для активации аккаунта была отправлена') }}
                            </div>
                        @endif

                        {{ __('Перед продолжением, пожалуйста, проверьте свою почту') }}
                        {{ __('Если вы не получили письмо') }}, <a
                                href="{{ route('verification.resend') }}">{{ __('нажмите сюда для повторной отправки') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
