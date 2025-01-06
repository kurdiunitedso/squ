<?php

namespace App\Exports;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\EmployeeVacation;
use App\Models\vacation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MyVacationsExport implements FromView, WithStyles
{
    private $parm;

    function __construct(
        $parm

    ) {
        $this->parm = $parm;

    }
    public function filterArrayForNullValues($array)
    {
        if(!is_array($array))
            $array=explode(',',$array);
        $filteredArray = array_filter($array, function ($value) {
            return $value !== '';
        });
        return $filteredArray;
    }



    public function view(): View
    {


        $parm = $this->parm;
        $employee=Employee::where('user_id',Auth::user()->id)->get()->first();
        $vacations = EmployeeVacation::with('statuss', 'types', 'employees')->where('employee_id',$employee->id);



        if ($parm) {
            $search_params = $parm;


            if ($search_params['from_date'] != null) {
                $date = explode('to', $search_params['from_date']);
                if (count($date) == 1) $date[1] = $date[0];
                $vacations->whereBetween('from_date', [$date[0], $date[1]]);
            }

            if (array_key_exists('status', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['status']);
                if (count($results) > 0)
                    $vacations->whereIn('status', $results);

            }
            if (array_key_exists('type', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['type']);
                if (count($results) > 0)
                    $vacations->whereIn('type', $results);

            }
            if (array_key_exists('employee_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['employee_id']);
                if (count($results) > 0)
                    $vacations->whereIn('employee_id', $results);

            }

        }

        $vacations = $vacations->get();
       // return $vacations;
        return view('myvacations.export', [
            'vacations' => $vacations
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
