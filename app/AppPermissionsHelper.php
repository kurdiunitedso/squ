<?php

namespace App;

use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Objective;
use App\Models\Project;
use App\Models\Task;
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
        // dd([
        //     "Country and City" => "settings_country_city_access",
        //     "Menu settings" => "settings_menu_access",
        //     "Constants" => "settings_constants_access",
        //     'Questionnaires' => 'settings_questionnaire_access',
        //     Objective::ui['p_ucf'] => 'settings_' . Objective::ui['route'] . '_access'
        //     // 'Objectives' => 'settings_objectives_access'

        // ]);
        $permissions = [
            "User Management Module" => [
                "Manage" => 'user_management_access',
                "Impersonate" => 'impersonate'
            ],
            "Settings Module" => [
                "Country and City" => "settings_country_city_access",
                "Menu settings" => "settings_menu_access",
                "Constants" => "settings_constants_access",
                'Questionnaires' => 'settings_questionnaire_access',
                Objective::ui['p_ucf'] => 'settings_' . Objective::ui['route'] . '_access'
                // 'Objectives' => 'settings_objectives_access'

            ],
            "Restaurants" => [
                "access" => "restaurant_access",
                "add" => 'restaurant_add',
                "edit" => 'restaurant_edit',
                "delete" => 'restaurant_delete',
            ],

            "Facilities" => [
                "access" => "facility_access",
                "add" => 'facility_add',
                "edit" => 'facility_edit',
                "delete" => 'facility_delete',
            ],

            "InsuranceCompanys" => [
                "access" => "insuranceCompany_access",
                "add" => 'insuranceCompany_add',
                "edit" => 'insuranceCompany_edit',
                "delete" => 'insuranceCompany_delete',
            ],

            "MarketingAgencys" => [
                "access" => "marketingAgency_access",
                "add" => 'marketingAgency_add',
                "edit" => 'marketingAgency_edit',
                "delete" => 'marketingAgency_delete',
            ],

            "Captins" => [

                "access" => "captin_access",
                "add" => 'captin_add',
                "edit" => 'captin_edit',
                "delete" => 'captin_delete',
            ],
            "Departments" => [

                "access" => "department_access",
                "add" => 'department_add',
                "edit" => 'department_edit',
                "delete" => 'department_delete',
            ],
            "Vehicles" => [

                "access" => "vehicle_access",
                "add" => 'vehicle_add',
                "edit" => 'vehicle_edit',
                "delete" => 'vehicle_delete',
            ],

            "Clients" => [

                "access" => "client_access",
                "add" => 'client_add',
                "edit" => 'client_edit',
                "delete" => 'client_delete',
            ],

            "ClientTrillions" => [

                "access" => "clientTrillion_access",
                "add" => 'clientTrillion_add',
                "edit" => 'clientTrillion_edit',
                "delete" => 'clientTrillion_delete',
            ],
            "Claims" => [

                "access" => "claim_access",
                "add" => 'claim_add',
                "edit" => 'claim_edit',
                "delete" => 'claim_delete',
            ],


            "Leads" => [

                "access" => "lead_access",
                "add" => 'lead_add',
                "edit" => 'lead_edit',
                "delete" => 'lead_delete',
            ],
            "Offers" => [
                "access" => "offer_access",
                "add" => 'offer_add',
                "edit" => 'offer_edit',
                "delete" => 'offer_delete',
            ],
            Contract::ui['p_ucf'] => [
                "access" => Contract::ui['s_lcf'] . "_access",
                "add" => Contract::ui['s_lcf'] . '_add',
                "edit" => Contract::ui['s_lcf'] . '_edit',
                "delete" => Contract::ui['s_lcf'] . '_delete',
            ],
            Project::ui['p_ucf'] => [
                "access" => Project::ui['s_lcf'] . "_access",
                "add" => Project::ui['s_lcf'] . '_add',
                "edit" => Project::ui['s_lcf'] . '_edit',
                "delete" => Project::ui['s_lcf'] . '_delete',
            ],
            Task::ui['p_ucf'] => [
                "access" => Task::ui['s_lcf'] . "_access",
                "add" => Task::ui['s_lcf'] . '_add',
                "edit" => Task::ui['s_lcf'] . '_edit',
                "delete" => Task::ui['s_lcf'] . '_delete',
            ],


            "Captins Calls" => [
                "access" => "captin_call_access",
                "add" => 'captin_call_add',
                "edit" => 'captin_call_edit',
                "delete" => 'captin_call_delete',
            ],
            "Client Calls" => [
                "access" => "client_call_access",
                "add" => 'client_call_add',
                "edit" => 'client_call_edit',
                "delete" => 'client_call_delete',
            ],
            "ClientTrillion Calls" => [
                "access" => "clientTrillion_call_access",
                "add" => 'clientTrillion_call_add',
                "edit" => 'clientTrillion_call_edit',
                "delete" => 'clientTrillion_call_delete',
            ],

            "Calls Module" => [
                "access" => "calls_module_access",
                "add" => 'calls_module_add',
                "edit" => 'calls_module_edit',
                "delete" => 'calls_module_delete',
            ],
            "Calls Task Module" => [
                "access" => "callTasks_module_access",
                "add" => 'callTasks_module_add',
                "edit" => 'callTasks_module_edit',
                "delete" => 'callTasks_module_delete',
            ],
            "CDR" => [
                "access" => "cdr_access",
            ],
            "Employee" => [
                "access" => "employee_access",
                "add" => 'employee_add',
                "edit" => 'employee_edit',
                "delete" => 'employee_delete',
            ],

            "Myemployee" => [
                "access" => "myemployee_access",
                "add" => 'myemployee_add',
                "edit" => 'myemployee_edit',
                "delete" => 'myemployee_delete',
            ],

            "Vacation" => [
                "access" => "vacation_module_access",
                "add" => 'vacation_module_add',
                "edit" => 'vacation_module_edit',
                "delete" => 'vacation_module_delete',
            ],
            "Salary" => [
                "access" => "salary_module_access",
                "add" => 'salary_module_add',
                "edit" => 'salary_module_edit',
                "delete" => 'salary_module_delete',
            ],
            "MyVacation" => [
                "access" => "myvacation_module_access",
                "add" => 'myvacation_module_add',
                "edit" => 'myvacation_module_edit',
                "delete" => 'myvacation_module_delete',
            ],
            "Visit" => [
                "access" => "visit_module_access",
                "add" => 'visit_module_add',
                "edit" => 'visit_module_edit',
                "delete" => 'visit_module_delete',
            ],

            "VisitRequest" => [
                "access" => "visitRequests_module_access",
                "add" => 'visitRequest_module_add',
                "edit" => 'visitRequest_module_edit',
                "delete" => 'visitRequests_module_delete',
            ],


            "Ticket" => [
                "access" => "ticket_module_access",
                "add" => 'ticket_module_add',
                "edit" => 'ticket_module_edit',
                "delete" => 'tickets_module_delete',
            ],
            "Orders" => [
                "access" => "order_module_access",
                "add" => 'order_module_add',
                "edit" => 'order_module_edit',
                "delete" => 'order_module_delete',
            ],
            "policyOffers" => [
                "access" => "policyOffer_access",
                "add" => 'policyOffer_add',
                "edit" => 'policyOffer_edit',
                "delete" => 'policyOffer_delete',
            ],

            "Captin SMS" => [
                "access" => "captin_sms_access",
                "add" => "captin_sms_add",
            ],
            "Client SMS" => [
                "access" => "client_sms_access",
                "add" => "client_sms_add",
            ],

            "callTask_sms" => [
                "access" => "callTask_sms_access",
                "add" => "callTask_sms_add",
            ]


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
