@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
    @endif
    {{ Breadcrumbs::render('post_all') }}
    <h1 class="title">Объявления:</h1>
    @foreach($post as $item)
        <li>
            <a href="post/{{$item->id}}">{{$item->description}}</a>
        </li>
    @endforeach
    <div class="control">
        <a class="button is-primary" href="post/create">Создать</a>
    </div>
@endsection

