<?php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientExport implements FromView, WithStyles
{


    private $name_code;
    private $IDENTITY_TYPES;
    private $sick_funds;
    private $ALHAYAT_BRANCHES;
    private $MEMBERSHIP_TYPE;
    private $MEMBERSHIP_SUBTYPE;
    private $age_answer;
    private $is_parent;
    private $has_relatives;
    private $is_independent;
    private $has_call_history;
    private $is_registered;
    private $is_active;
    private $register_date;
    private $patient_status;


    /**
     * @return \Illuminate\Support\Collection
     */


    function __construct(
        $name_code,
        $IDENTITY_TYPES,
        $sick_funds,
        $ALHAYAT_BRANCHES,
        $MEMBERSHIP_TYPE,
        $MEMBERSHIP_SUBTYPE,
        $age_answer,
        $is_parent,
        $has_relatives,
        $is_independent,
        $has_call_history,
        $is_registered,
        $is_active,
        $register_date,
        $patient_status
    ) {
        $this->name_code = $name_code;
        $this->IDENTITY_TYPES = $IDENTITY_TYPES;
        $this->sick_funds = $sick_funds;
        $this->ALHAYAT_BRANCHES = $ALHAYAT_BRANCHES;
        $this->MEMBERSHIP_TYPE = $MEMBERSHIP_TYPE;
        $this->MEMBERSHIP_SUBTYPE = $MEMBERSHIP_SUBTYPE;
        $this->age_answer = $age_answer;
        $this->is_parent = $is_parent;
        $this->has_relatives = $has_relatives;
        $this->is_independent = $is_independent;
        $this->has_call_history = $has_call_history;
        $this->is_registered = $is_registered;
        $this->is_active = $is_active;
        $this->register_date = $register_date;
        $this->patient_status = $patient_status;
    }

    public function view(): View
    {


        $query = Patient::query();

        $query->with('documentType');
        $query->with('maritalStatus');
        $query->with('city');
        $query->with('membershipType');
        $query->with('membershipSubtype');
        $query->with('branch');
        $query->with('sickFund');

        $query->select('patients.*', DB::raw('floor(DATEDIFF(CURDATE(),birth_date) /365) AS years_old'));
        $query->withCount('calls');
        $query->withCount('relatives');

        $name_code = $this->name_code;
        $IDENTITY_TYPES = $this->IDENTITY_TYPES;
        $sick_funds = $this->sick_funds;
        $ALHAYAT_BRANCHES = $this->ALHAYAT_BRANCHES;
        $MEMBERSHIP_TYPE = $this->MEMBERSHIP_TYPE;
        $MEMBERSHIP_SUBTYPE = $this->MEMBERSHIP_SUBTYPE;
        $age_answer = $this->age_answer;
        $is_parent = $this->is_parent;
        $has_relatives = $this->has_relatives;
        $is_independent = $this->is_independent;
        $has_call_history = $this->has_call_history;
        $is_registered = $this->is_registered;
        $is_active = $this->is_active;
        $register_date = $this->register_date;
        $patient_status = $this->patient_status;




        $query->where(function ($q) use ($name_code) {
            $q->where('name', 'like', "%" . $name_code . "%");
            $q->orWhere('name_en', 'like', "%" . $name_code . "%");
            $q->orWhere('name_he', 'like', "%" . $name_code . "%");
            $q->orWhere('idcard_no', 'like', "%" . $name_code . "%");
            $q->orWhere('mobile', 'like', "%" . $name_code . "%");
        });

        if ($sick_funds && count($sick_funds) > 0)
            $query->whereIn('sick_fund_id', $sick_funds);
        if ($ALHAYAT_BRANCHES && count($ALHAYAT_BRANCHES) > 0)
            $query->whereIn('branch_id', $ALHAYAT_BRANCHES);

        if ($MEMBERSHIP_TYPE && count($MEMBERSHIP_TYPE) > 0)
            $query->whereIn('membership_type', $MEMBERSHIP_TYPE);

        if ($MEMBERSHIP_SUBTYPE && count($MEMBERSHIP_SUBTYPE) > 0)
            $query->whereIn('membership_subtype', $MEMBERSHIP_SUBTYPE);

        if ($IDENTITY_TYPES != null) {
            $query->where('id_type', $IDENTITY_TYPES);
        }

        if ($patient_status != null) {
            $query->where('patient_status', $patient_status);
        }

        if ($is_active != null) {
            $status = $is_active == "YES" ? true : false;
            $query->where('status', $status);
        }

        if ($is_parent != null) {
            $status = $is_parent == "YES" ? true : false;
            $query->where('is_parent', $status);
        }

        if ($is_independent != null) {
            $status = $is_independent == "YES" ? true : false;
            $query->where('independence_status', $status);
        }

        if ($is_registered != null) {
            $status = $is_registered == "YES" ? true : false;
            $query->where('register', $status);
        }


        if ($has_relatives != null) {
            $status = $has_relatives == "YES" ? true : false;
            if ($status)
                $query->having('relatives_count', '>', 0);
            else
                $query->having('relatives_count', '=', 0);
        }


        if ($age_answer != null) {
            $status = $age_answer == "+18" ? true : false;
            if ($status)
                $query->having('years_old', '>=', 18);
            else
                $query->having('years_old', '<', 18);
        }

        if ($has_call_history != null) {
            $status = $has_call_history == "YES" ? true : false;
            if ($status)
                $query->having('calls_count', '>', 0);
            else
                $query->having('calls_count', '=', 0);
        }

        if ($register_date != null) {
            $date = explode('to', $register_date);
            if (count($date) == 1) $date[1] = $date[0];
            $query->whereBetween('register_date', [$date[0], $date[1]]);
        }


        $patients = $query->get();


        return view('patients.export', [
            'patients' => $patients
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
