<?php

namespace App\Exports;

use App\Models\InternalAppointment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class InternalAppointmentExport  implements FromView, WithStyles
{

    private $name_code;
    private $sick_fund_id;
    private $branch_id;
    private $hospital_id;
    private $patient_clinic_id;
    private $hospital_clinic_id;
    private $doctor_id;
    private $speciality_id;
    private $service_type_id;
    private $appointment_status;
    private $appointment_date;
    private $created_date;

    public function __construct(
        $name_code,
        $sick_fund_id,
        $branch_id,
        $hospital_id,
        $patient_clinic_id,
        $hospital_clinic_id,
        $doctor_id,
        $speciality_id,
        $service_type_id,
        $appointment_status,
        $appointment_date,
        $created_date,


    ) {
        $this->name_code = $name_code;
        $this->sick_fund_id = $sick_fund_id;
        $this->branch_id = $branch_id;
        $this->hospital_id = $hospital_id;
        $this->patient_clinic_id = $patient_clinic_id;
        $this->hospital_clinic_id = $hospital_clinic_id;
        $this->doctor_id = $doctor_id;
        $this->speciality_id = $speciality_id;
        $this->service_type_id = $service_type_id;
        $this->appointment_status = $appointment_status;
        $this->appointment_date = $appointment_date;
        $this->created_date = $created_date;
    }


    public function view($type=0): View
    {

        $name_code = $this->name_code;
        $sick_fund_id = $this->sick_fund_id;
        $branch_id = $this->branch_id;
        $hospital_id = $this->hospital_id;
        $patient_clinic_id = $this->patient_clinic_id;
        $hospital_clinic_id = $this->hospital_clinic_id;
        $doctor_id = $this->doctor_id;
        $speciality_id = $this->speciality_id;
        $service_type_id = $this->service_type_id;
        $appointment_status = $this->appointment_status;
        $appointment_date = $this->appointment_date;
        $created_date = $this->created_date;

        $query = InternalAppointment::with(
            'patient',
            'patientClinic',
            'doctor',
            'speciality',
            'serviceType',
            'source',
        )->select('internal_appointments.*');

        $query->whereHas('patient', function ($patientQuery) use ($name_code) {
            $patientQuery->where(function ($q) use ($name_code) {
                $q->where('name', 'like', "%" . $name_code . "%");
                $q->orWhere('name_en', 'like', "%" . $name_code . "%");
                $q->orWhere('name_he', 'like', "%" . $name_code . "%");
                $q->orWhere('idcard_no', 'like', "%" . $name_code . "%");
                $q->orWhere('mobile', 'like', "%" . $name_code . "%");
            });
        });


        if ($branch_id != null) {
            $query->whereHas('patient',  function ($patientQuery) use ($branch_id) {
                $patientQuery->where('branch_id', $branch_id);
            });
        }
        if ($sick_fund_id != null) {
            $query->whereHas('patient',  function ($patientQuery) use ($sick_fund_id) {
                $patientQuery->where('sick_fund_id', $sick_fund_id);
            });
        }

        if ($doctor_id != null) {
            $query->where('doctor_id', $doctor_id);
        }

        if ($patient_clinic_id != null) {
            $query->where('patient_clinic_id', $patient_clinic_id);
        }

        if ($speciality_id != null) {
            $query->where('speciality_id', $speciality_id);
        }


        if ($service_type_id != null) {
            $query->whereHas('doctor',  function ($doctorQuery) use ($service_type_id) {
                $doctorQuery->where('service_type_id', $service_type_id);
            });
        }

        if ($hospital_id != null) {
            $query->whereHas('doctor',  function ($doctorQuery) use ($hospital_id) {
                $doctorQuery->where('hospital_id', $hospital_id);
            });
        }


        if ($hospital_clinic_id != null) {
            $query->whereHas('doctor',  function ($doctorQuery) use ($hospital_clinic_id) {
                $doctorQuery->whereHas('hospital', function ($hospitalQuery) use ($hospital_clinic_id) {
                    $hospitalQuery->whereHas('hospitalClinic', function ($hospitalClinicQuery) use ($hospital_clinic_id) {
                        $hospitalClinicQuery->where('id', $hospital_clinic_id);
                    });
                });
            });
        }


        if ($appointment_status != null) {
            $query->where('status', $appointment_status);
        }

        if ($appointment_date != null) {
            $date = explode('to', $appointment_date);
            if (count($date) == 1) $date[1] = $date[0];
            $query->whereBetween('appointment_date_start', [$date[0], $date[1]]);
        }
        if ($created_date != null) {
            $date = explode('to', $created_date);
            if (count($date) == 1) $date[1] = $date[0];
            $query->whereBetween('created_at', [$date[0], $date[1]]);
        }

        $internalAppointments =  $query->get();
        if($type==2)
        return view('internalAppointments.export2', [
            'internalAppointments' => $internalAppointments
        ]);
        return view('internalAppointments.export', [
            'internalAppointments' => $internalAppointments
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
