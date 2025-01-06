<?php

namespace App\Exports;

use App\Models\EmployeeWhour;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesWhourTSExport implements FromView, WithStyles
{
    private $parm;

    function __construct(
        $parm, $employee

    )
    {
        $this->parm = $parm;
        $this->employee = $employee;
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
        $employee = $this->employee;
        $whours = EmployeeWhour::with('statuss')->where('employee_id', $employee);

        // return  $vehicles->get();
        if ($parm) {
            $search_params = $parm;

            if ($search_params['work_date'] != null) {
                $date = explode('to', $search_params['work_date']);
                if (count($date) == 1) $date[1] = $date[0];
                $whours->whereBetween('work_date', [$date[0], $date[1]]);
            }

        }


        $whours = $whours->get();
        // return $vehicles;
        return view('employees.working_hours.export', [
            'whours' => $whours
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
