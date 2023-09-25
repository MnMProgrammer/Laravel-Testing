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

        // persist
        
        Project::create($attributes);

        // redirect
        
        return redirect('/projects');
    }
}
