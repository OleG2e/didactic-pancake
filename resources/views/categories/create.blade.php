@extends('layouts.app')
@section('content')
    @isset($category)
        {{ Breadcrumbs::render('category', $category) }}
    @endisset
    <h1 class="title">Название категории</h1>
    <form method="post" action="/categories">
        @csrf
        <div class="field">
            <div class="control">

                <input type="text" class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="title"
                       placeholder="Название категории" value="{{old('title')}}" required>
            </div>
        </div>

        <div>
            <button type="submit" class="button is-primary">Создать категорию</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection