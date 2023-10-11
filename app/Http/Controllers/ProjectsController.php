<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) abort(403);

        return view('projects.show', compact('project'));
    }

    public function store(Request $request)
    {
        // validate 
        $attributes = $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        // More control over the id, allows for checks if someone tries to alter the request. Validation is now at the middlewear
        //$attributes['owner_id'] = auth()->id();
        auth()->users()->projects()->create($attributes);

        // persist
        
        //Project::create($attributes);

        // redirect
        
        return redirect('/projects');
    }
}
