<?php

namespace App;

use App\Models\Attachment;
use App\Models\MenuWebSite;
use App\Models\Program;
use App\Models\ProgramPage;
use App\Models\Slider;
use App\Models\WebsiteSection;
use Exception;
use Illuminate\Support\Facades\Route;

class AppPermissionsHelper
{

    /*
        :::::::: IMPORTANT NOTE ::::::::

        all permission should have postfix as one of the following
        _access
        _add
        _edit
        _delete
    */
    public static function getPermissions()
    {
        $permissions = [
            "User Management Module" => [
                "Manage" => 'user_management_access'
            ],
            "Settings Module" => [
                "Country and City" => "settings_country_city_access",
                "Menu settings" => "settings_menu_access",
                "Constants" => "settings_constants_access",

            ],
            "Website Management" => [
                WebsiteSection::ui['p_ucf'] => WebsiteSection::ui['s_lcf'] . '_access',
            ],


            Attachment::ui['p_ucf'] => [
                "access" => Attachment::ui['s_lcf'] . "_access",
                "add" => Attachment::ui['s_lcf'] . '_add',
                "edit" => Attachment::ui['s_lcf'] . '_edit',
                "delete" => Attachment::ui['s_lcf'] . '_delete',
            ],

            Program::ui['p_ucf'] => [
                "access" => Program::ui['s_lcf'] . "_access",
                "add" => Program::ui['s_lcf'] . '_add',
                "edit" => Program::ui['s_lcf'] . '_edit',
                "delete" => Program::ui['s_lcf'] . '_delete',
            ],
            ProgramPage::ui['p_ucf'] => [
                "access" => ProgramPage::ui['s_lcf'] . "_access",
                "add" => ProgramPage::ui['s_lcf'] . '_add',
                "edit" => ProgramPage::ui['s_lcf'] . '_edit',
                "delete" => ProgramPage::ui['s_lcf'] . '_delete',
            ],



        ];
        $permissionFlatten = collect($permissions)->unique()->flatten(1);
        self::CheckMiddlewares($permissionFlatten);
        return $permissions;
    }

    private static function CheckMiddlewares($usedPermissions)
    {


        $routes = Route::getRoutes()->getRoutesByName();
        $remove = [
            'sanctum.csrf-cookie',
            'ignition.healthCheck',
            'ignition.executeSolution',
            'ignition.updateConfig',
            'login',
            'authenticate',
            'logout',
            'home',
            'setLanguage'
        ];

        $routes = array_diff_key($routes, array_flip($remove));
        // $routeNames = array_keys($routes);

        $routesAndPermissions = [];

        foreach ($routes as $route) {
            $routeMiddleware = collect($route->action['middleware']);
            $filtered = $routeMiddleware->filter(function ($value, $key) {
                if (strpos($value, "permission:") === 0) {
                    return $value;
                }
            })->map(function ($item, $key) {
                $permission = substr($item, 11);
                $permissions = explode("|", $permission);
                return $permissions;
            })->flatten(1);
            // dd($filtered);
            foreach ($filtered as $permissionMiddleware) {
                # code...
                array_push($routesAndPermissions, $permissionMiddleware);
            }
        }
        $routesAndPermissions = collect($routesAndPermissions)->unique();
        if ($routesAndPermissions->diff($usedPermissions)->count() > 0) {

            $diff = $routesAndPermissions->diff($usedPermissions)->toArray();
            throw new Exception("Please Check AppPermissionsHelper.php file \n middleware used in web routes aren't included!" . implode(",", $diff));
        }
    }
}
