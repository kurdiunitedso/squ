<?php

namespace App\Http\Controllers\Procedures;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\ProceduresExport;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Image;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProcedureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('procedures.index');
        }
        if ($request->isMethod('POST')) {

            $procedures = Procedure::with(['procedureType'])
                ->select('procedures.*');

            if ($request->input('params')) {
                $search_params = $request->input('params');
                if ($search_params['is_image'] == 'on') {
                    $procedures->where('is_image', true);
                }
                if ($search_params['is_active'] == 'on') {
                    $procedures->where('status', true);
                }
            }

            return DataTables::eloquent($procedures)
                ->filterColumn('name_en', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('name_en', 'like', "%" . $value . "%");
                        $q->orWhere('code', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('created_at', function ($procedure) {
                    return [
                        'display' => e(
                            $procedure->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $procedure->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($procedure) {
                    $editBtn = '<a href="' . route('procedures.edit', ['procedure' => $procedure->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatePro">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-procedure-name="' . $procedure->name . '" href=' . route('procedures.delete', ['procedure' => $procedure->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteProcedure"
                                >
                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>';
                    return $editBtn . $removeBtn;
                })
                ->rawColumns(['fullname', 'action'])
                ->make();
        }
    }

    public function create(Request $request)
    {
        $constants = Constant::where('module', Modules::main_module)->get();
        $PROCEDURE_TYPE = $constants->where('field', DropDownFields::PROCEDURE_TYPE);
        $PROCEDURE_FEE_TYPE = $constants->where('field', DropDownFields::PROCEDURE_FEE_TYPE);
        $INVOICE_TYPE = $constants->where('field', DropDownFields::INVOICE_TYPE);

        $createView = view('procedures.addedit_modal', [
            'PROCEDURE_TYPE' => $PROCEDURE_TYPE,
            'PROCEDURE_FEE_TYPE' => $PROCEDURE_FEE_TYPE,
            'INVOICE_TYPE' => $INVOICE_TYPE
        ])->render();

        return response()->json(['createView' => $createView]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'procedure_name_en' => 'required|string',
            'procedure_code' => 'required|string',
            'procedure_quantity' => 'required|string',
            'procedure_price_a' => 'required|string',
            'procedure_type_id' => 'required|string',
        ]);

        $newProcedure = new Procedure();

        $newProcedure->name_en = $request->procedure_name_en;
        $newProcedure->code = $request->procedure_code;
        $newProcedure->quantity = $request->procedure_quantity;
        $newProcedure->price_a = $request->procedure_price_a;
        $newProcedure->price_b = $request->procedure_price_b;
        $newProcedure->price_c = $request->procedure_price_c;
        $newProcedure->price_aboard = $request->procedure_price_aboard;
        $newProcedure->procedure_type_id = $request->procedure_type_id;

        if ($request->has('procedure_status'))
            $newProcedure->status = true;


        if ($request->has('procedure_is_image')) {
            $newProcedure->is_image = true;
            $newImage = new Image();
            $newImage->name = $request->procedure_name_en;
            $newImage->name_en = $request->procedure_name_en;
            $newImage->name_he = $request->procedure_name_en;
            $newImage->code = $request->procedure_code;

            $ImageType = Constant::where('module', Modules::main_module)->where('field', DropDownFields::PROCEDURE_TYPE)
                ->where('id', $request->procedure_type_id)->first();

            $newImage->image_type = $ImageType->name;
            $newImage->status = true;
            $newImage->save();
        }


        $newProcedure->save();

        return response()->json(['status' => true, 'message' => 'procedure has been added successfully!']);
    }

    public function edit(Request $request, Procedure $procedure)
    {
        $procedure->load(['procedureType']);
        $constants = Constant::where('module', Modules::main_module)->get();
        $PROCEDURE_TYPE = $constants->where('field', DropDownFields::PROCEDURE_TYPE);
        $PROCEDURE_FEE_TYPE = $constants->where('field', DropDownFields::PROCEDURE_FEE_TYPE);
        $INVOICE_TYPE = $constants->where('field', DropDownFields::INVOICE_TYPE);

        $createView = view('procedures.addedit_modal', [
            'procedure' => $procedure,
            'PROCEDURE_TYPE' => $PROCEDURE_TYPE,
            'PROCEDURE_FEE_TYPE' => $PROCEDURE_FEE_TYPE,
            'INVOICE_TYPE' => $INVOICE_TYPE
        ])->render();
        return response()->json(['createView' => $createView]);
    }

    public function update(Request $request, Procedure $procedure)
    {
        $request->validate([
            'procedure_name_en' => 'required|string',
            'procedure_code' => 'required|string',
            'procedure_quantity' => 'required|string',
            'procedure_price_a' => 'required|string',
            'procedure_type_id' => 'required|string',
        ]);

        $procedure->name_en = $request->procedure_name_en;
        $procedure->code = $request->procedure_code;
        $procedure->quantity = $request->procedure_quantity;
        $procedure->price_a = $request->procedure_price_a;
        $procedure->price_b = $request->procedure_price_b;
        $procedure->price_c = $request->procedure_price_c;
        $procedure->price_aboard = $request->procedure_price_aboard;
        $procedure->procedure_type_id = $request->procedure_type_id;

        if ($request->has('procedure_status'))
            $procedure->status = true;
        else $procedure->status = false;
        if ($request->has('procedure_is_image'))
            $procedure->is_image = true;
        else $procedure->is_image = false;


        $procedure->save();

        return response()->json(['status' => true, 'message' => 'procedure Updated']);
    }

    public function delete(Request $request, Procedure $procedure)
    {
        $procedure->delete();
        return response()->json(['status' => true, 'message' => 'procedure Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        $name_code = $request->name_code;
        $is_active = $request->is_active;
        $is_image = $request->is_image;

        return Excel::download(new ProceduresExport($name_code, $is_active, $is_image), 'procedures.xlsx');
    }
}
