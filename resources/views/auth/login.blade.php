@extends('layouts.app')
@section('title', 'Войти')
@section('og:title', 'Войти')
@section('content')
    <section class="hero is-primary is-bold is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                        <form class="box" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="field">
                                <label class="label">Логин</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="text"
                                           placeholder="Имя пользователя" name="login"
                                           value="{{ old('login') ?: old('email') }}" required autofocus>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                </div>
                                @error('login')
                                <p class="help is-danger">{{$message}}</p>
                                @enderror
                                @error('email')
                                <p class="help is-danger">{{$message}}</p>
                                @enderror
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
                                @error('password')
                                <p class="help is-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember" checked>
                                    Запомнить
                                </label>
                            </div>
                            <div class="field is-horizontal">
                                <div class="field-body">
                                    <div class="field">
                                        <button class="button is-success" type="submit">
                                            Войти
                                        </button>
                                    </div>
                                    <div class="field">
                                        <a class="button is-info"
                                           href="{{ route('password.request') }}">
                                            {{ __('Забыл пароль?') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <a href="{{ route('register') }}" class="button is-hovered">Регистрация</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
