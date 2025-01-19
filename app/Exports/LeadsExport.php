<?php

namespace App\Exports;

use App\Models\Lead;
use App\Services\CP\Filters\LeadFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeadsExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;

    public function __construct($params, LeadFilterService $filterService)
    {
        $this->params = $params;
        $this->filterService = $filterService;
    }

    public function view(): View
    {
        $items = Lead::latest(Lead::ui['table'] . '.updated_at');
        if ($this->params) {
            // $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view(Lead::ui['view'] . 'export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
