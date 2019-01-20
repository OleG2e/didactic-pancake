@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('post_show', $post) }}
    <h1 class="title">Детали объявления</h1>
    <span>{{$post->description}}</span>
    <div class="control "><a class="button is-warning is-hovered"
                             href="/post/{{$post->id}}/edit">Редактировать</a>
        <form method="post" action="/post/{{$post->id}}">
            @method('delete')
            @csrf
            <div>
                <button type="submit" class="button is-danger">Удалить</button>
            </div>
        </form>
        <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
    </div>
    @foreach($post->replies as $reply)
        <div>{{$reply->description}}</div>
    @endforeach
    <div>
        <form action="/reply" method="post">
            @csrf
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <input class="input" name="description">
            <button type="submit">Reply</button>
        </form>
    </div>
@endsection