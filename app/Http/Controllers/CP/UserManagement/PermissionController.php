<?php

namespace App\Http\Controllers\CP\UserManagement;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('user-management.permissions');
        }
        if ($request->isMethod('POST')) {
            $permissions = Permission::with('roles');
            return DataTables::eloquent($permissions)
                ->editColumn('created_at', function ($permission) {
                    return Carbon::parse($permission->created_at)->format('Y-m-d');
                })
                ->addColumn('action', function ($permission) {
                    $removeBtn = '<a href=' . route('user-management.permissions.delete', ['permission' => $permission->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                data-kt-permissions-table-filter="delete_row">
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
                    return $removeBtn;
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function addPermission(Request $request)
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = $request->validate([
            'name' => ['required'],
        ]);

        Permission::create(['name' => $permission['name']]);

        return response()->json(['data' => 'successfully added'], 200);
    }

    public function deletePermission(Request $request, Permission $permission)
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permission->delete();
        return response()->json(['data' => 'permission deleted successfully!'], 200);
    }
}
