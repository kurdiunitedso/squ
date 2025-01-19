<?php

namespace App\Exports;

use App\Models\ExternalAppointment;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExternalAppointmentReportExport implements FromView, WithStyles
{


    private $appointment_id;


    /**
     * @return \Illuminate\Support\Collection
     */


    function __construct(
        $appointment_id,

    ) {
        $this->appointment_id = $appointment_id;

    }

    public function view(): View
    {


        $appointment_id = $this->appointment_id;
        $appointment = ExternalAppointment::find($appointment_id);
        $patient=Patient::find($appointment->patient_id);

        return view('externalAppointments.export.appointmentLetter', [
            'appointment' => $appointment,"patient"=>$patient
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
