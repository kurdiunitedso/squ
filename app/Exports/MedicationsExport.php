<?php

namespace App\Exports;

use App\Models\Medication;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MedicationsExport implements FromView, WithStyles
{
    private $search_name_code;
    private $is_active;

    function __construct(
        $search_name_code,
        $is_active
    ) {
        $this->search_name_code =  $search_name_code;
        $this->is_active =  $is_active;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        //

        $search_name_code = $this->search_name_code;
        $is_active = $this->is_active;

        $query =  Medication::query();

        $query->where(function ($q) use ($search_name_code) {
            $q->where('name', 'like', "%" . $search_name_code . "%");
            $q->orWhere('name_en', 'like', "%" . $search_name_code . "%");
            $q->orWhere('name_he', 'like', "%" . $search_name_code . "%");
        });

        if ($is_active == 'on') {
            $query->where('status', true);
        }

        $medications = $query->get();
        return view('medications.export', [
            'medications' => $medications
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
