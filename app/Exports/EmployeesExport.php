<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\EmployeeWhour;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesExport implements FromView, WithStyles
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

        $employees = Employee::
        select('employees.*')->with('user')
        ;
        // return  $employees->get();

        if ($parm) {
            $search_params = $parm;


            if ($search_params['search'] != null) {
                $value = $search_params['search'];
                $employees->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%" . $value . "%");
                    $q->orwhere('telephone', 'like', "%" . $value . "%");

                });
            }


        }
        $employees = $employees->get();
        // return $vehicles;
        return view('employees.export', [
            'employees' => $employees
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
