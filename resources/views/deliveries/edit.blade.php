@extends('layouts.app')
@section('title', 'Редактировать передачку')
@section('og:title', 'Редактировать передачку')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.edit', $delivery) }}
        <h4 class="title is-size-4">Редактировать передачку</h4>
        <form method="post" action="{{route('delivery.update', $delivery)}}">
            @method('patch')
            @csrf
            <div class="field">
                <label class="label" for="category_id">Категория:</label>
                <div class="control has-icons-left">
                    <div class="select is-rounded">
                        <select name="category_id" id="category_id" required>
                            <option value="{{$delivery->category_id}}">{{$delivery->category->title}}</option>
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
                           value="{{ $delivery->price }}" required>
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
                                    <option value="{{$delivery->startpoint_id}}">{{$delivery->startpoint->title}}</option>
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
                        @error('startpoint_id')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Куда:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="endpoint_id" required>
                                    <option value="{{$delivery->endpoint_id}}">{{$delivery->endpoint->title}}</option>
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
                        @error('endpoint_id')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <span>Текущая дата: {{$timestamp->format('d.m.Y')}}</span>
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="date" id="datepicker" name="timestamp" placeholder="Дата"
                                   required>
                            <span class="icon is-left">
                                <i class="fa fa-calendar-alt"></i>
                            </span>
                        </p>
                        @error('timestamp')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Описание:</label>
                <p class="control">
                    <textarea class="textarea" name="description"
                              placeholder="{{$delivery->description}}">{{$delivery->description}}</textarea>
                </p>
                @error('description')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" class="button is-link">Сохранить изменения</button>
                </div>
                <div class="control">
                    <a class="button is-text" href="{{route('delivery.show', $delivery)}}">Отмена</a>
                </div>
            </div>
        </form>
    @endcomponent
@endsection