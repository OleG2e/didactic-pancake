@extends('layouts.app')
@section('title', 'Создать поездку')
@section('og:title', 'Создать поездку')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip.create') }}
        <h4 class="title is-size-4">Создать поездку</h4>
        <form method="post" action="{{route('trip.all')}}">
            @csrf
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Откуда:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="startpoint_id" required>
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
                        @error('endpoint_id')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Количество пассажиров:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="passengers_count">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="icon is-small is-left">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                        @error('passengers_count')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
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
                                <i class="fa fa-ruble-sign"></i>
                            </div>
                        </div>
                        @error('price')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="date" id="datepicker" name="date" placeholder="Дата" required>
                            <span class="icon is-left">
                                <i class="fa fa-calendar-alt"></i>
                            </span>
                        </p>
                        @error('date')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="time" id="timepicker" name="time" placeholder="Время" required>
                            <span class="icon is-small is-left">
                                <i class="fa fa-clock"></i>
                            </span>
                        </p>
                        @error('time')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Описание:</label>
                <p class="control">
                    <textarea class="textarea" name="description" placeholder="Комментарий к поездке"></textarea>
                </p>
                @error('description')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="control">
                <button class="button is-primary is-rounded" type="submit">Создать поездку</button>
            </div>
        </form>
    @endcomponent
@endsection