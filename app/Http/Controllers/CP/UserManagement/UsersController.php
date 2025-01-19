<?php

namespace App\Http\Controllers\CP\UserManagement;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\User;
use App\Rules\UserEmailExists;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{

    private function filterArrayForNullValues($array)
    {
        $filteredArray = array_filter($array, function ($value) {
            return $value !== null;
        });
        return $filteredArray;
    }


    public function index(Request $request)
    {
        // $users = User::with('roles')->get();
        // dd($users);
        if ($request->isMethod('GET')) {
            $roles = Role::where('name', '!=', 'super-admin')->get();
            $ALHAYAT_BRANCHES = Constant::where('module', Modules::Patient)->where('field', DropDownFields::ALHAYAT_BRANCHES)->get();
            return view('user-management.users.index', compact('roles', 'ALHAYAT_BRANCHES'));
        }
        if ($request->isMethod('POST')) {
            $users = User::with('branch')
                ->with('roles')
                ->with('roles.permissions')->with('permissions')->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'super-admin');
                })
                ->whereHas('roles', function ($query) use ($request) {
                    if ($request->input('params')) {
                        $search_params = $request->input('params');
                        if ($search_params['role_id'] != null) {
                            $query->where('id', $search_params['role_id']);
                        }
                    }
                })
                ->select('users.*');


            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('branch_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['branch_id']);
                    if (count($results) > 0)
                        $users->whereIn('branch_id', $results);
                }

                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? true : false;
                    $users->where('active', $status);
                }

                if ($search_params['created_at'] != null) {
                    $date = explode('to', $search_params['created_at']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $users->whereBetween('created_at', [$date[0], $date[1]]);
                }
            }



            return DataTables::eloquent($users)
                ->filterColumn('users.name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orWhere('mobile', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('last_login_at', function ($user) {
                    if ($user->last_login_at)
                        return $user->last_login_at->diffForHumans();
                    else return '';
                })
                ->editColumn('created_at', function ($user) {
                    return [
                        'display' => e(
                            $user->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $user->created_at->timestamp
                    ];
                })
                ->editColumn('fullname', function ($user) {
                    $avatar  = $user->avatar != null ? asset("images/" . $user->avatar) : asset("media/avatars/blank.png");

                    $template = '
                                    <!--begin:: Avatar -->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="#">
                                            <div class="symbol-label">
                                                <img src="' . $avatar . '" alt="' . $user->name . '" class="w-100">
                                            </div>
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary mb-1">' . $user->name . '</a>
                                        <span>' . $user->email . '</span>
                                    </div>
                                    <!--begin::User details-->
                                ';
                    return $template;
                })
                ->addColumn('action', function ($user) {
                    $editBtn = '<a href="' . route('user-management.users.edit', ['user' => $user->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateUser">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $ImpersonateBtn = '<a href="' . route('impersonate', ['id' => $user->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" d="M3 6C2.4 6 2 5.6 2 5V3C2 2.4 2.4 2 3 2H5C5.6 2 6 2.4 6 3C6 3.6 5.6 4 5 4H4V5C4 5.6 3.6 6 3 6ZM22 5V3C22 2.4 21.6 2 21 2H19C18.4 2 18 2.4 18 3C18 3.6 18.4 4 19 4H20V5C20 5.6 20.4 6 21 6C21.6 6 22 5.6 22 5ZM6 21C6 20.4 5.6 20 5 20H4V19C4 18.4 3.6 18 3 18C2.4 18 2 18.4 2 19V21C2 21.6 2.4 22 3 22H5C5.6 22 6 21.6 6 21ZM22 21V19C22 18.4 21.6 18 21 18C20.4 18 20 18.4 20 19V20H19C18.4 20 18 20.4 18 21C18 21.6 18.4 22 19 22H21C21.6 22 22 21.6 22 21ZM16 11V9C16 6.8 14.2 5 12 5C9.8 5 8 6.8 8 9V11C7.2 11 6.5 11.7 6.5 12.5C6.5 13.3 7.2 14 8 14V15C8 17.2 9.8 19 12 19C14.2 19 16 17.2 16 15V14C16.8 14 17.5 13.3 17.5 12.5C17.5 11.7 16.8 11 16 11ZM13.4 15C13.7 15 14 15.3 13.9 15.6C13.6 16.4 12.9 17 12 17C11.1 17 10.4 16.5 10.1 15.7C10 15.4 10.2 15 10.6 15H13.4Z" fill="currentColor"/>
                    <path d="M9.2 12.9C9.1 12.8 9.10001 12.7 9.10001 12.6C9.00001 12.2 9.3 11.7 9.7 11.6C10.1 11.5 10.6 11.8 10.7 12.2C10.7 12.3 10.7 12.4 10.7 12.5L9.2 12.9ZM14.8 12.9C14.9 12.8 14.9 12.7 14.9 12.6C15 12.2 14.7 11.7 14.3 11.6C13.9 11.5 13.4 11.8 13.3 12.2C13.3 12.3 13.3 12.4 13.3 12.5L14.8 12.9ZM16 7.29998C16.3 6.99998 16.5 6.69998 16.7 6.29998C16.3 6.29998 15.8 6.30001 15.4 6.20001C15 6.10001 14.7 5.90001 14.4 5.70001C13.8 5.20001 13 5.00002 12.2 4.90002C9.9 4.80002 8.10001 6.79997 8.10001 9.09997V11.4C8.90001 10.7 9.40001 9.8 9.60001 9C11 9.1 13.4 8.69998 14.5 8.29998C14.7 9.39998 15.3 10.5 16.1 11.4V9C16.1 8.5 16 8 15.8 7.5C15.8 7.5 15.9 7.39998 16 7.29998Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $removeBtn = '<a data-user-name="' . $user->name . '" href=' . route('user-management.users.delete', ['user' => $user->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteUser"
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
                    return  $ImpersonateBtn . $editBtn . $removeBtn;
                })
                ->rawColumns(['fullname', 'action'])
                ->make();
        }
    }

    public function delete(Request $request, User $user)
    {
        if (!$user->hasRole('super-admin')) {
            $user->syncRoles([]);
            $user->email = $user->email . uniqid();
            $user->save();
            $user->delete();
        } else
            return response()->json(['status' => false, 'message' => 'super-admin cant be deleted!']);
        return response()->json(['status' => true, 'message' => 'User Deleted Successfully !']);
    }


    // Show Role Modal Creation
    public function create(Request $request)
    {
        $id = $role = null;
        $ALHAYAT_BRANCHES = Constant::where('field', DropDownFields::ALHAYAT_BRANCHES)->get();

        $roles = Role::where('name', '!=', 'super-admin')->with("permissions")->get();
        $permissions = Permission::all();
        $createView = view('user-management.users.addedit_modal', [
            'id' => $id,
            'roles' => $roles,
            'earnedRole' => [],
            'Branches' => $ALHAYAT_BRANCHES,
            'permissions' => $permissions,
            'earnedPermissions' => []
        ])->render();

        return response()->json(['createView' => $createView]);
    }


    public function edit(Request $request, User $user)
    {
        $ALHAYAT_BRANCHES = Constant::where('field', DropDownFields::ALHAYAT_BRANCHES)->get();
        // $id = $role = null;
        $user->load('roles');
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $permissions = Permission::all();
        $earnedRole = $user->roles->pluck('name')->toArray();
        $earnedPermissions = $user->permissions->pluck('name')->toArray();
        $createView = view('user-management.users.addedit_modal', [
            'user' => $user,
            'roles' => $roles,
            'earnedRole' => $earnedRole,
            'Branches' => $ALHAYAT_BRANCHES,
            'permissions' => $permissions,
            'earnedPermissions' => $earnedPermissions
        ])->render();

        return response()->json(['createView' => $createView]);
    }


    public function update(Request $request, User $user)
    {

        $request->validate(
            [
                'user_name' => 'required|string',
                'user_email' => ['required', 'email', new UserEmailExists($user->id)],
            ],
        );
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->mobile = $request->user_mobile;
        //$user->branch_id = $request->user_branch_id;
        if ($request->user_password != null)
            $user->password = Hash::make($request->user_password);

        if ($request->has('user_active'))
            $user->active = true;
        else $user->active = false;

        if ($request->has('member_avatar') && $request->member_avatar != "undefined") {
            $request->member_avatar->store('images');
            $hashName = $request->member_avatar->hashName();
            $user->avatar = $hashName;
        }

        $user->save();

        $this->syncRolesAndPermissions($user, $request);



        return response()->json(['status' => true, 'message' => 'User Updated']);
    }


    public function syncRolesAndPermissions($user, $request)
    {
        if ($request->has("custom_permissions")) {
            $RoleSelectedPermissions = Role::with('permissions')->where('name', $request->role_name)->first();
            $selectedPermissions = collect($request->custom_permissions);
            if ($RoleSelectedPermissions)
                $rolePermissions = $RoleSelectedPermissions->permissions->pluck('name')->toArray();
            else
                $rolePermissions = [];
            $result = $selectedPermissions->diff($rolePermissions);
            $user->syncPermissions($result->toArray());
        } else {
            $user->syncPermissions([]);
        }


        if ($request->has("role_name")) {
            $user->syncRoles([$request->role_name]);
        } else
            $user->syncRoles([]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user = new User();
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->password = Hash::make($request->user_password);
        $user->mobile = $request->user_mobile;
        //$user->branch_id = $request->user_branch_id;

        if ($request->has('user_active'))
            $user->active = true;

        if ($request->has('member_avatar') && $request->member_avatar != "undefined") {
            $request->member_avatar->store('images');
            $hashName = $request->member_avatar->hashName();
            $user->avatar = $hashName;
        }

        $user->save();

        $this->syncRolesAndPermissions($user, $request);

        return response()->json(['status' => true, 'message' => 'User has been added successfully!']);
    }

    public function export(Request $request)
    {
        $name_code = $request->name_code;
        $role_id = $request->role_id;
        $branch_id = $request->branch_id;
        $is_active = $request->is_active;
        $created_at = $request->created_at;

        return Excel::download(new UsersExport($name_code, $branch_id, $role_id, $created_at, $is_active), 'users.xlsx');
    }
}
