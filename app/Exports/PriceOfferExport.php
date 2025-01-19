<?php

namespace App\Exports;

use App\Models\PriceOffer;
use App\Services\CP\Filters\PriceOfferFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PriceOfferExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;

    public function __construct($params, PriceOfferFilterService $filterService)
    {
        $this->params = $params;
        $this->filterService = $filterService;
    }

    public function view(): View
    {
        $items = PriceOffer::latest(PriceOffer::ui['table'] . '.updated_at');
        if ($this->params) {
            // $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view(PriceOffer::ui['view'] . 'export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
