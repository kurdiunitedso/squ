<?php

namespace App\Exports;

use App\Models\HospitalClinic;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HospitalClinicsExport implements FromView, WithStyles
{

    private $name;
    private $hospital_id;
    private $has_team;
    private $is_active;

    function __construct(
        $name,
        $hospital_id,
        $has_team,
        $is_active,
    ) {
        $this->name = $name;
        $this->hospital_id = $hospital_id;
        $this->has_team = $has_team;
        $this->is_active = $is_active;
    }


    public function view(): View
    {
        //
        $name = $this->name;
        $hospital_id = $this->hospital_id;
        $has_team = $this->has_team;
        $is_active = $this->is_active;

        $query = HospitalClinic::with('hospital', 'department', 'serviceType')
            ->withCount('teams')
            ->with('imageTypes')
            ->with('imageTypes.image')
            ->with('imageTypes.image.imageCodes')
            ->with('teams');

        $query->where(function ($q) use ($name) {
            $q->where('name', 'like', "%" . $name . "%");
            $q->orWhere('name_en', 'like', "%" . $name . "%");
            $q->orWhere('name_he', 'like', "%" . $name . "%");
        });

        if ($hospital_id != null) {
            $query->where('hospital_id', $hospital_id);
        }
        if ($has_team != null) {
            $status = $has_team == "YES" ? true : false;
            if ($status)
                $query->having('teams_count', '>', 0);
            else
                $query->having('teams_count', '=', 0);
        }

        if ($is_active != null) {
            $status = $is_active == "YES" ? true : false;
            $query->where('status', $status);
        }

        $hospitalClinics = $query->get();
        return view('hospitals.clinics.exportClinics', [
            'hospitalClinics' => $hospitalClinics
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
