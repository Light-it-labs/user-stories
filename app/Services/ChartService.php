<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ChartService
{
  public function getPriorityData($projectId)
  {
      $project_query = DB::table('projects')
          ->selectRaw('priority, COUNT(*) as count')
          ->join('epics', 'projects.id', '=', 'epics.project_id')
          ->join('user_stories', 'epics.id', '=', 'user_stories.epic_id')
          ->where('projects.id', '=', $projectId)
          ->groupBy('priority')
          ->orderBy('priority')
          ->get();

      return [
          'dataSets' => $project_query,
      ];
  }

  public function getValueData($projectId)
  {
      $project_query = DB::table('projects')
          ->selectRaw('value, COUNT(*) as count')
          ->join('epics', 'projects.id', '=', 'epics.project_id')
          ->join('user_stories', 'epics.id', '=', 'user_stories.epic_id')
          ->where('projects.id', '=', $projectId)
          ->groupBy('value')
          ->orderBy('value')
          ->get();

      return [
          'dataSets' => $project_query,
      ];
  }

  public function getRiskData($projectId)
  {
      $project_query = DB::table('projects')
          ->selectRaw('risk, COUNT(*) as count')
          ->join('epics', 'projects.id', '=', 'epics.project_id')
          ->join('user_stories', 'epics.id', '=', 'user_stories.epic_id')
          ->where('projects.id', '=', $projectId)
          ->groupBy('risk')
          ->orderBy('risk')
          ->get();

      return [
          'dataSets' => $project_query,
      ];
  }
}