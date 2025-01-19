<?php

namespace App\Exports;

use App\Models\HospitalClinicTeam;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HospitalClinicAllTeamsExport implements FromView, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        //
        $query = HospitalClinicTeam::query()
            ->with('hospitalClinic')
            ->with('hospitalClinic.hospital')
            ->with('contactType')
            ->with('titleType')
            ->with('department')
            ->with('workingShift');

        $hospitalClinicTeams = $query->get();
        return view('hospitals.clinics.exportTeams', [
            'hospitalClinicTeams' => $hospitalClinicTeams
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
