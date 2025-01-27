<?php

namespace App\Exports;

use App\Models\Lead;
use App\Models\Program;
use App\Services\CP\Filters\LeadFilterService;
use App\Services\CP\Filters\ProgramFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;

    public function __construct($params, ProgramFilterService $filterService)
    {
        $this->params = $params;
        $this->filterService = $filterService;
    }

    public function view(): View
    {
        $items = Program::latest(Program::ui['table'] . '.updated_at');

        if ($this->params) {
            $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view(Program::ui['view'] . 'export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
