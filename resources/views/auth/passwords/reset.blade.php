@extends('layouts.app')
@section('content')
    <section class="hero is-primary is-bold is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <article class="message is-info">
                    <div class="message-header">
                        <p>Сброс пароля</p>
                    </div>
                    <div class="message-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="email"
                                           placeholder="email@example.ru" name="email" value="{{ old('email') }}"
                                           required autofocus>
                                    <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                </div>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="field">
                                <label class="label">Пароль</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="password" placeholder="********" name="password"
                                           value="{{ old('password') }}" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                                @if ($errors->has('password'))
                                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="field">
                                <label class="label">Подтверждение пароля</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="password" placeholder="********"
                                           name="password_confirmation"
                                           value="{{ old('password') }}" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                @endif
                            </div>
                            <div class="field">
                                <button class="button is-info" type="submit">
                                    Сохранить новый пароль
                                </button>
                            </div>
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
