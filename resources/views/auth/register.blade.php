@extends('layouts.app')
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
                                           placeholder="Elon Musk" name="name" value="{{ old('name') }}" required
                                           autofocus>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
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
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="field">
                                <label class="label">Данные для связи</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text"
                                           placeholder="Vk,Telegram,Viber..." name="link"
                                           required>{{ old('link') }}
                                    <span class="icon is-small is-left">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                </div>
                                @if ($errors->has('link'))
                                    <p class="help is-danger">{{ $errors->first('link') }}</p>
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
                                <input id="switch" type="checkbox" name="law" class="switch"
                                       checked="checked">
                                <label for="switch">Я прочитал <a
                                            href="https://journal.tinkoff.ru/news/uvozhay-bl/"
                                            style="text-decoration: underline;" target="_blank">разбор закона
                                        об оскорблении власти</a>
                                </label>
                            </div>
                            @if ($errors->has('law'))
                                <p class="help is-danger">{{ $errors->first('law') }}</p>
                            @endif
                            <div class="field">
                                <button class="button is-success" type="submit">
                                    Зарегистрироваться
                                </button>
                            </div>
                            {{--                            <div class="field">--}}
                            {{--                                <a class="button is-success modal-button" data-target="modal-bis">--}}
                            {{--                                    Зарегистрироваться--}}
                            {{--                                </a>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="modal" id="modal-bis">--}}
                            {{--                                <div class="modal-background"></div>--}}
                            {{--                                <div class="modal-card">--}}
                            {{--                                    <header class="modal-card-head">--}}
                            {{--                                        <p class="modal-card-title">Прочти соглашение</p>--}}
                            {{--                                        <a class="delete" aria-label="close"></a>--}}
                            {{--                                    </header>--}}
                            {{--                                    <section class="modal-card-body">--}}
                            {{--                                        Федеральный закон--}}
                            {{--                                    </section>--}}
                            {{--                                    <footer class="modal-card-foot">--}}
                            {{--                                        <button class="button is-success" type="submit">Прочитал</button>--}}
                            {{--                                        <a class="button is-info">Не буду читать!</a>--}}
                            {{--                                    </footer>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection