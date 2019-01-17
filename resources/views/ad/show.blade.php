@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('ad_show', $ad) }}
    <h1 class="title">Детали объявления</h1>
    <span>{{$ad->description}}</span>
    <div class="control "><a class="button is-warning is-hovered"
                             href="/ad/{{$ad->id}}/edit">Редактировать</a>
        <form method="post" action="/ad/{{$ad->id}}">
            @method('delete')
            @csrf
            <div>
                <button type="submit" class="button is-danger">Удалить</button>
            </div>
        </form>
        <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
    </div>
@endsection