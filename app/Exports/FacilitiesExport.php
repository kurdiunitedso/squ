<?php

namespace App\Exports;

use App\Models\Facility;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilitiesExport implements FromView, WithStyles
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

        $facilities = Facility::with('country', 'cities', 'posTypes', 'types','category')->withCount('tickets')->withCount('visits')->withCount('attachments')->withCount('employees')->withCount('branches');

        if ($parm) {
            $search_params = $parm;


            if (array_key_exists('country_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['country_id']);
                if (count($results) > 0)
                    $facilities->whereIn('country_id', $results);

            }
            if (array_key_exists('city_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['city_id']);
                if (count($results) > 0)
                    $facilities->whereIn('city_id', $results);

            }

            if (array_key_exists('type_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['type_id']);
                if (count($results) > 0)
                    $facilities->whereIn('type_id', $results);

            }
            if (array_key_exists('category_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['category_id']);
                if (count($results) > 0)
                    $facilities->whereIn('category_id', $results);

            }


            if (array_key_exists('pos_type', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['pos_type']);
                if (count($results) > 0)
                    $facilities->whereIn('pos_type', $results);

            }

            if ($search_params['is_active'] != null) {
                $status = $search_params['is_active'] == "YES" ? 1 : 0;
                $facilities->where('active', $status);
            }
            if ($search_params['has_bot'] != null) {
                $status = $search_params['has_bot'] == "YES" ? 1 : 0;
                $facilities->where('has_wheels_bot', $status);
            }
            if ($search_params['has_b2b'] != null) {
                $status = $search_params['has_b2b'] == "YES" ? 1 : 0;
                $facilities->where('has_wheels_b2b', $status);
            }
            if ($search_params['has_pos'] != null) {
                $status = $search_params['has_pos'] == "YES" ? 1 : 0;
                $facilities->where('has_pos', $status);
            }
            if ($search_params['has_now'] != null) {
                $status = $search_params['has_now'] == "YES" ? 1 : 0;
                $facilities->where('has_wheels_now', $status);
            }
            if ($search_params['has_marketing'] != null) {
                $status = $search_params['has_marketing'] == "YES" ? 1 : 0;
                $facilities->where('has_marketing', $status);
            }
            if ($search_params['has_now'] != null) {
                $status = $search_params['has_now'] == "YES" ? 1 : 0;
                $facilities->where('has_wheels_now', $status);
            }
            if ($search_params['has_menu'] != null) {
                $status = $search_params['has_menu'] == "YES" ? '>' : '=';
                $facilities->where('items_count', $status, 0);
            }
            if ($search_params['has_employees'] != null) {
                $status = $search_params['has_employees'] == "YES" ? '>' : '=';
                $facilities->where('employees_count', $status, 0);
            }
            if ($search_params['has_branches'] != null) {
                $status = $search_params['has_branches'] == "YES" ? '>' : '=';
                $facilities->where('branches_count', $status, 0);
            }
            if ($search_params['search'] != null) {
                $value=$search_params['search'];
                $facilities->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%" . $value . "%");
                    $q->orwhere('facility_id', 'like', "%" . $value . "%");
                    $q->orwhere('id_wheel', 'like', "%" . $value . "%");
                    $q->orwhere('telephone', 'like', "%" . $value . "%");
                    //$q->orwhere(DB::raw('(select group_concat(facility_branches.telephone) from facility_branches where facility_branches.facility_id=facilities.id)'), 'like', "%" . $value . "%");
                    // $q->orwhere(DB::raw('(select group_concat(facility_employees.mobile) from facility_employees where facility_employees.facility_id=facilities.id)'), 'like', "%" . $value . "%");
                });
            }


        }














        $facilities = $facilities->get();
        // return $facilities;
        return view('Facilities.export', [
            'facilities' => $facilities
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
