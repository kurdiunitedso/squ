<?php

namespace App\Exports;

use App\Models\Hospital;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HospitalsExport implements FromView, WithStyles
{
    private $name;
    private $country;
    private $city;
    private $type;

    function __construct(
        $name,
        $country,
        $city,
        $type,
    ) {
        $this->name = $name;
        $this->country = $country;
        $this->city = $city;
        $this->type = $type;
    }

    public function view(): View
    {
        //
        $name = $this->name;
        $country = $this->country;
        $city = $this->city;
        $type = $this->type;

        $query =  Hospital::query();

        $query->where(function ($q) use ($name) {
            $q->where('name', 'like', "%" . $name . "%");
            $q->orWhere('name_en', 'like', "%" . $name . "%");
            $q->orWhere('name_he', 'like', "%" . $name . "%");
        });

        if ($country != null) {
            $query->where('country_id', $country);
        }

        if ($city != null) {
            $query->where('city_id', $city);
        }

        if ($type != null) {
            $query->where('type_id', $type);
        }

        $hospitals = $query->get();
        return view('hospitals.export', [
            'hospitals' => $hospitals
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
