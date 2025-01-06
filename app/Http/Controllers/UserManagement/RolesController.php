<?php

namespace App\Http\Controllers\UserManagement;

use App\AppPermissionsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $roles = Role::with('permissions')->where('name', '!=', 'super-admin')->get();
            $permissions = Permission::all();
            return view('user-management.roles.index', compact('roles', 'permissions'));
        }
        if ($request->isMethod('POST')) {
        }
    }

    public function getCards(Request $request)
    {
        $roles = Role::with('permissions')->where('name', '!=', 'super-admin')->get();

        $roleCards = '';
        foreach ($roles as $role) {
            $roleCards .= view('user-management.roles.card', ['role' => $role])->render();
        }
        return response()->json(['role_cards' => $roleCards]);
    }


    public function getPermissionArabicName($permission)
    {
        $permssions = collect($this->getPermissionList());
        $permissionName =   $permssions->firstWhere('permission', $permission);
        return $permissionName['groupName'] . " : " .  $permissionName['name'];
    }

    public function getPermissionList()
    {
        // $permissions = [
        //     ['name' => __('layout.roles.access'), 'permission' => 'user_management_access', 'groupName' => __('menu.user-management.title')],
        //     ['name' => __('layout.roles.access'), 'permission' => 'patient_access', 'groupName' => __('menu.patient.title')],
        //     ['name' => __('layout.roles.access'), 'permission' => 'settings_country_city_access', 'groupName' => __('menu.settings.countriescities')],
        //     ['name' => __('layout.roles.add'), 'permission' => 'patient_add', 'groupName' => __('menu.patient.title')],
        //     ['name' => __('layout.roles.edit'), 'permission' => 'patient_edit', 'groupName' => __('menu.patient.title')],
        // ];

        $permissionModules = AppPermissionsHelper::getPermissions();
        $translatedPermissions = [];
        foreach ($permissionModules as $permissionModule => $permissions) {
            foreach ($permissions as $key => $permission) {
                // $postfix = 'layout.roles.' . substr(strrchr($permission, '_'), 1);
                array_push(
                    $translatedPermissions,
                    ['name' => __($key), 'permission' => $permission, 'groupName' => __($permissionModule)]
                );
            }
        }
        return $translatedPermissions;
    }

    // Show Role Modal Creation
    public function create(Request $request)
    {
        $id = $role = null;

        $permssions = collect($this->getPermissionList());
        $grouped = $permssions->groupBy('groupName');

        $createView = view('user-management.roles.addedit_modal', [
            'id' => $id,
            'role' => $role,
            'permissions' => $grouped,
            'earnedPermissions' => []
        ])->render();



        return response()->json(['createView' => $createView]);
    }

    //Save the New Role
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->role_name]);
        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return response()->json(['status' => true, 'message' => 'Role has been added successfully!']);
    }

    public function delete(Request $request, Role $role)
    {
        $role->delete();
        return response()->json(['status' => true, 'message' => 'Role has been deleted successfully!']);
    }

    public function edit(Request $request, Role $role)
    {
        $permssions = collect($this->getPermissionList());
        $grouped = $permssions->groupBy('groupName');
        $role->load('permissions');
        $earnedPermissions = $role->permissions->pluck('name')->toArray();
        $createView = view('user-management.roles.addedit_modal', [
            'role' => $role,
            'permissions' => $grouped,
            'earnedPermissions' => $earnedPermissions
        ])->render();

        return response()->json(['createView' => $createView]);
    }


    public function update(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions);
        $role->name = $request->role_name;
        $role->save();

        return response()->json(['status' => true, 'message' => 'تم تعديل الصلاحية بنجاح ']);
    }
}
