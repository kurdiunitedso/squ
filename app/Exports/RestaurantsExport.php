<?php

namespace App\Exports;

use App\Models\Restaurant;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RestaurantsExport implements FromView, WithStyles
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

        $restaurants = Restaurant::with('country', 'cities', 'posTypes', 'types')->withCount('tickets')->withCount('visits')->withCount('attachments')->withCount('employees')->withCount('branches');

        if ($parm) {
            $search_params = $parm;


            if (array_key_exists('country_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['country_id']);
                if (count($results) > 0)
                    $restaurants->whereIn('country_id', $results);

            }
            if (array_key_exists('city_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['city_id']);
                if (count($results) > 0)
                    $restaurants->whereIn('city_id', $results);

            }

            if (array_key_exists('type_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['type_id']);
                if (count($results) > 0)
                    $restaurants->whereIn('type_id', $results);

            }


            if (array_key_exists('pos_type', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['pos_type']);
                if (count($results) > 0)
                    $restaurants->whereIn('pos_type', $results);

            }

            if ($search_params['is_active'] != null) {
                $status = $search_params['is_active'] == "YES" ? 1 : 0;
                $restaurants->where('active', $status);
            }
            if ($search_params['has_bot'] != null) {
                $status = $search_params['has_bot'] == "YES" ? 1 : 0;
                $restaurants->where('has_wheels_bot', $status);
            }
            if ($search_params['has_b2b'] != null) {
                $status = $search_params['has_b2b'] == "YES" ? 1 : 0;
                $restaurants->where('has_wheels_b2b', $status);
            }
            if ($search_params['has_pos'] != null) {
                $status = $search_params['has_pos'] == "YES" ? 1 : 0;
                $restaurants->where('has_pos', $status);
            }
            if ($search_params['has_now'] != null) {
                $status = $search_params['has_now'] == "YES" ? 1 : 0;
                $restaurants->where('has_wheels_now', $status);
            }
            if ($search_params['has_marketing'] != null) {
                $status = $search_params['has_marketing'] == "YES" ? 1 : 0;
                $restaurants->where('has_marketing', $status);
            }
            if ($search_params['has_now'] != null) {
                $status = $search_params['has_now'] == "YES" ? 1 : 0;
                $restaurants->where('has_wheels_now', $status);
            }
            if ($search_params['has_menu'] != null) {
                $status = $search_params['has_menu'] == "YES" ? '>' : '=';
                $restaurants->where('items_count', $status, 0);
            }
            if ($search_params['has_employees'] != null) {
                $status = $search_params['has_employees'] == "YES" ? '>' : '=';
                $restaurants->where('employees_count', $status, 0);
            }
            if ($search_params['has_branches'] != null) {
                $status = $search_params['has_branches'] == "YES" ? '>' : '=';
                $restaurants->where('branches_count', $status, 0);
            }
            if ($search_params['search'] != null) {
                $value=$search_params['search'];
                $restaurants->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%" . $value . "%");
                    $q->orwhere('restaurant_id', 'like', "%" . $value . "%");
                    $q->orwhere('id_wheel', 'like', "%" . $value . "%");
                    $q->orwhere('telephone', 'like', "%" . $value . "%");
                    //$q->orwhere(DB::raw('(select group_concat(restaurant_branches.telephone) from restaurant_branches where restaurant_branches.restaurant_id=restaurants.id)'), 'like', "%" . $value . "%");
                    // $q->orwhere(DB::raw('(select group_concat(restaurant_employees.mobile) from restaurant_employees where restaurant_employees.restaurant_id=restaurants.id)'), 'like', "%" . $value . "%");
                });
            }


        }














        $restaurants = $restaurants->get();
        // return $restaurants;
        return view('Restaurants.export', [
            'restaurants' => $restaurants
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
