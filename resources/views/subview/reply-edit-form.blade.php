@extends('layouts.app')
@section('content')
    @component('components.hero')
        <div class="box">
            <div class="title">Редактирование ответа {{$reply->title}}</div>
            <form method="post" action="{{route('reply.update', $reply)}}">
                @method('patch')
                @csrf
                <div class="field">
                    <label class="label">Текст:</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="{{$reply->description}}"
                                  name="description">{{$reply->description}}</textarea>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link">Сохранить
                            изменения
                        </button>
                    </div>
                    <div class="control">
                        <a class="button is-text" href="{{back()->getTargetUrl()}}">Отмена</a>
                    </div>
                </div>
            </form>
        </div>
    @endcomponent
@endsection