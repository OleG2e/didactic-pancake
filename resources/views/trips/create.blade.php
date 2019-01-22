@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('trip_create') }}
    <h1 class="title">Создать объявление</h1>
    <form method="post" action="/trips">
        @csrf
        <div class="field">
            <div class="control">
                <label for="category_id">Категория:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Выберете одну...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                <input type="date" class="datepicker" name="date_time">
                <textarea class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="description"></textarea>
                <label class="checkbox">
                    <input type="checkbox" name="load" value="1">
                    Возьму груз
                </label>
            </div>
        </div>

        <div>
            <button type="submit" class="button is-primary">Создать объявление</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection