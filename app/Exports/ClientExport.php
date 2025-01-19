<?php

namespace App\Exports;

use App\Models\Apartment;
use App\Models\Client;
use App\Services\CP\Filters\ClientFilterService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientExport implements FromView, WithStyles
{
    private $params;
    protected $filterService;

    public function __construct($params, ClientFilterService $filterService)
    {
        $this->params = $params;
        $this->filterService = $filterService;
    }

    public function view(): View
    {
        $items = Client::latest(Client::ui['table'] . '.updated_at');
        if ($this->params) {
            $this->filterService->applyFilters($items, $this->params);
        }

        $items = $items->get();

        return view(Client::ui['view'] . 'export', compact('items'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
