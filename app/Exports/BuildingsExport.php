<?php

namespace App\Exports;

use App\Models\Building;
use App\Services\CP\Filters\BuildingFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BuildingsExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;

    public function __construct($params, BuildingFilterService $filterService)
    {
        $this->params = $params;
        $this->filterService = $filterService;
    }

    public function view(): View
    {
        $items = Building::latest(Building::ui['table'] . '.updated_at');
        if ($this->params) {
            // $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view(Building::ui['view'] . 'export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
