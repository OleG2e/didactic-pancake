@extends('layouts.app')
@section('title', 'Регистрация')
@section('og:title', 'Регистрация')
@section('content')
    <section class="hero is-primary is-bold is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                        <form class="box" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="field">
                                <label class="label">Логин</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="text"
                                           placeholder="Elon Musk" name="username" value="{{ old('username') }}"
                                           required
                                           autofocus>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                @error('username')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="email"
                                           placeholder="email@example.ru" name="email" value="{{ old('email') }}"
                                           required>
                                    <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                </div>
                                @error('email')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="label">Данные для связи</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text"
                                           placeholder="Vk,Telegram,Viber..." name="link" value="{{ old('link') }}"
                                           required>
                                    <span class="icon is-small is-left">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                </div>
                                @error('link')
                                <p class="help is-danger">{{ $message }}</p>
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
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
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
                                @error('password_confirmation')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <input id="switch" type="checkbox" name="law" class="switch" value="1"
                                       checked="checked">
                                <label for="switch"></label>
                                Я прочитал <a href="https://journal.tinkoff.ru/news/uvozhay-bl/"
                                              style="text-decoration: underline;" target="_blank">разбор закона
                                    об оскорблении власти</a>
                            </div>
                            @error('law')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                            <div class="field">
                                <button class="button is-success" type="submit">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection