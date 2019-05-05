@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.edit', $trip) }}
        <div class="title">Редактирование передачки</div>
        <form method="post" action="{{route('delivery.update', $trip)}}">
            @method('patch')
            @csrf
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Откуда:</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded">
                                <select name="startpoint_id">
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
                    </div>
                </div>
            </div>
            <span>Текущая дата: {{$dateTime->format('d.m.Y')}}</span>
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="date" id="datepicker" name="date" placeholder="Дата" required>
                            <span class="icon is-left">
                                <i class="fa fa-calendar-alt"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Описание:</label>
                <p class="control">
                    <textarea class="textarea" name="description"
                              placeholder="{{$trip->description}}">{{$trip->description}}</textarea>
                </p>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" class="button is-link">Сохранить изменения</button>
                </div>
                <div class="control">
                    <a class="button is-text" href="{{route('delivery.show', $trip)}}">Отмена</a>
                </div>
            </div>
            @include('layouts.errors')
        </form>
    @endcomponent
@endsection