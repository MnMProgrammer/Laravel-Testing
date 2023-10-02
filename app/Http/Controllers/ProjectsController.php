<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
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
        $attributes['owner_id'] = auth()->id();

        // persist
        
        Project::create($attributes);

        // redirect
        
        return redirect('/projects');
    }
}
