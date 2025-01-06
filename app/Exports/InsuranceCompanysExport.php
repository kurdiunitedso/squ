<?php

namespace App\Exports;

use App\Models\InsuranceCompany;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InsuranceCompanysExport implements FromView, WithStyles
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
        $insuranceCompanys = InsuranceCompany::with('bank_names', 'type')->withCount('branches')->withCount('teams');

        if ($parm) {
            $search_params = $parm;


            if ($search_params['type_id'] != null) {
                $insuranceCompanys->where('type_id', $search_params['type_id']);
            }

            if ($search_params['is_active'] != null) {
                $status = $search_params['is_active'] == "YES" ? 1 : 0;
                $insuranceCompanys->where('active', $status);
            }


            if ($search_params['created_at'] != null) {
                $date = explode('to', $search_params['created_at']);
                if (count($date) == 1) $date[1] = $date[0];
                $insuranceCompanys->whereBetween('created_at', [$date[0], $date[1]]);
            }


            if ($search_params['has_teams'] != null) {
                $status = $search_params['has_teams'] == "YES" ? '>' : '=';
                $insuranceCompanys->where('teams_count', $status, 0);
            }
            if ($search_params['has_branches'] != null) {
                $status = $search_params['has_branches'] == "YES" ? '>' : '=';
                $insuranceCompanys->where('branches_count', $status, 0);
            }
            if ($search_params['search'] != null) {
                $value = $search_params['search'];
                $insuranceCompanys->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%" . $value . "%");
                    $q->orwhere('telephone', 'like', "%" . $value . "%");
                    $q->orwhere('registration_no', 'like', "%" . $value . "%");
                });
            }


        }


        $insuranceCompanys = $insuranceCompanys->get();
        // return $insuranceCompanys;
        return view('insuranceCompanys.export', [
            'insuranceCompanys' => $insuranceCompanys
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
