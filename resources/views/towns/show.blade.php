@extends('layouts.app')
@section('content')
    <h1 class="title">Детали категории "{{$town->title}}"</h1>
    <div class="control "><a class="button is-warning is-hovered"
                             href="/towns/{{$town->id}}/edit">Редактировать</a>
        <form method="post" action="/towns/{{$town->id}}">
            @method('delete')
            @csrf
            <div>
                <button type="submit" class="button is-danger">Удалить</button>
            </div>
        </form>
        <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
    </div>
@endsection