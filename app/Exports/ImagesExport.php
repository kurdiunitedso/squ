<?php

namespace App\Exports;

use App\Models\Image;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImagesExport implements FromView, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */


    private $search_name_code;
    private $is_active;
    private $sickFunds;

    function __construct(
        $search_name_code,
        $is_active,
        $sickFunds
    ) {
        $this->search_name_code =  $search_name_code;
        $this->is_active =  $is_active;
        $this->sickFunds =  $sickFunds;
    }


    public function view(): View
    {
        //

        $search_name_code = $this->search_name_code;
        $is_active = $this->is_active;
        $sickFundIds = $this->sickFunds;
        $query =  Image::with('imageCodes', 'imageCodes.sickFund');

        $query->where(function ($q) use ($search_name_code) {
            $q->where('name', 'like', "%" . $search_name_code . "%");
            $q->orWhere('name_en', 'like', "%" . $search_name_code . "%");
            $q->orWhere('name_he', 'like', "%" . $search_name_code . "%");
        });

        if ($is_active == 'on') {
            $query->where('status', true);
        }

        if (count($sickFundIds) > 0)
            $query->whereHas('imageCodes', function ($subQuery) use ($sickFundIds) {
                $subQuery->whereIn('sick_fund_id', $sickFundIds);
            });


        $images = $query->get();
        return view('images.export', [
            'images' => $images
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
