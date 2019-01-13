<?php

namespace App\Http\Controllers;

use App\Events\ProjectCreated;
use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$projects = auth()->user()->projects;
        $projects = Project::where('owner_id', auth()->id())->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {

        return view('projects.create');
    }


    public function store()
    {
        $attributes = $this->validateProject();
        $attributes['owner_id'] = auth()->id();
        $project = Project::create($attributes);

        return redirect('/projects');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $project->update($this->validateProject());

        return redirect('/projects');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        //abort_unless(auth()->user()->owns($project), 403);
        //abort_if(\Gate::denies('update', $project), 403);
        return view('projects.show', compact('project'));
    }

    protected function validateProject()
    {
        return request()->validate([
            'title' => ['required', 'min:3'],
            'description' => 'required',
        ]);
    }
}
