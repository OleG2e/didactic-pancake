@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
    @endif
    {{ Breadcrumbs::render('news_all') }}
    <h1 class="title">Новости:</h1>
    @foreach($news as $item)
        <li>
            <a href="/news/{{$item->id}}">{{$item->title}}</a>
        </li>
    @endforeach
    <div class="control">
        <a class="button is-primary" href="news/create">Создать</a>
    </div>
@endsection

