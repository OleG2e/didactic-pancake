@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('news_create') }}
    <h1 class="title">Создать новость</h1>
    <form method="post" action="/news">
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
                <input type="text" class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="title"
                       placeholder="Заголовок" value="{{old('title')}}" required>
                <textarea name="description" required>{{old('description')}}</textarea>
            </div>
        </div>

        <div>
            <button type="submit" class="button is-primary">Создать новость</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection