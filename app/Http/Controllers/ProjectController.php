<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\ProjectRequest;

class ProjectController
{
    //
    public function index()
    {
        return view('Projects.index', [
            'projects' => Project::all()
        ]);
    }

    public function show(Project $project)
    {
        
    }

    public function create()
    {
        return view('Projects.create');
    }

    public function store(ProjectRequest $request)
    {
        $project = new Project($request->all());
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully'
        ]);
        
    }

    public function edit(Project $project)
    {
        return view('Projects.edit', [
            'project' => $project
        ]);
    }

    public function update(ProjectRequest $request, Project $project){

        $project->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully'
        ]);
    }

    public function delete(Project $project)
    {
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }
}
