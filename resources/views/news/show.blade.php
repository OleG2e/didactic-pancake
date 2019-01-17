@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('news_show', $news) }}
    <h1 class="title">Детали новости "{{$news->title}}"</h1>
    <span>{{$news->description}}</span>
    <div class="control "><a class="button is-warning is-hovered"
                             href="/news/{{$news->id}}/edit">Редактировать</a>
        <form method="post" action="/news/{{$news->id}}">
            @method('delete')
            @csrf
            <div>
                <button type="submit" class="button is-danger">Удалить</button>
            </div>
        </form>
        <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
    </div>
@endsection