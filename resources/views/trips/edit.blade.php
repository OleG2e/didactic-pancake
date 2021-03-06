@extends('layouts.app')
@section('title', 'Редактировать поездку')
@section('og:title', 'Редактировать поездку')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip.edit', $trip) }}
        <h4 class="title is-size-4">Редактировать поездку {{$trip->title}}</h4>
        <form method="post" action="{{route('trip.update', $trip)}}">
            @method('patch')
            @csrf
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Откуда:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="startpoint_id" required>
                                    <option value="{{$trip->startpoint_id}}">{{$trip->startpoint->title}}</option>
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
                                    <option value="{{$trip->endpoint_id}}">{{$trip->endpoint->title}}</option>
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
                    <div class="field">
                        <label class="label">Количество пассажиров:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="passengers_count">
                                    <option value="{{$trip->passengers_count}}">{{$trip->passengers_count}}</option>
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
                                    <option value="{{$trip->price}}">{{$trip->price}}</option>
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
                <input id="currentDate" type="hidden" value="{{\App\Helpers::dateFormat($trip->date_time,'Y/m/d')}}">
                <input id="currentTime" type="hidden" value="{{\App\Helpers::dateFormat($trip->date_time,'H:i')}}">
                @include('components.js-date-time-set')
            </div>
            <div class="field">
                <label class="label">Описание:</label>
                <p class="control">
                    <textarea class="textarea" name="description"
                              placeholder="{{$trip->description}}">{{$trip->description}}</textarea>
                </p>
                @error('description')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="control">
                <button class="button is-primary is-rounded" type="submit">Сохранить изменения</button>
            </div>
        </form>
    @endcomponent
@endsection