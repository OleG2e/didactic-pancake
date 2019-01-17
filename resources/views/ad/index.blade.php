@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
    @endif
    {{ Breadcrumbs::render('ad_all') }}
    <h1 class="title">Объявления:</h1>
    @foreach($ad as $item)
        <li>
            <a href="ad/{{$item->id}}">{{$item->description}}</a>
        </li>
    @endforeach
    <div class="control">
        <a class="button is-primary" href="ad/create">Создать</a>
    </div>
@endsection

