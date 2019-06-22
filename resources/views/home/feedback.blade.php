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
        <form method="post" action="{{route('feedback.submit')}}" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label class="label">Сообщение</label>
                <div class="control">
                    <textarea class="textarea" placeholder="Текст" name="message"></textarea>
                </div>
                @if ($errors->has('message'))
                    <p class="help is-danger">{{ $errors->first('message') }}</p>
                @endif
            </div>
            <div class="field">
                <label class="label">Изображение</label>
                <div class="control">
                    <input class="file" type="file" name="image" accept="image/*">
                </div>
                @if ($errors->has('image'))
                    <p class="help is-danger">{{ $errors->first('image') }}</p>
                @endif
            </div>
            <button class="button is-success" type="submit">Отправить</button>
        </form>
    @endcomponent
@endsection