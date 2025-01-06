<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ConstantsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('settings.constants.index');
        } else if ($request->isMethod('POST')) {
            $constants = Constant::query()
                ->select(['constants.module', 'constants.field', DB::raw('count(*) as total_values')])
                ->groupBy('constants.module', 'constants.field')
                ->orderBy('module', 'asc');
            // dd(  $constants->get());
            if ($request->input('params')) {
                $search_params = $request->input('params');
                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $constants->where(function ($q) use ($value) {
                        $q->orwhere('field', 'like', "%" . $value . "%");
                        $q->orwhere('module', 'like', "%" . $value . "%");
                    });
                }
            }
            return DataTables::eloquent($constants)
                ->addColumn('action', function ($constant) {
                    $editBtn = '<a href="' . route('settings.constants.edit', ['constant' => $constant->field, 'module' => $constant->module]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateConstant">
                <span class="svg-icon svg-icon-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                </svg>
                </span>
                </a>';
                    return $editBtn;
                })
                ->rawColumns(['action'])
                ->make();
        }
    }


    public function edit(Request $request, $constant, $module = 0)
    {
        // $id = $role = null;
        $request->validate([
            'constant' => 'string'
        ]);

        $constants = Constant::where('field', $constant);
        if ($module)
            $constants = $constants->where('module', $module);

        $constants = $constants->get();
        $editView = view('settings.constants.addedit_modal', [
            'constants' => $constants,
        ])->render();

        return response()->json(['editView' => $editView]);
    }

    public function update(Request $request, $constant)
    {
        foreach ($request->kt_constant_repeater as $key => $value) {
            if ($value["constant_id"] != null) {
                //Update Constant values
                Constant::where('id', $value["constant_id"])->update([
                    'name' => $value["constant_name"],
                    'name_ar' => $value["name_ar"],
                    'parent_id' => $value["parent_id"],
                    'constant_name' => str_replace(' ', '_', trim(strtolower($value["constant_name"]))),
                    'value' => $value["constant_value"]
                ]);
            } else {
                // Create new one
                Constant::create([
                    'name' => $value["constant_name"],
                    'name_ar' => $value["name_ar"],
                    'value' => $value["constant_value"],
                    'module' => $request->ModuleName,
                    'parent_id' => $value["parent_id"],
                    'constant_name' => str_replace(' ', '_', trim(strtolower($value["constant_name"]))),
                    'field' => $request->FieldName,
                ]);
            }
        }

        //Delete once finish editing
        if ($request->deleted_constants) {
            foreach ($request->deleted_constants as $constantId) {
                Constant::where('id', $constantId)->delete();
            }
        }

        return response()->json(['status' => true, 'message' => $request->FieldName . 'Constants Updated']);
    }
}
