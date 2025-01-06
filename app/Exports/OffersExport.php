<?php

namespace App\Exports;




use App\Models\Offer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OffersExport implements FromView, WithStyles
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

        $offers = Offer::with('visit','facility', 'status', 'type')->withCount('items')->withCount('attachments');

        if ($parm) {
            $search_params = $parm;



            if (array_key_exists('offer_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['offer_id']);
                if (count($results) > 0)
                    $offers->whereIn('offer_id', $results);
            }
            if (array_key_exists('type_id', $search_params)) {
                $results = $this->filterArrayForNullValues($search_params['type_id']);
                if (count($results) > 0)
                    $offers->whereIn('type_id', $results);
            }

            if ($search_params['is_active'] != null) {
                $status = $search_params['is_active'] == "YES" ? 1 : 0;
                $offers->where('active', $status);
            }


            if ($search_params['created_at'] != null) {
                $date = explode('to', $search_params['created_at']);
                if (count($date) == 1) $date[1] = $date[0];
                $offers->whereBetween('created_at', [$date[0], $date[1]]);
            }
           /* if ($search_params['payment_date'] != null) {
                $date = explode('to', $search_params['payment_date']);
                if (count($date) == 1) $date[1] = $date[0];
                $offers->whereBetween('payment_date', [$date[0], $date[1]]);
            }*/


            if ($search_params['search'] != null) {
                $value = $search_params['search'];
                $offers->where(function ($q) use ($value) {

                    $q->whereHas('offer', function ($q) use ($value) {
                        $q->where('contact_person', 'like', "%" . $value . "%");
                        $q->orwhere('contact_social', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                    });
                });
            }


        }














        $offers = $offers->get();
        // return $offers;
        return view('Offers.export', [
            'offers' => $offers
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
