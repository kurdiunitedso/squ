<?php

namespace App\Exports;

use App\Models\Ticket;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements FromView, WithStyles
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

        $tickets = Ticket::with('cities', 'categories', 'priorities', 'ticket_types', 'purposes', 'statuses', 'employees');

        //return  $tickets->get();

        if ($parm) {
            $search_params = $parm;

            if (array_key_exists('ids', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['ids']);
                if (count($results) > 0)
                    $tickets->whereIn('id', $results);

            }
            if (array_key_exists('city_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['city_id']);
                if (count($results) > 0)
                    $tickets->whereIn('city_id', $results);

            }


            if (array_key_exists('source', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['source']);
                if (count($results) > 0)
                    $tickets->whereIn('source', $results);

            }

            if (array_key_exists('status', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['status']);
                if (count($results) > 0)
                    $tickets->whereIn('status', $results);

            }


            if (array_key_exists('category', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['category']);
                if (count($results) > 0)
                    $tickets->whereIn('category', $results);

            }

            if (array_key_exists('purpose', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['purpose']);
                if (count($results) > 0)
                    $tickets->whereIn('purpose', $results);

            }


            if (array_key_exists('priority', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['priority']);
                if (count($results) > 0)
                    $tickets->whereIn('priority', $results);

            }


            if (array_key_exists('status', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['status']);
                if (count($results) > 0)
                    $tickets->whereIn('status', $results);

            }
            if ($search_params['telephone'] != null) {
                $tickets->where('telephone', 'like', '%' . $search_params['telephone'] . '%');
            }

            if ($search_params['ticket_date'] != null) {
                $date = explode('to', $search_params['ticket_date']);
                if (count($date) == 1) $date[1] = $date[0];
                $tickets->whereBetween('ticket_date', [$date[0], $date[1]]);
            }

        }
        $tickets=$tickets->get();
        // return $tickets;
        return view('tickets.export', [
            'tickets' => $tickets
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
