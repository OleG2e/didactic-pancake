@extends('layout')
@section('title', 'Laravel')
@section('content')
    <h1 class="title">Edit Project</h1>
    <form method="post" action="/projects/{{$project->id}}">
        @method('patch')
        @csrf
        <div>
            <input type="text" name="title" placeholder="Project Title" value="{{$project->title}}"></div>

        <div>
            <textarea name="description" placeholder="Project Description">{{$project->description}}</textarea>
        </div>
        <div>
            <button type="submit">Update Project</button>
        </div>
    </form>
    <div>
        @include('projects.errors')
        <form method="post" action="/projects/{{$project->id}}">
            @method('delete')
            @csrf
            <div>
                <button type="submit">Delete Project</button>
            </div>
        </form>
    </div>
@endsection
