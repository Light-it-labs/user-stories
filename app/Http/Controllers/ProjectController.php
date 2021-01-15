<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\ProjectRequest;

class ProjectController
{
    //
    public function index(Request $request)
    {

         return response()->json([
             'success' => true,
             'projects' => Project::all()
         ]);
    }

    public function show(Project $project)
    {
        
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(ProjectRequest $request)
    {
        $project = new Project($request->all());
        $project->save();

        
        $project->users()->attach($request->userId , array('role_id' => 1));

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully'
        ]);
        
    }

    public function edit(Project $project)
    {
        return view('projects.edit', [
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
