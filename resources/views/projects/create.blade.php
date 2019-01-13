@extends('layout')
@section('content')
    <h1>Create a new project</h1>
    <form method="post" action="/projects">
        @csrf
        <div class="field">
            <label class="label" for="title">Project Title</label>
            <div class="control">

                <input type="text" class="input {{$errors->has('title') ? 'is-danger' : ''}}" name="title"
                       placeholder="Project Title" value="{{old('title')}}" required></div>
        </div>

        <div class="field">
            <label class="label" for="description">Project Description</label>
            <div class="control">

                <textarea name="description" class="textarea {{$errors->has('description') ? 'is-danger' : ''}}"
                          placeholder="Project Description"
                          required>{{old('description')}}</textarea>
            </div>
        </div>
        <div>
            <button type="submit">Create Project</button>
        </div>
        @include('projects.errors')
    </form>
@endsection