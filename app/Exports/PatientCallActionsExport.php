<?php

namespace App\Exports;

use App\Models\PatientCallAction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientCallActionsExport implements FromView, WithStyles
{


    private $name;
    private $call_option_id;
    private $call_action_id;
    private $employee_id;
    private $module_id;
    private $call_date;
    private $is_active;


    public function __construct(
        $name,
        $call_option_id,
        $call_action_id,
        $employee_id,
        $module_id,
        $call_date,
        $is_active
    ) {
        $this->name = $name;
        $this->call_option_id = $call_option_id;
        $this->call_action_id = $call_action_id;
        $this->employee_id = $employee_id;
        $this->module_id = $module_id;
        $this->call_date = $call_date;
        $this->is_active = $is_active;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {


        $name = $this->name;
        $call_option_id = $this->call_option_id;
        $call_action_id = $this->call_action_id;
        $employee_id = $this->employee_id;
        $module_id = $this->module_id;
        $call_date = $this->call_date;
        $is_active = $this->is_active;

        $query = PatientCallAction::with(
            'patient',
            'employee',
            'callOption',
            'action',
        )->select('patient_call_actions.*');


        $query->whereHas('patient', function ($subQuery) use ($name) {
            $subQuery->where('name', 'like', "%" . $name . "%");
            $subQuery->orWhere('name_en', 'like', "%" . $name . "%");
            $subQuery->orWhere('name_he', 'like', "%" . $name . "%");
            $subQuery->orWhere('idcard_no', 'like', "%" . $name . "%");
            $subQuery->orWhere('mobile', 'like', "%" . $name . "%");
        });



        if ($call_option_id != null) {
            $query->where('call_option_id', $call_option_id);
        }

        if ($call_action_id != null) {
            $query->where('call_action', $call_action_id);
        }

        if ($employee_id != null) {
            $query->where('employee_id', $employee_id);
        }

        if ($module_id != null) {
            $query->where('action_type', $module_id);
        }

        if ($call_date != null) {
            $date = explode('to', $call_date);
            if (count($date) == 1) $date[1] = $date[0];
            $query->whereBetween('created_at', [$date[0], $date[1]]);
        }

        if ($is_active != null) {
            $status = $is_active == "YES" ? true : false;
            $query->where('status', $status);
        }

        $patientCallActions = $query->get();


        return view('patientCallActions.export', [
            'patientCallActions' => $patientCallActions
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
