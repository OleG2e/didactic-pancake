@extends('layouts.app')
@section('content')
    <h1 class="title">Редактирование категории {{$category->title}}</h1>
    <form method="post" action="/categories/{{$category->id}}">
        @method('patch')
        @csrf
        <div class="field">
            <div class="control">

                <input type="text" class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="title"
                       placeholder="{{$category->title}}" value="{{old('title')}}" required>
            </div>
        </div>

        <div>
            <button type="submit" class="button is-primary">Сохранить</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection