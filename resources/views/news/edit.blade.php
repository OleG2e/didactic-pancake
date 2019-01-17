@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('news_edit', $news) }}
    <h1 class="title">Редактирование новости {{$news->title}}</h1>
    <form method="post" action="/news/{{$news->id}}">
        @method('patch')
        @csrf
        <div class="field">
            <div class="control">
                <label for="category_id">Категория:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="{{$news->category_id}}">Текущая категория: {{$news->category->title}}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                <input type="text" class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="title"
                       placeholder="{{$news->title}}" value="{{$news->title}}" required>
                <textarea class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="description"
                          required>{{$news->description}}</textarea>
            </div>
        </div>

        <div>
            <button type="submit" class="button is-primary">Сохранить</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection