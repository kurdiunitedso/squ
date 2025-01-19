<?php

namespace App\Exports;

use App\Models\Procedure;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProceduresExport implements FromView, WithStyles
{

    private $search_name_code;
    private $is_active;
    private $is_image;
    /**
     * @return \Illuminate\Support\Collection
     */


    function __construct(
        $search_name_code,
        $is_active,
        $is_image
    ) {
        $this->search_name_code =  $search_name_code;
        $this->is_active =  $is_active;
        $this->is_image =  $is_image;
    }
    public function view(): View
    {
        $query = Procedure::with('procedureType');

        $search_name_code = $this->search_name_code;
        $is_active = $this->is_active;
        $is_image = $this->is_image;

        $query->where(function ($q) use ($search_name_code) {
            $q->where('name_en', 'like', "%" . $search_name_code . "%");
            $q->orWhere('code', 'like', "%" . $search_name_code . "%");
        });

        if ($is_image == 'on') {
            $query->where('is_image', true);
        }
        if ($is_active == 'on') {
            $query->where('status', true);
        }

        $procedures = $query->get();
        return view('procedures.export', [
            'procedures' => $procedures
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
