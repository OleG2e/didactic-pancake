@extends('layouts.app')
@section('content')
    <h1 class="title">Создать объявление</h1>
    <form method="post" action="/ad">
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
                <textarea name="description" required>{{old('description')}}</textarea>
            </div>
        </div>

        <div>
            <button type="submit" class="button is-primary">Создать объявление</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection