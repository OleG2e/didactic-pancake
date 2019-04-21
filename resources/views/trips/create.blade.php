@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip.create') }}
        <div class="title">Создать поездку</div>
        <form method="post" action="{{route('trip.all')}}">
            @csrf
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Тип поездки:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="icon is-small is-left">
                                <i class="fas fa-columns"></i>
                            </div>
                        </div>
                    </div>
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
                                <i class="fas fa-city"></i>
                            </div>
                        </div>
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
                                <i class="fas fa-city"></i>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Возьму пассажиров:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="passengers_count">
                                    <option value="">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="icon is-small is-left">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Стоимость:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="price">
                                    <option value="По-братски">По-братски</option>
                                    <option value="Как договоримся">Как договоримся</option>
                                    <option value="Рыночная">Рыночная</option>
                                </select>
                            </div>
                            <div class="icon is-small is-left">
                                <i class="fas fa-ruble-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="date" id="datepicker" name="date" placeholder="Дата" required>
                            <span class="icon is-left">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="time" id="timepicker" name="time" placeholder="Время" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-clock"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Описание:</label>
                <p class="control">
                    <textarea class="textarea" name="description" placeholder="Комментарий к поездке"></textarea>
                </p>
            </div>
            <div class="field">
                <div class="control">
                    <label class="checkbox">
                        <input type="checkbox" name="load" value="1">
                        Возьму груз
                    </label>
                </div>
            </div>
            <div class="control">
                <button class="button is-primary is-rounded" type="submit">Создать поездку</button>
            </div>
            @include('layouts.errors')
        </form>
    @endcomponent
@endsection