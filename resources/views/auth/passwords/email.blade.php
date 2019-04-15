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
                        @if (session('status'))
                            @component('components.flash_message', ['type'=>'is-success'])
                                {{ session('status') }}
                            @endcomponent
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
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
                                <button class="button is-info" type="submit">
                                    Отправить ссылку для сброса пароля
                                </button>
                            </div>
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
