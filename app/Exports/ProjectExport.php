<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProjectExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    use Exportable;

    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project->with(['epics', 'epics.user_stories'])->get();
    }

    public function collection()
    {
        return $this->project;
    }

    public function map($project): array
    {
        $rows = [];
        foreach($project->epics as $epic)
        {
            array_push($rows, [$epic->description]);

            foreach($epic->user_stories as $user_story){
                $row = [
                    "",
                    $user_story->description,
                    $user_story->user_id,
                    $user_story->priority,
                    $user_story->value,
                    $user_story->risk,
                    $user_story->estimate,
                    $user_story->category,
                    $user_story->acceptance,
                    $user_story->notes,
                    $user_story->created_at->format("d/m/y"),
                    $user_story->updated_at->format("d/m/y"),
                ];
                array_push($rows, $row);
            }
            array_push($rows, []);  
        };
        return $rows;
    }

    public function columnWidths():array
    {
        return[
            'A' => 30,
            'B' => 50,
            'C' => 12,
            'G' => 12,
            'H' => 12,
            'I' => 15,
            'J' => 15,
            'K' => 15,
            'L' => 15,
        ];
    }

    public function headings(): array
    {
        return [
            'Epic Description',
            'User Story Description',
            'Creator',
            'Priority',
            'Value',
            'Risk',
            'Estimate',
            'Category',
            'Acceptance',
            'Notes',
            'Created at',
            'Updated at',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A'  => ['font' => ['size' => 12, 'bold' => true]],
            'C:L' => ['alignment' => ['horizontal' => 'center']],
            1    => ['font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center']],
        ];
    }

    
}


