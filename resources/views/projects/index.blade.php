@extends('layout')
@section('content')
    <h1>Projects</h1>
    @foreach($projects as $project)
        <li>
            <a href="/projects/{{$project->id}}">{{$project->title}} -> {{$project->description}}</a>
        </li>
    @endforeach
    <a href="/projects/create">Create</a>
@endsection

