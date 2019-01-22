@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('trip_edit', $trip) }}
    <h1 class="title">Редактирование объявления {{$trip->title}}</h1>
    <form method="post" action="/trips/{{$trip->id}}">
        @method('patch')
        @csrf
        <div class="field">
            <div class="control">
                <label for="category_id">Категория:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="{{$trip->category_id}}">Текущая категория: {{$trip->category->title}}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                <input class="datepicker" type="date" name="date_time">
                <textarea class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="description"
                          required>{{$trip->description}}</textarea>
                <label class="checkbox">
                    <input type="checkbox" name="load" value="{{$trip->load}}">
                    Возьму груз
                </label>
            </div>
        </div>
        <div>
            <button type="submit" class="button is-primary">Сохранить</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection