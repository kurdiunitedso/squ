<?php

namespace App\Exports;

use App\Models\Review;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Log;
class ReviewsExport implements FromView, WithStyles
{
    private $parm;

    function __construct(
        $parm

    )
    {
        $this->parm = $parm;

    }

    public function filterArrayForNullValues($array)
    {
        if($array=='undefined')
            return [];
        if (!is_array($array))
            $array = explode(',', $array);
        $filteredArray = array_filter($array, function ($value) {
            return $value !== '';
        });
        return $filteredArray;
    }


    public function view(): View
    {

        $reviews = Review::with('city')->select('reviews.*');

        $parm = $this->parm;



        if ($parm) {
            $search_params = $parm;
            if ($search_params['is_active'] != null) {
                $status = $search_params['is_active'] == "YES" ? true : false;
                $reviews->where('active', $status);
            }

            if ($search_params['created_at'] != null) {
                $date = explode('to', $search_params['created_at']);
                if (count($date) == 1) $date[1] = $date[0];
                $reviews->whereBetween('created_at', [$date[0], $date[1]]);
            }

        }


        $reviews = $reviews->get();
        // return $clients;
        return view('reviews.export', [
            'reviews' => $reviews
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
