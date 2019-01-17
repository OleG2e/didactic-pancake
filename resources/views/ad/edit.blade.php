@extends('layouts.app')
@section('content')
    <h1 class="title">Редактирование объявления {{$ad->title}}</h1>
    <form method="post" action="/ad/{{$ad->id}}">
        @method('patch')
        @csrf
        <div class="field">
            <div class="control">
                <label for="category_id">Категория:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="{{$ad->category_id}}">Текущая категория: {{$ad->category->title}}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>

                <textarea class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="description"
                          required>{{$ad->description}}</textarea>
            </div>
        </div>

        <div>
            <button type="submit" class="button is-primary">Сохранить</button>
        </div>
        @include('layouts.errors')
    </form>
@endsection