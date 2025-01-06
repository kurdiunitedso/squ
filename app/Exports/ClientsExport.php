<?php

namespace App\Exports;

use App\Models\Client;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientsExport implements FromView, WithStyles
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

        $clients = Client::
        select('clients.*')
            ->with('citys', 'categorys', 'statuss')
            ->withCount('orders')
            ->withCount('attachments')
            ->withCount('callPhone')
            ->withCount('smsPhone');
        // return  $clients->get();

        if ($parm) {
            $search_params = $parm;


            if (array_key_exists('city_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['city_id']);
                if (count($results) > 0)
                    $clients->whereIn('city_id', $results);

            }

            if (array_key_exists('category', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['category']);
                if (count($results) > 0)
                    $clients->whereIn('category', $results);
                //$clients->where('category', $search_params['category']);
            }

            if (array_key_exists('status', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['status']);
                if (count($results) > 0)
                    $clients->whereIn('status', $results);

            }
            if (array_key_exists('type_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['type_id']);
                if (count($results) > 0)
                    $clients->whereIn('type_id', $results);
                //$clients->where('type_id', $search_params['type_id']);
            }
            if ($search_params['orders_bot_min'] != null) {
                $clients->where('orders_bot', '>=', $search_params['orders_bot_min']);
            }
            if ($search_params['orders_box_min'] != null) {
                $clients->where('orders_bot', '>=', $search_params['orders_box_min']);
            }
            if ($search_params['orders_now_min'] != null) {
                $clients->where('orders_bot', '>=', $search_params['orders_now_min']);
            }


            if ($search_params['orders_bot_max'] != null) {
                $clients->where('orders_bot', '<=', $search_params['orders_bot_max']);
            }
            if ($search_params['orders_box_max'] != null) {
                $clients->where('orders_bot', '<=', $search_params['orders_box_max']);
            }
            if ($search_params['orders_now_max'] != null) {
                $clients->where('orders_bot', '<=', $search_params['orders_now_max']);
            }


            if (array_key_exists('attachment_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['attachment_id']);
                if (count($results) > 0)
                    $clients->attachments->whereIn('attachment_type_id', $results);
            }

            if ($search_params['last_orders_box'] != null) {
                $date = explode('to', $search_params['last_orders_box']);
                if (count($date) == 1) $date[1] = $date[0];
                $clients->whereBetween('join_date', [$date[0], $date[1]]);
            }
            if ($search_params['last_orders_bot'] != null) {
                $date = explode('to', $search_params['last_orders_bot']);
                if (count($date) == 1) $date[1] = $date[0];
                $clients->whereBetween('last_orders_bot', [$date[0], $date[1]]);
            }
            if ($search_params['last_orders_now'] != null) {
                $date = explode('to', $search_params['last_orders_now']);
                if (count($date) == 1) $date[1] = $date[0];
                $clients->whereBetween('last_orders_now', [$date[0], $date[1]]);
            }


            if ($search_params['search'] != '') {
                $value = $search_params['search'];
                $clients->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%" . $value . "%");
                    $q->orwhere('telephone', 'like', "%" . $value . "%");
                    $q->orwhere('client_id', 'like', "%" . $value . "%");
                });
            }


        }















        $clients = $clients->get();
       // return $clients;
        return view('clients.export', [
            'clients' => $clients
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
