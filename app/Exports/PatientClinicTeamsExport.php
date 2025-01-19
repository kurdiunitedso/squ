<?php

namespace App\Exports;

use App\Models\PatientClinic;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientClinicTeamsExport implements FromView, WithStyles
{
    private $name;
    private $sick_fund_id;
    private $branch_id;
    private $has_team;
    function __construct(
        $name,
        $sick_fund_id,
        $branch_id,
        $has_team
    ) {
        $this->name = $name;
        $this->sick_fund_id = $sick_fund_id;
        $this->branch_id = $branch_id;
        $this->has_team = $has_team;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        //

        $name = $this->name;
        $sick_fund_id = $this->sick_fund_id;
        $branch_id = $this->branch_id;
        $has_team = $this->has_team;

        $query = PatientClinic::with('sickFund', 'branch')
            ->withCount('teams')
            ->with('teams');

        $query->where(function ($q) use ($name) {
            $q->where('name', 'like', "%" . $name . "%");
            $q->orWhere('name_en', 'like', "%" . $name . "%");
            $q->orWhere('name_he', 'like', "%" . $name . "%");
        });

        if ($has_team != null) {
            $status = $has_team == "YES" ? true : false;
            if ($status)
                $query->having('teams_count', '>', 0);
            else
                $query->having('teams_count', '=', 0);
        }

        if ($sick_fund_id && count($sick_fund_id) > 0)
            $query->whereIn('sick_fund_id', $sick_fund_id);


        if ($branch_id != null) {
            $query->where('branch_id', $status);
        }

        $patientClinics = $query->get();
        return view('PatientClinics.exportTeams', [
            'patientClinics' => $patientClinics
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
