<?php

namespace App\Exports;

use App\Models\ClientCallAction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientCallActionsExport implements FromView, WithStyles
{


    private $name;
    private $call_option_id;
    private $employee_id;
    private $call_date;
    private $is_active;


    public function __construct(
        $name,
        $call_option_id,
        $employee_id,
        $call_date,
        $is_active
    ) {
        $this->name = $name;
        $this->call_option_id = $call_option_id;
        $this->employee_id = $employee_id;
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
        $employee_id = $this->employee_id;
        $call_date = $this->call_date;
        $is_active = $this->is_active;

        $query = ClientCallAction::with(
            'employee',
            'callOption',

        )->select('client_call_actions.*');






        if ($call_option_id != null) {
            $query->where('call_option_id', $call_option_id);
        }



        if ($employee_id != null) {
            $query->where('employee_id', $employee_id);
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

        $clientCallActions = $query->get();


        return view('clientCallActions.export', [
            'clientCallActions' => $clientCallActions
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
