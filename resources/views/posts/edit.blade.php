@extends('layouts.app')
@section('title', 'Редактировать объявление')
@section('og:title', 'Редактировать объявление')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.edit', $post->category->slug, $post) }}
        <div class="box">
            <h4 class="title is-size-4">Редактировать объявление {{$post->title}}</h4>
            <form method="post" action="{{route('post.update', [$post->category->slug, $post])}}"
                  enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="field">
                    <label class="label" for="category_id">Категория:</label>
                    <div class="control">
                        <div class="select is-rounded">
                            <select name="category_id" id="category_id" required>
                                <option value="{{ $post->category->id }}">{{ $post->category->title }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <label class="label">Заголовок:</label>
                        <input class="input is-rounded" type="text" placeholder="{{$post->title}}" name="title"
                               value="{{$post->title}}"
                               required>
                    </div>
                    @error('title')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Текст:</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="{{$post->description}}"
                                  name="description">{{$post->description}}</textarea>
                    </div>
                    @error('description')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Фотографии</label>
                    <div class="control">
                        <input type="file" name="image[]" accept="image/*" multiple>
                    </div>
                </div>
                <div class="field">
                    @include('components.ymap')
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link" onclick="$(this).addClass('is-loading');">
                            Сохранить
                        </button>
                    </div>
                    <div class="control">
                        <a class="button is-text"
                           href="{{route('post.show', [$post->category->slug, $post])}}">Отмена</a>
                    </div>
                </div>
            </form>
        </div>
    @endcomponent
@endsection