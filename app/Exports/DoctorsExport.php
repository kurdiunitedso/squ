<?php

namespace App\Exports;

use App\Models\Doctor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DoctorsExport implements FromView, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $name;
    private $sick_funds;
    private $patient_clinic_id;
    private $has_schedule;
    private $is_active;

    function __construct(
        $name,
        $sick_funds,
        $patient_clinic_id,
        $has_schedule,
        $is_active,
    ) {
        $this->name = $name;
        $this->sick_funds = $sick_funds;
        $this->patient_clinic_id = $patient_clinic_id;
        $this->has_schedule = $has_schedule;
        $this->is_active = $is_active;
    }


    public function view(): View
    {
        //

        $name = $this->name;
        $sick_fund_id = $this->sick_funds;
        $patient_clinic_id = $this->patient_clinic_id;
        $has_schedule = $this->has_schedule;
        $is_active = $this->is_active;


        $query = Doctor::with(
            'speciality',
            'hospital',
            'patientClinic',
            'country',
            'city',
            'schedule'
        );

        $query->where(function ($q) use ($name) {
            $q->where('name', 'like', "%" . $name . "%");
            $q->orWhere('name_en', 'like', "%" . $name . "%");
            $q->orWhere('name_he', 'like', "%" . $name . "%");
        });

        if ($has_schedule != null) {
            $status = $has_schedule == "YES" ? true : false;
            $query->where('has_schedule', $status);
        }

        if ($is_active != null) {
            $status = $is_active == "YES" ? true : false;
            $query->where('status', $status);
        }
        if ($sick_fund_id != null) {
            $query->whereHas('patientClinic', function ($subQuery) use ($sick_fund_id) {
                $subQuery->where('sick_fund_id', $sick_fund_id);
            });
        }

        if ($patient_clinic_id != null) {
            $query->where('patient_clinic_id', $patient_clinic_id);
        }


        $doctors = $query->get();
        return view('doctors.export', [
            'doctors' => $doctors
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
