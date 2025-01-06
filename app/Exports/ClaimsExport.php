<?php

namespace App\Exports;

use App\Models\Claim;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClaimsExport implements FromView, WithStyles
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
        $claims = Claim::with('items', 'client', 'status', 'type','currencys')->withCount('attachments')->withCount('items');

        if ($parm) {
            $search_params = $parm;


            if (array_key_exists('type_id', $search_params)) {
                $results = $search_params['type_id'];
               // $results = im(',', $results);
                $claims->where('types', 'like', '%' . $results . '%');

            }
            if (array_key_exists('status', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['status']);
                if (count($results) > 0) {
                    $claims->whereIn('status_id', $results);

                }
            }
            if ($search_params['is_active'] != null) {
                $status = $search_params['is_active'] == "YES" ? 1 : 0;
                $claims->where('active', $status);


            }
            if ($search_params['is_submit'] != null) {
                $status = $search_params['is_submit'] == "YES" ? 1 : 0;
                $claims->where('submit', $status);


            }
            if ($search_params['is_paid'] != null) {
                $status = $search_params['is_paid'] == "YES" ? 1 : 0;
                $claims->where('paid', $status);

            }


            if ($search_params['created_at'] != null) {
                $date = explode('to', $search_params['created_at']);
                if (count($date) == 1) $date[1] = $date[0];
                $claims->whereBetween('created_at', [$date[0], $date[1]]);

            }
            if ($search_params['payment_date'] != null) {
                $date = explode('to', $search_params['payment_date']);
                if (count($date) == 1) $date[1] = $date[0];
                $claims->whereBetween('payment_date', [$date[0], $date[1]]);

            }


            if ($search_params['search'] != null) {
                $value = $search_params['search'];
                $claims->where(function ($q) use ($value) {
                    $q->whereHas('client', function ($t) use ($value) {
                        $t->where('name', 'like', "%" . $value . "%");
                        $t->orWhere('name_en', 'like', "%" . $value . "%");
                    });
                });


            }


        }

        $claims = $claims->get();
       // return $claims;
        return view('claims.export', [
            'claims' => $claims
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
