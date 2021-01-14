<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models;
use App\Http\Requests\ProjectRequest;

class ProjectController
{
    //
    public function index()
    {
        return response()->json([
             'success' => true,
             'projects' => Project::with(['epics', 'epics.user_stories'])->get()
        ]);
    }

    public function show(Project $project)
    {
        return response()->json([
            'success' => true,
            'project' => $project->load(['epics', 'epics.user_stories'])
       ]);
    }

    public function create()
    {
        //return view('projects.create');
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
        // return view('projects.edit', [
        //     'project' => $project
        // ]);
        
        return response()->json([
            'success' => true,
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
