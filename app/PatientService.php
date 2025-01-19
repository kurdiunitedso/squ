<?php

namespace App; // <- important

use App\Models\Patient;

class PatientService
{
    // your code

    public static function Update($request, $patient)
    {
        if ($request->has('status')) {
            $oldState = $patient->status;
            if ($oldState != true)
                $patient->status = true;
        } else {
            $oldState = $patient->status;
            if ($oldState != false)
                $patient->status = false;
        }

        if ($request->has('is_parent')) {
            $oldState = $patient->is_parent;
            if ($oldState != true)
                $patient->is_parent = true;
        } else {
            $oldState = $patient->is_parent;
            if ($oldState != false)
                $patient->is_parent = false;
        }

        if ($request->has('living_status')) {
            $oldState = $patient->living_status;
            if ($oldState != true)
                $patient->living_status = true;
        } else {
            $oldState = $patient->living_status;
            if ($oldState != false)
                $patient->living_status = false;
        }

        if ($request->has('independence_status')) {
            $oldState = $patient->independence_status;
            if ($oldState != true)
                $patient->independence_status = true;
        } else {
            $oldState = $patient->independence_status;
            if ($oldState != false)
                $patient->independence_status = false;
        }

        $patient->id_type = $request->id_type;
        $patient->idcard_no = $request->idcard_no;
        $patient->register = $request->register;
        $patient->register_date = $request->register_date;
        $patient->name = $request->name;
        $patient->name_en = $request->name_en;
        $patient->name_he = $request->name_he;
        $patient->birth_date = $request->birth_date;
        $patient->branch_id = $request->branch_id;
        $patient->marital_status_id = $request->marital_status_id;
        $patient->blood_type = $request->blood_type;
        $patient->gender = $request->gender;
        $patient->city_id = $request->city_id;
        $patient->address = $request->address;
        $patient->mobile = $request->mobile;
        $patient->tel1 = $request->tel1;
        $patient->pobox = $request->pobox;
        $patient->email = $request->email;
        $patient->tel2 = $request->tel2;
       // $patient->membership_type = $request->membership_type;
       // $patient->membership_subtype = $request->membership_subtype;
        $patient->clinical_history = $request->clinical_history;
        $patient->sick_fund_id = $request->sick_fund_id;
        $patient->patient_clinic_id = $request->patient_clinic_id;
        $patient->last_update_date = $request->last_update_date;
        $patient->com_whatsapp = $request->com_whatsapp != null ? true : false;
        $patient->com_sms = $request->com_sms != null ? true : false;
        $patient->com_email = $request->com_email != null ? true : false;
        $patient->com_phone = $request->com_email != null ? true : false;
        $patient->speak_en = $request->speak_en != null ? true : false;
        $patient->speak_h = $request->speak_h != null ? true : false;


        $patient->save();
    }

    public static function Create($request)
    {
        $newPatient = new Patient();

        $newPatient->status = $request->status != null ? true : false;
        $newPatient->is_parent = $request->is_parent != null ? true : false;
        $newPatient->living_status = $request->living_status != null ? true : false;
        $newPatient->independence_status = $request->independence_status != null ? true : false;
        $newPatient->id_type = $request->id_type;
        $newPatient->idcard_no = $request->idcard_no;
        $newPatient->register = $request->register;
        $newPatient->register_date = $request->register_date;
        $newPatient->name = $request->name;
        $newPatient->name_en = $request->name_en;
        $newPatient->name_he = $request->name_he;
        $newPatient->birth_date = $request->birth_date;
        $newPatient->branch_id = $request->branch_id;
        $newPatient->marital_status_id = $request->marital_status_id;
        $newPatient->blood_type = $request->blood_type;
        $newPatient->gender = $request->gender;
        $newPatient->city_id = $request->city_id;
        $newPatient->address = $request->address;
        $newPatient->mobile = $request->mobile;
        $newPatient->tel1 = $request->tel1;
        $newPatient->pobox = $request->pobox;
        $newPatient->email = $request->email;
        $newPatient->tel2 = $request->tel2;
       // $newPatient->membership_type = $request->membership_type;
       // $newPatient->membership_subtype = $request->membership_subtype;
        $newPatient->clinical_history = $request->clinical_history;
        $newPatient->sick_fund_id = $request->sick_fund_id;

        $newPatient->save();

        return $newPatient;
    }
}
