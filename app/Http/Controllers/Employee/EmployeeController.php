<?php

namespace App\Http\Controllers\Employee;

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
use App\Models\EmployeeProject;
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

class EmployeeController extends Controller
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

    function employeeWhourReport($from = 0, $to = 0)
    {
        try {
            $from = ($from != 0) ? $from : Carbon::now()->startOfMonth()->format('Y-m-d');
            $to = ($to != 0) ? $to : Carbon::now()->format('Y-m-d');
            $employees = Employee::wherein('id', EmployeeWhour::whereBetween('work_date', [$from, $to])->pluck('employee_id')->toArray())->get();
            $count = 0;


            foreach ($employees as $employee) {


                $path2 = public_path('cp'); // upload directory
                $data['font'] = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/JannaBold.ttf', 'TrueTypeUnicode', '', '32');
                $fontname = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/Janna.ttf', 'TrueTypeUnicode', '', '32');
                $pdf = new CustomPDFApp();
                $pdf->SetFont($fontname, '', 9, '', false);
                $pdf->reportTitle = 'Working Hours Report';
                $pdf->reportNo = $employee->name . $from . " " . $to;
                $pdf->reportDate = ' Date: ' . date('d/m/Y');
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(20);
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                /*  $pdf->setRTL(true);*/
                $pdf->AddPage();

                $data['from'] = $from;
                $data['to'] = $to;
                $data['employee'] = $employee;
                $title = $employee->name . " from " . $from . " " . $to . ".pdf";
                $data['title'] = $title;

                $htmlcontent2 = view('employees.whCalendar', $data)->render();


                $pdf->WriteHTML($htmlcontent2);
                $path = public_path('uploads'); // upload directory
                $pdf->Output($path . DIRECTORY_SEPARATOR . "employeesReport/" . $title, 'F');


                $count++;


                Mail::send('employees.WhourReport', $data, function ($message) use ($path, $employee, $pdf, $title) {
                    $message->from('trillionz@developon.co');
                    //$message->to('mkurdi@developon.co');
                    $message->cc('t.tamimi@tabibfind.ps');
                    $message->cc('t.tamimi@tabibfind.ps');
                    $message->cc('t.tamimi@developon.co');
                    $message->cc('t.mansour@trillionz.ps');
                    $message->cc('l.alawy@tabibfind.ps');
                    $message->cc('s.derawi@wheels.ps');
                    $message->cc('d.kilani@wheels.ps');
                    /*   $message->cc('l.alawy@tabibfind.ps');*/
                    /*   if (EmployeeModel::find($salary->employee_id)->email)
                           $message->cc(EmployeeModel::find($salary->employee_id)->email);*/
                    $message->subject($title);
                    $message->attach($path . DIRECTORY_SEPARATOR . "/employeesReport/" . $title);;
                });
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    function autoCheckout()
    {
        try {
            DB::beginTransaction();
            $employeesWhs = EmployeeWhour::where('status', 92)->get();

            foreach ($employeesWhs as $employee_whour) {
                //if ($employee_whour->employee_id == 1) {


                $employee_whour->status = Constant::where('module', Modules::Employee)
                    ->where('value', '2')->get()->first()->id;
                $employee_whour->last_ip = '-';
                $employee_whour->update_date = date('Y-m-d H:i:s');
                $employee_whour->update_id = \Auth::user()->id;
                $employee_whour->to_time = date('Y-m-d H:i:s');
                $employee_whour->save();
                $employee = Employee::find($employee_whour->employee_id);
                $user = User::find($employee->user_id);
                $user->checkin = null;
                $user->save();

                $mobile = $employee->mobile;
                $msg = "Please  if you are still not finished  check in again.";
                if ($mobile)
                    $this->sendWhatsapp($this->refineMobile($mobile), $msg, 'graph', 'Tabibfind', 'Tabibfind');


                $data['employee'] = $employee;

                $title = "employee " . $employee->name . " is checked in after 12 am";
                $data['title'] = $title;


                Mail::send('employees.checkin', $data, function ($message) use ($employee, $title) {
                    $message->from('trillionz@developon.co');
                    $message->to('mkurdi@developon.co');
                    $message->cc('t.tamimi@tabibfind.ps');
                    // $message->cc('t.tamimi@tabibfind.ps');
                    //$message->cc('t.tamimi@developon.co');
                    $message->cc('l.alawy@tabibfind.ps');
                    $message->cc('l.alawy@tabibfind.ps');
                    $message->cc('s.derawi@wheels.ps');
                    $message->cc('d.kilani@wheels.ps');
                    /*   if (EmployeeModel::find($salary->employee_id)->email)
                           $message->cc(EmployeeModel::find($salary->employee_id)->email);*/
                    $message->subject($title);
                });

                //}
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();
        }
    }

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $projects = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::perject)->get();
            $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
            return view('employees.index', [
                'projects' => $projects,
                'BANKS' => $BANKS
            ]);
        }
        if ($request->isMethod('POST')) {
            $employees = Employee::select('employees.*')->with('user');
            // return  $employees->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('project_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['project_id']);
                    if (count($results) > 0) {
                        $employees->wherein('id', EmployeeProject::wherein('project_id', $results)->pluck('employee_id')->toArray());
                    }
                }


                if (array_key_exists('bank_name', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['bank_name']);
                    if (count($results) > 0)
                        $employees->whereIn('bank_name', $results);
                }
                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    if ($status == 1)
                        $employees->where('active', $status);
                    else
                        $employees->where('active', '<>', 1);
                }
                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $employees->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                        $q->orwhere('bank_name', 'like', "%" . $value . "%");
                    });
                }
            }

            //return $employees->get();
            return DataTables::eloquent($employees)
                ->editColumn('created_at', function ($employee) {
                    if ($employee->created_at)
                        return [
                            'display' => e(
                                $employee->created_at->format('m/d/Y h:i A')
                            ),
                            'timestamp' => $employee->created_at->timestamp
                        ];
                })
                ->editColumn('projects', function ($data) use ($request) {
                    $projects = '';
                    foreach (explode(',', $data->projects) as $k => $v)
                        $projects .= (Constant::find($v) ? Constant::find($v)->name : '') . ",";

                    return rtrim($projects, ',');
                })
                ->editColumn('name', function ($employee) {
                    return '<a href="' . route('employees.edit', ['employee' => $employee->id]) . '" target="" class="">
                         ' . $employee->name . '
                    </a>';
                })
                ->editColumn('user.email', function ($employee) {
                    return '<a href="' . route('user-management.users.index') . '?username=' . $employee->user->email . '" target="_blank" class="">
                         ' . $employee->user->email . '
                    </a>';
                })
                ->editColumn('active', function ($employee) {
                    return $employee->active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->addColumn('action', function ($employee) {
                    $editBtn = $smsAction = $callAction = $menu = '';

                    $editBtn = '<a href="' . route('employees.edit', ['employee' => $employee->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateemployee">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';


                    $removeBtn = '<a data-employee-name="' . $employee->name . '" href=' . route('employees.delete', ['employee' => $employee->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteemployee"
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


                    return $menu . $editBtn . $removeBtn;
                })
                ->escapeColumns([])
                // ->rawColumns(['action', 'active', 'has_insurance', 'attachments_count', 'name', 'telephone', 'intersted_in_work_insurance', 'intersted_in_health_insurance'])
                ->make();
        }
    }


    public function create(Request $request)
    {


        $cities = City::all();
        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::employee_types)->get();
        $titles = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::titles)->get();
        $genders = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::gender)->get();
        $educations = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::education)->get();
        $careers = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::career)->get();
        $att_type = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::ATTACHMENT_TYPE)->get();
        $projects = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::project)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();

        $positions = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::position)->get();


        $employment_types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::employment_type)->get();
        $departments = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::departments)->get();
        $currences = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::currences)->get();


        $createView = view('employees.addedit', [
            'cities' => $cities,
            'types' => $types,
            'titles' => $titles,
            'genders' => $genders,
            '$careers' => $educations,
            'careers' => $careers,
            'BANKS' => $BANKS,
            'positions' => $positions,
            'att_type' => $att_type,
            'projects' => $projects,
            'employment_types' => $employment_types,
            'currences' => $currences,
            'departments' => $departments


        ])->render();
        return $createView;
    }


    public function Employee(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required',

        ]);
        if (isset($Id)) {
            $newEmployee = Employee::find($Id);
            $newEmployee->update($request->all());
        } else
            $newEmployee = Employee::create($request->all());
        $newEmployee->active = $request->active_c == 'on' ? 1 : 0;
        $newEmployee->allow_outside_checkin = $request->allow_outside_checkin_c == 'on' ? 1 : 0;
        $newEmployee->projects = $request->projects ? implode(',', $request->projects) : $newEmployee->projects;

        $newEmployee->save();
        EmployeeProject::where('employee_id', $newEmployee->id)->delete();
        if (is_array($request->projects))
            foreach ($request->projects as $k => $v) {
                EmployeeProject::create(['employee_id' => $newEmployee->id, 'project_id' => $v]);
            }


        $message = 'Employee has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Employee has been added successfully!']);
        else
            return redirect()->route('employees.index', [
                'Id' => $newEmployee->id,
                //'employee' => $newEmployee->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Employee $employee)
    {


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
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($employee) {
            $query->where('attachable_type', employee::class)
                ->where('attachable_id', $employee->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $createView = view(
            'employees.addedit',
            [

                'employee' => $employee,
                'cities' => $cities,
                'types' => $types,
                'titles' => $titles,
                'genders' => $genders,
                '$careers' => $educations,
                'BANKS' => $BANKS,
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


    public function delete(Request $request, Employee $Employee)
    {
        $Employee->delete();
        return response()->json(['status' => true, 'message' => 'Employee Deleted Successfully !']);
    }


    public function export(Request $request)
    {
        /*$c=new EmployeesExport($request->all());
        return $c->view();*/
        return \Maatwebsite\Excel\Facades\Excel::download(new EmployeesExport($request->all()), 'Employees.xlsx');
    }

    public function viewAttachments(Request $request, Employee $employee)
    {

        $callsView = view(
            'employees.viewAttachments',
            [
                'employee' => $employee,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }
}
