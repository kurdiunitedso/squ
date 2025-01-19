<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Log;
class ServicesExport implements FromView, WithStyles
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function view(): View
    {
        // Pass the services collection to the view directly
        return view('services.export', [
            'services' => $this->services
        ]);
    }
}
