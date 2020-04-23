@extends('layouts.app')
@section('title', 'Создать передачку')
@section('og:title', 'Создать передачку')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.create') }}
        <h4 class="title is-size-4">Создать передачку</h4>
        <form method="post" action="{{route('delivery.store')}}">
            @csrf
            <div class="field">
                <label class="label" for="category_id">Категория:</label>
                <div class="control has-icons-left">
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
                    <div class="icon is-small is-left">
                        <i class="fa fa-list"></i>
                    </div>
                </div>
                @error('category_id')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label" for="price">Цена:</label>
                <p class="control is-expanded has-icons-left">
                    <input class="input" type="text" name="price" placeholder="Цена"
                           value="{{ old('price') }}" required>
                    <span class="icon is-left">
                                <i class="fa fa-dollar-sign"></i>
                            </span>
                </p>
                @error('price')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Откуда:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="startpoint_id">
                                    @foreach ($towns as $town)
                                        <option value="{{ $town->id }}" {{ old('town_id') == $town->id ? 'selected' : '' }}>
                                            {{ $town->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="icon is-small is-left">
                                <i class="fa fa-city"></i>
                            </div>
                        </div>
                        @error('town_id')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Куда:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="endpoint_id" required>
                                    @foreach ($towns as $town)
                                        <option value="{{ $town->id }}" {{ old('town_id') == $town->id ? 'selected' : '' }}>
                                            {{ $town->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="icon is-small is-left">
                                <i class="fa fa-city"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="date" id="datepicker" name="date_time" placeholder="Дата"
                                   value="{{ old('date_time') }}" required>
                            <span class="icon is-left">
                                <i class="fa fa-calendar-alt"></i>
                            </span>
                        </p>
                        @error('date_time')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Описание:</label>
                <p class="control">
                    <textarea class="textarea" name="description"
                              placeholder="Комментарий">{{ old('description') }}</textarea>
                </p>
                @error('description')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="control">
                <button class="button is-primary is-rounded" type="submit">Создать</button>
            </div>
        </form>
    @endcomponent
@endsection