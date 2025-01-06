<?php

namespace App\Exports;

use App\Models\Department;
use App\Models\Project;
use App\Services\Dashboard\Filters\DepartmentFilterService;
use App\Services\Dashboard\Filters\ProjectFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectsExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;
    private $_model;

    public function __construct(Project $_model, ProjectFilterService $filterService, $params)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        $this->params = $params;
    }

    public function view(): View
    {
        $items = $this->_model->query()->with(['contract_item', 'project_type', 'account_manager', 'art_manager', 'contract.client_trillion', 'item'])->withCount(['projectEmployees'])->latest($this->_model::ui['table'] . '.updated_at');
        // $items = Project::latest('updated_at');
        if ($this->params) {
            $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view($this->_model::ui['p_lcf'] . '.export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
