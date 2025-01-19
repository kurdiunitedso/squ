<?php

namespace App\Exports;

use App\Models\Apartment;
use App\Models\Building;
use App\Services\CP\Filters\ApartmentFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApartmentsExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;

    public function __construct($params, ApartmentFilterService $filterService)
    {
        $this->params = $params;
        $this->filterService = $filterService;
    }

    public function view(): View
    {
        $items = Apartment::latest(Apartment::ui['table'] . '.updated_at');
        if ($this->params) {
            $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view(Apartment::ui['view'] . 'export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
