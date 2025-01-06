<?php

namespace App\Exports;

use App\Models\Visit;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitExport implements FromView, WithStyles
{
    private $parm;

    function __construct(
        $parm

    ) {
        $this->parm = $parm;

    }
    public function filterArrayForNullValues($array)
    {
        if(!is_array($array))
            $array=explode(',',$array);
        $filteredArray = array_filter($array, function ($value) {
            return $value !== '';
        });
        return $filteredArray;
    }



    public function view(): View
    {


        $parm = $this->parm;

        $visits = Visit::with('cities', 'categories', 'priorities', 'visit_types', 'periods', 'statuses', 'employees');

        //return  $visits->get();

        if ($parm) {
            $search_params = $parm;

            if (array_key_exists('city_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['city_id']);
                if (count($results) > 0)
                    $visits->whereIn('city_id', $results);

            }
            if (array_key_exists('source', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['source']);
                if (count($results) > 0)
                    $visits->whereIn('source', $results);

            }
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

            if (array_key_exists('period', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['period']);
                if (count($results) > 0)
                    $visits->whereIn('period', $results);

            }
            if (array_key_exists('rate_company', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['rate_company']);
                if (count($results) > 0)
                    $visits->whereIn('rate_company', $results);

            }
            if (array_key_exists('rate_captin', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['rate_captin']);
                if (count($results) > 0)
                    $visits->whereIn('rate_captin', $results);

            }
            if (array_key_exists('status', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['status']);
                if (count($results) > 0)
                    $visits->whereIn('status', $results);

            }
            if ($search_params['telephone'] != '') {
                $visits->where('telephone', 'like', '%' . $search_params['telephone'] . '%');
            }

            if ($search_params['visit_date'] != '') {
                $date = explode('to', $search_params['visit_date']);
                if (count($date) == 1) $date[1] = $date[0];
                $visits->whereBetween('visit_date', [$date[0], $date[1]]);
            }

        }
        $visits = $visits->get();
        // return $visits;
        return view('visits.export', [
            'visits' => $visits
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
