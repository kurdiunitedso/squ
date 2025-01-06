<?php

namespace App\Exports;

use App\Models\Department;
use App\Services\Dashboard\Filters\DepartmentFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepartmentsExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;

    public function __construct($params, DepartmentFilterService $filterService)
    {
        $this->params = $params;
        $this->filterService = $filterService;
    }

    public function view(): View
    {
        $items = Department::latest('updated_at');
        if ($this->params) {
            $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view('departments.export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
