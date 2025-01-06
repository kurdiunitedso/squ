<?php

namespace App\Exports;

use App\Models\CallTask;
use App\Models\ClientCallAction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CallTasksExport implements FromView, WithStyles
{




    public function __construct(

    ) {

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {




        $query = $callTasks = CallTask::with(
            'call',
            'task_statuss',
            'task_urgencys',
            'task_employees',

        )->select('*');



        $calls = $query->get();


        return view('callTasks.export', [
            'calls' => $calls
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
