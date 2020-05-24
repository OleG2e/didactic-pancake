@extends('layouts.app')
@section('title', 'Создать передачку')
@section('og:title', 'Создать передачку')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('delivery.create') }}
        <h4 class="title is-size-4">Создать передачку</h4>
        <form method="post" action="{{route('delivery.store')}}">
            @csrf
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
                              placeholder="Комментарий" required>{{ old('description') }}</textarea>
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