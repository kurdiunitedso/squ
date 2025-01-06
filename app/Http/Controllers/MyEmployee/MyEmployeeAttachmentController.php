<?php

namespace App\Http\Controllers\MyEmployee;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Employee;
use App\Models\Constant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MyEmployeeAttachmentController extends Controller
{

    public function index(Request $request, Employee $employee)
    {

        if ($request->isMethod('POST')) {
            $attachments = Employee::with(['attachments', 'attachments.attachmentType', 'attachments.source'])->where('id', $employee->id)->first();
            // dd($attachments->attachments);
            return DataTables::of($attachments->attachments)
                ->addColumn('source', function ($attachment) {
                    $class = str_replace('App\\Models\\', '', $attachment->attachable_type);
                    if ($attachment->attachable_type) {
                        $C = $attachment->attachable_type;
                        //return $C;
                        $model = $C::find($attachment->attachable_id);
                        if ($model) {
                            if ($class == 'Facility')
                                return '<a href="' . route('facilities.edit', [strtolower($class) => $model->id]) . '?updateEmployee=1" target="_blank" >' . $class . '-' . $model->id . ' </a>';
                            else
                                return '<a href="' . route(strtolower($class) . 's.edit', [strtolower($class) => $model->id]) . '?updateEmployee=1" target="_blank" >' . $class . '-' . $model->id . ' </a>';
                        }
                    }
                    return 'NA';
                })
                ->addColumn('title', function ($attachment) {
                    return '<a target="_blank" href="' . asset('employees_attachment/' . $attachment->file_hash) . '">' . $attachment->file_name . '</a>';
                })

                ->editColumn('created_at', function ($attachment) {
                    return [
                        'display' => e(
                            $attachment->created_at->format('m/d/Y')
                        ),
                        'timestamp' => $attachment->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($attachment) use ($employee) {
                    $viewBtn = '<a target="_blank" href="' . asset('employees_attachment/' . $attachment->file_hash) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="currentColor"/>
                        <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="currentColor"/>
                        </svg>
                    </span>
                    </a>';

                    return $viewBtn ;
                })
                ->rawColumns(['source', 'title', 'action'])
                ->make();
        }
    }

    public function create(Request $request, Employee $employee)
    {
        $id  = null;
        $attachmentConstants = Constant::where('module', Modules::Employee)
            ->where('field', DropDownFields::ATTACHMENT_TYPE)->get();
        $createView = view('myemployees.attachments.addedit_modal', [
            'id' => $id,
            'employee' => $employee,
            'attachmentConstants' => $attachmentConstants,
            'selectedConstant' => []
        ])->render();

        return response()->json(['createView' => $createView]);
    }


    public function store(Request $request, Employee $employee)
    {
        $request->attachment_file->store('employees/attachments');

        $attachment = new Attachment([
            'attachment_type_id' =>  $request->attachment_type_id,
            'file_hash' =>  $request->attachment_file->hashName(),
            'source' =>  'employee',
            'file_name' => $request->attachment_file->getClientOriginalName(),
        ]);

        $employee->attachments()->save($attachment);

        return response()->json(['status' => true, 'message' =>  'Attachment has been added successfully!']);
    }


    public function edit(Request $request, Employee $employee, Attachment $attachment)
    {


        $attachmentConstants = Constant::where('module', Modules::Employee)
            ->where('field', DropDownFields::ATTACHMENT_TYPE)->get();

        $createView = view('myemployees.attachments.addedit_modal', [
            'attachment' => $attachment,
            'employee' => $employee,
            'attachmentConstants' => $attachmentConstants,
        ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function update(Request $request, Employee $employee, Attachment $attachment)
    {

        //User uploaded a new file
        $request->attachment_file->store('employees/attachments');

        $attachment->file_name = $request->attachment_file->getClientOriginalName();
        $attachment->file_hash = $request->attachment_file->hashName();

        $attachment->attachment_type_id =  $request->attachment_type_id;

        $attachment->save();

        return response()->json(['status' => true, 'message' => 'Attachment Updated']);
    }




    public function delete(Request $request, Attachment $attachment)
    {
        $attachment->delete();
        return response()->json(['status' => true, 'message' => $attachment->file_name . ' Deleted Successfully !']);
    }

}
