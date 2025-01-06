<?php

namespace App\Exports;

use App\Models\Captin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CaptinsExport implements FromView, WithStyles
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

        $captins = Captin::
        select('captins.*',DB::raw('(select visit_date from visits where visits.telephone= captins.mobile1 order by visit_date desc limit 1) as last_visit_date')
            ,DB::raw('(select created_at  from visit_requests where visit_requests.telephone= captins.mobile1 order by created_at  desc limit 1) as last_visit_request_date')
            ,DB::raw('(select ticket_date  from tickets where tickets.telephone= captins.mobile1 order by ticket_date  desc limit 1) as last_ticket_date')
            ,DB::raw('(select order_create_date  from orders where captin_id= captins.id order by id  desc limit 1) as last_order_date')
            ,DB::raw('(select sum(grand_total )   from orders where captin_id= captins.id) as total_orders_cost'))
            ->with('city', 'vehicle','attachments', 'shifts', 'payment_types', 'payment_methods', 'bankName','insuranceCompany')
            ->withCount('orders')
            ->withCount('calls')
            ->withCount('tickets')->withCount('visits')
            ->withCount('attachments')
            ->withCount('smss');

        if ($parm) {
            $search_params = $parm;
            if (array_key_exists('ids', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['ids']);
                if (count($results) > 0)
                    $captins->whereIn('id', $results);

            }
            if (array_key_exists('city_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['city_id']);
                if (count($results) > 0)
                    $captins->whereIn('city_id', $results);
            }


            if ($search_params['policy_end'] != '') {
                $captins->where('policy_end', '<=', $search_params['policy_end']);
            }
            if (array_key_exists('vehicle_type', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['vehicle_type']);
                if (count($results) > 0)
                    $captins->whereIn('vehicle_type', $results);
            }



            if ($search_params['is_active'] != '') {
                $status = $search_params['is_active'] == "YES" ? 1 : 0;
                $captins->where('active', $status);
            }
            /* if ($search_params['intersted_in_health_insurance'] != '') {
                 $status = $search_params['intersted_in_health_insurance'] == "YES" ? 1 : 0;
                 $captins->where('intersted_in_health_insurance', $status);
             }*/
            /*   if ($search_params['intersted_in_work_insurance'] != '') {
                   $status = $search_params['intersted_in_work_insurance'] == "YES" ? 1 : 0;
                   $captins->where('intersted_in_work_insurance', $status);
               }*/

            if ($search_params['join_date'] != '') {
                $date = explode('to', $search_params['join_date']);
                if (count($date) == 1) $date[1] = $date[0];
                $captins->whereBetween('join_date', [$date[0], $date[1]]);
            }
            if ($search_params['has_insurance'] != '') {
                $status = $search_params['has_insurance'] == "YES" ? 1 : 0;
                $captins->where('has_insurance', $status);
            }
            if ($search_params['has_order'] != '') {
                $status = $search_params['has_order'] == "YES" ? 1 : 0;
                if ($status)
                    $captins->where('total_orders', '>', 0);
                else
                    $captins->where('total_orders', 0);

            }
            if ($search_params['has_box'] != '') {
                $status = $search_params['has_box'] == "YES" ? 1 : 0;
                $captins->whereNotNull('box_no');
            }
            if (array_key_exists('attachment_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['attachment_id']);
              /*  if (count($results) > 0)
                    $captins->attachment->whereIn('attachment_type_id', $results);*/
            }

            if ($search_params['box_no'] != '') {
                $captins->where('box_no', $search_params['box_no']);
            }

            if (array_key_exists('bank_name', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['bank_name']);
                if (count($results) > 0)
                    $captins->whereIn('bank_name', $results);
            }



            if ($search_params['has_iban'] != '') {
                $status = $search_params['has_iban'] == "YES" ? 1 : 0;
                if ($status)
                    $captins->whereNotNull('iban');
                else
                    $captins->whereNull('iban');
            }

            if ($search_params['total_orders'] != '') {
                $captins->where('total_orders', '<=', $search_params['total_orders']);
            }
            if ($search_params['total_commission'] != '') {
                $captins->where('total_commission', '<=', $search_params['total_commission']);
            }
            if (array_key_exists('shift', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['shift']);
                if (count($results) > 0)
                    $captins->whereIn('shift', $results);
            }


            if ($search_params['search'] != '') {
                $value=$search_params['search'];
                $captins->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%" . $value . "%");
                    $q->orwhere('id_wheel', 'like', "%" . $value . "%");
                    $q->orwhere('captin_id', 'like', "%" . $value . "%");
                    $q->orwhere('mobile1', 'like', "%" . $value . "%");
                    $q->orwhere('mobile2', 'like', "%" . $value . "%");
                    $q->orwhere('box_no', 'like', "%" . $value . "%");
                });
            }


        }




        $captins = $captins->get();
       // return $captins;
        return view('captins.export', [
            'captins' => $captins
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
