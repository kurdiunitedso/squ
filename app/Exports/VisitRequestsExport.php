<?php

namespace App\Exports;

use App\Models\Visit;

use App\Models\VisitRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitRequestsExport implements FromView, WithStyles
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
        if (!is_array($array))
            $array = explode(',', $array);
        $filteredArray = array_filter($array, function ($value) {
            return $value !== '';
        });
        return $filteredArray;
    }


    public function view(): View
    {


        $parm = $this->parm;

        $visits = VisitRequest::with('categories', 'priorities', 'visit_types', 'statuses', 'employees')
            ->withCount('visits');

        //return  $visits->get();

        if ($parm) {
            $search_params = $parm;


            if (array_key_exists('status', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['status']);
                if (count($results) > 0)
                    $visits->whereIn('status', $results);

            }
            if (array_key_exists('category', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['category']);
                if (count($results) > 0)
                    $visits->whereIn('category', $results);

            }


            if ($search_params['telephone'] != null) {
                $visits->where('telephone', 'like', '%' . $search_params['telephone'] . '%');
            }

            if ($search_params['created_at'] != null) {
                $date = explode('to', $search_params['created_at']);
                if (count($date) == 1) $date[1] = $date[0];
                $visits->whereBetween('created_at', [$date[0], $date[1]]);
            }

        }
        $visits = $visits->get();
        // return $visits;
        return view('visitRequests.export', [
            'visits' => $visits
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
