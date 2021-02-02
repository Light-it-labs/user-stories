<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\ChartService;

class DashboardController
{
    /**
     * @var ChartService
     */
    private $chartService;

    public function __construct(ChartService $chartService)
    {
        $this->chartService = $chartService;
    }

    public function getStrategicUserStoriesDescription(Project $project)
    {
        $project_user_stories = $project->user_stories()->where('category', 'Strategic')->get();
        $project_user_stories_description = $project_user_stories->pluck('description');

        return response()->json([
            'success' => true,
            'userStoriesDescription' => $project_user_stories_description
        ]);
    }

    public function getPriorityChartData(Project $project)
    {
        $chartData = $this->chartService->getPriorityData($project->id);

        return response()->json([
            'success' => true,
            'chartData' => $chartData,
            'chartType' => 'priority'
        ]);
    }

    public function getValueChartData(Project $project)
    {
        $chartData = $this->chartService->getValueData($project->id);

        return response()->json([
            'success' => true,
            'chartData' => $chartData,
            'chartType' => 'value'
        ]);
    }

    public function getRiskChartData(Project $project)
    {
        $chartData = $this->chartService->getRiskData($project->id);

        return response()->json([
            'success' => true,
            'chartData' => $chartData,
            'chartType' => 'risk'
        ]);
    }

    public function getProjectUserStoriesCount(Project $project)
    {

        return response()->json([
            'success' => true,
            'userStoriesCount' => $project->user_stories()->count(),
            
        ]);
    }
}
