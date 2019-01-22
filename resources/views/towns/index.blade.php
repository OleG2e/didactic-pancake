@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
    @endif
    <h1 class="title">Категории:</h1>
    @foreach($towns as $town)
        <li>
            <a href="/towns/{{$town->id}}">{{$town->title}}</a>
        </li>
    @endforeach
    <div class="control">
        <a class="button is-primary" href="towns/create">Создать</a>
    </div>
@endsection

