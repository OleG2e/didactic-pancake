@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('post_edit', $post) }}
    <h1 class="title">Редактирование объявления {{$post->title}}</h1>
    <form method="post" action="/post/{{$post->id}}">
        @method('patch')
        @csrf
        <div class="field">
            <div class="control">
                <label for="category_id">Категория:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="{{$post->category_id}}">Текущая категория: {{$post->category->title}}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                <input class="input" name="title" value="{{ $post->title }}">
                <textarea class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="description"
                          required>{{$post->description}}</textarea>
            </div>
        </div>
        <div>
            <button type="submit" class="button is-primary">Сохранить</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection