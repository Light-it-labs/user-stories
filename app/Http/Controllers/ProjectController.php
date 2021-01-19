<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models;
use App\User;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectUpdateRequest;
use Illuminate\Support\Facades\DB;

class ProjectController
{
    
    public function index(Request $request)
    {
        $projects = $request->user()->projects();

        return response()->json([
            'success' => true,
            'projects' => $projects->with(['epics', 'epics.user_stories'])->get()
        ]);
    }

    public function show(Request $request, Project $project)
    {
        if(!$request->user()->has_basic_permissions_to_project($project)){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }

        return response()->json([
            'success' => true,
            'project' => $project->load(['epics', 'epics.user_stories'])
       ]);
    }

    public function create()
    {
        
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

    public function edit(Request $request, Project $project)
    {
        if(!$request->user()->has_basic_permissions_to_project($project)){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }
        
        return response()->json([
            'success' => true,
            'project' => $project
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project){

        if(!$request->user()->has_basic_permissions_to_project($project)){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }

        $project->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully'
        ]);
    }

    public function delete(Request $request, Project $project)
    {
        if(!$request->user()->has_full_permissions_to_project($project)){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }
}
