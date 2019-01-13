@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{__('messages.categoryCreated')}}
        </div>
    @endif
    <h1 class="title">Категории:</h1>
    @foreach($categories as $category)
        <li>
            <a href="/categories/{{$category->id}}">{{$category->title}}</a>
        </li>
    @endforeach
    <div class="control">
        <a class="button is-primary" href="categories/create">Создать</a>
        {{--<form method="post" action="categories/{category}">
            @csrf TODO: add opportunity to delete selected category
            @method('delete')
            <button class="button is-danger">Удалить</button>
        </form>--}}
    </div>
@endsection

