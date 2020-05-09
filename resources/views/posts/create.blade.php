@extends('layouts.app')
@section('title', 'Создать объявление')
@section('og:title', 'Создать объявление')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.create') }}
        <div class="box">
            <h4 class="title is-size-4">Создать объявление</h4>
            <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="field">
                    <label class="label" for="category_id">Категория:</label>
                    <div class="control">
                        <div class="select is-rounded">
                            <select name="category_id" id="category_id" required>
                                <option value="" disabled>Выберете одну...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <label class="label">Заголовок:</label>
                        <input class="input is-rounded" type="text" placeholder="Заголовок" name="title"
                               value="{{ old('title') }}" required>
                    </div>
                    @error('title')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Текст:</label>
                    <div class="control">
                                <textarea class="textarea" placeholder="Текст" name="description"
                                          required>{{old('description')}}</textarea>
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
                    @error('image')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field">
                    @include('components.ymap')
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link" onclick="$(this).addClass('is-loading');">Создать
                            объявление
                        </button>
                    </div>
                    <div class="control">
                        <a class="button is-text" href="{{back()->getTargetUrl()}}">Отмена</a>
                    </div>
                </div>
            </form>
        </div>
    @endcomponent
@endsection