<?php

namespace App\Exports;

use App\Models\Client;

use App\Models\ClientTrillion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientTrillionsExport implements FromView, WithStyles
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


        $parm = $this->parm;

        $clientTrillions = ClientTrillion
            ::with('city', 'type', 'country')
            ->withCount('teams')
            ->withCount('attachments')
            ->withCount('socials');


        if ($parm) {
            $search_params = $parm;
            if (array_key_exists('country_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['country_id']);
                if (count($results) > 0)
                    $clientTrillions->whereIn('country_id', $results);

            }
            if (array_key_exists('ids', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['ids']);
                if (count($results) > 0)
                    $clientTrillions->whereIn('id', $results);

            }
            if (array_key_exists('city_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['city_id']);
                if (count($results) > 0)
                    $clientTrillions->whereIn('city_id', $results);

            }

            if (array_key_exists('company_type', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['company_type']);
                if (count($results) > 0)
                    $clientTrillions->whereIn('company_type', $results);
                //$clientTrillions->where('category', $search_params['category']);
            }


            if ($search_params['has_attachments'] == 'Yes') {
                $clientTrillions->where('attachments_count', '>=', 1);
            }
            if ($search_params['has_socials']  == 'Yes') {
                $clientTrillions->where('socials_count', '>=', 1);
            }
            if ($search_params['has_teams']  == 'Yes') {
                $clientTrillions->where('teams_count', '>=', 1);
            }

            if (array_key_exists('attachment_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['attachment_id']);
                if (count($results) > 0)
                    $clientTrillions->attachments->whereIn('attachment_type_id', $results);
            }


            if ($search_params['created_at'] != null) {
                $date = explode('to', $search_params['created_at']);
                if (count($date) == 1) $date[1] = $date[0];
                $clientTrillions->whereBetween('created_at', [$date[0], $date[1]]);
            }


            if ($search_params['search'] != null) {
                $value = $search_params['search'];
                $clientTrillions->where(function ($q) use ($value) {
                    $q->where('registration_number', 'like', "%" . $value . "%");
                    $q->orwhere('registration_name', 'like', "%" . $value . "%");
                    $q->orwhere('telephone', 'like', "%" . $value . "%");
                    $q->orwhere('clientTrillion_id', 'like', "%" . $value . "%");
                });
            }

        }


        $clientTrillions = $clientTrillions->get();
        // return $clients;
        return view('clientTrillions.export', [
            'clientTrillions' => $clientTrillions
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
