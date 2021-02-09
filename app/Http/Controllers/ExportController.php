<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Exports\ProjectExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ExportController
{
    /**
     * @return BinaryFileResponse
     */
    public function projectExport(Project $project)
    {
        return Excel::download(new ProjectExport($project), "$project->name.xlsx");
    }
}
