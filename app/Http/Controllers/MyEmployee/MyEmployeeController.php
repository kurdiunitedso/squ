<?php

namespace App\Http\Controllers\MyEmployee;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\ClientsExport;
use App\Exports\EmployeesExport;
use App\helper\CustomPDF;
use App\helper\CustomPDFApp;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\City;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Employee;
use App\Models\EmployeeModel;
use App\Models\EmployeeWhour;
use App\Models\EmployeeWHourModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class MyEmployeeController extends Controller
{
    function listWhour(Request $request)
    {


        $columns = $request->input('columns');
        $employee_name = $columns[1]['search']['value'];


        $whour = EmployeeWhour::getWhourByEmployee(0, Carbon::now()->format('Y-m-d'), Carbon::now()->addDay(1)->format('Y-m-d'), 0, 0);
        // return $whour->toRawSql();


        $table = Datatables::of($whour)
            ->editColumn('active', function ($data) use ($request) {


                return ' <span class="' . ($data->status == 92 ? 'badge-success' : 'badge-warning') . ' badge badge-sm">' . Constant::find($data->status)->name . '</span>';
            })
            ->filterColumn('employee.name', function ($query, $keyword) use ($request) {
                $columns = $request->input('columns');
                $value = $columns[1]['search']['value'];
                $query->whereHas('employee', function ($subQuery) use ($value) {
                    $subQuery->where('name', 'like', "%" . $value . "%");
                    $subQuery->orWhere('mobile', 'like', "%" . $value . "%");
                });
            })
            ->editColumn('work_date', function ($data) use ($request) {
                return date('l', strtotime($data->work_date)) . "-" . $data->work_date;
            })
            ->setRowClass(function ($data) {

                return $data->status == 92 ? 'table-success' : 'table-danger';
            })
            ->editColumn('to_time', function ($data) use ($request) {
                $result = $data->to_time == $data->from_time ? Carbon::parse($data->to_time)->diffForHumans() : $data->to_time;
                $color = 'text-success';
                if ($data->create_user != $data->update_id)
                    $color = 'text-danger';
                return '<span class="' . $color . '">' . $result . '</span>';
            })
            ->editColumn('last_ip', function ($data) use ($request) {
                return $data->last_ip;
            })
            ->editColumn('update_id', function ($data) use ($request) {
                return User::find($data->update_id) ? User::find($data->update_id)->name : '';
            })
            ->editColumn('hours', function ($data) use ($request) {

                return number_format(
                    ((strtotime($data->to_time > $data->from_time ? $data->to_time : date('Y-m-d H:i:s'))) - strtotime($data->from_time)) / (60 * 60),
                    1
                );
            });


        if ($request->ajax()) {
            $table->addColumn('m_action', function ($data) use ($request) {

                return "";
            });
        }


        $table = $table->escapeColumns([])->make(true);


        if ($request->ajax())
            return $table;
    }




    public function edit(Request $request)
    {
        if (!\Auth::user()->employee())
            return redirect()->route('/', []);
        $e = \Auth::user()->employee;
        //dd($e);
        $employee = Employee::find($e->id);


        $cities = City::all();
        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::employee_types)->get();
        $titles = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::titles)->get();
        $genders = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::gender)->get();
        $educations = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::education)->get();
        $careers = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::career)->get();
        $att_type = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::ATTACHMENT_TYPE)->get();
        $projects = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::perject)->get();
        $employment_types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::employment_type)->get();
        $departments = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::departments)->get();
        $currences = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::currences)->get();
        $audits = $employee->audits()->with('user')->orderByDesc('created_at')->get();
        $positions = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::position)->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($employee) {
            $query->where('attachable_type', employee::class)
                ->where('attachable_id', $employee->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $createView = view(
            'myemployees.addedit',
            [

                'employee' => $employee,
                'cities' => $cities,
                'types' => $types,
                'titles' => $titles,
                'genders' => $genders,
                '$careers' => $educations,
                'careers' => $careers,
                'positions' => $positions,
                'att_type' => $att_type,
                'projects' => $projects,
                'employment_types' => $employment_types,
                'currences' => $currences,
                'departments' => $departments,
                'audits' => $audits,
                'attachmentAudits' => $attachmentAudits


            ]


        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }
}
