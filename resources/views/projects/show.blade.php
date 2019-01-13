@extends('layout')
@section('title', $project->title)
@section('content')
    <h1 class="title">{{$project->title}}</h1>
    <div class="content">{{$project->description}}
        <a href="/projects/{{$project->id}}/edit">Edit</a>
    </div>
    <div>
        @if ($project->tasks->count())
            @foreach($project->tasks as $task)
                <div class="box">
                    <form method="post" action="/tasks/{{$task->id}}">
                        @method('patch')
                        @csrf
                        <label class="checkbox {{$task->completed ? 'is-complete' : ''}}" for="completed">
                            <input type="checkbox" name="completed"
                                   onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                            {{$task->description}}
                        </label>
                    </form>
                </div>
            @endforeach
    </div>
    @endif
    <form method="post" action="/projects/{{$project->id}}/tasks" class="box">
        @csrf
        <div class="field">
            <label class="label" for="description">New Task</label>
            <div class="control">
                <input type="text" class="input" name="description" placeholder="New Task" required>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Add Task</button>
            </div>
        </div>
        @include('projects.errors')
    </form>
@endsection
