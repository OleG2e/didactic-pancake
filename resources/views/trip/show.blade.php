@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('trip_show', $trip) }}
    <h1 class="title">Детали объявления</h1>
    <span>{{$trip->description}}</span>
    <div class="control "><a class="button is-warning is-hovered"
                             href="/trip/{{$trip->id}}/edit">Редактировать</a>
        <form method="post" action="/trip/{{$trip->id}}">
            @method('delete')
            @csrf
            <div>
                <button type="submit" class="button is-danger">Удалить</button>
            </div>
        </form>
        <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
    </div>
    @foreach($trip->replies as $reply)
        <div>{{$reply->description}}</div>
    @endforeach
    <div>
        <form action="/reply" method="post">
            @csrf
            <input type="hidden" name="post_id" value="{{$trip->id}}">
            <input class="input" name="description">
            <button type="submit">Reply</button>
        </form>
    </div>
@endsection