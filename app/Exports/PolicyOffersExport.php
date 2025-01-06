<?php

namespace App\Exports;

use App\Models\Client;

use App\Models\PolicyOffer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PolicyOffersExport implements FromView, WithStyles
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

        $policyOffers = PolicyOffer::with('policyOffer_types', 'vehicle', 'insuranceCompany', 'captin', 'status')
            ->withCount('attachments');

        // return  $policyOffers->get();

        if ($parm) {
            $search_params =$parm;


            if (array_key_exists('vehicle_type', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['vehicle_type']);
                if (count($results) > 0)
                    $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                        $query->whereIn('vehicle_type', $results);
                    });
            }

            if (array_key_exists('car_brand', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['car_brand']);
                if (count($results) > 0)
                    $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                        $query->whereIn('car_brand', $results);
                    });
            }
            if (array_key_exists('fuel_type', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['fuel_type']);
                if (count($results) > 0)
                    $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                        $query->whereIn('fuel_type', $results);
                    });
            }
            if (array_key_exists('motor_cc', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['motor_cc']);
                if (count($results) > 0)
                    $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                        $query->whereIn('motor_cc', $results);
                    });
            }
            if ($search_params['license_expire_date2'] != null) {
                $date = explode('to', $search_params['license_expire_date2']);
                if (count($date) == 1) $date[1] = $date[0];
                $policyOffers->orwhereHas('vehicle', function ($query) use ($date) {
                    $query->whereBetween('license_expire_date2', [$date[0], $date[1]]);
                });

            }

            if ($search_params['policy_expire'] != null) {
                $date = explode('to', $search_params['policy_expire']);
                if (count($date) == 1) $date[1] = $date[0];
                $policyOffers->orwhereHas('vehicle', function ($query) use ($date) {
                    $query->whereBetween('policy_expire', [$date[0], $date[1]]);
                });

            }

            if ($search_params['is_active'] != null) {
                $status = $search_params['is_active'] == "YES" ? 1 : 0;
                $policyOffers->where('active', $status);
            }


            /*     if ($search_params['has_insurance'] != null) {
                     $status = $search_params['has_insurance'] == "YES" ? 1 : 0;
                     $policyOffers->where('has_insurance', $status);
                 }*/


            if ($search_params['search'] != null) {
                $value = $search_params['search'];
                $policyOffers->where(function ($q) use ($value) {
                    $q->orwhereHas('vehicle', function ($query) use ($value) {
                        $query->where('chassis_no', 'like', "%" . $value . "%");
                        $query->orwhere('vehicles.box_no', 'like', "%" . $value . "%");
                        $query->orwhere('vehicles.policyOffer_no', 'like', "%" . $value . "%");
                    });
                    $q->orwhereHas('captin', function ($query) use ($value) {
                        $query->where('captins.name', 'like', "%" . $value . "%");
                    });
                });
            }


        }















        $policyOffers = $policyOffers->get();
       // return $clients;
        return view('policyOffers.export', [
            'policyOffers' => $policyOffers
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
