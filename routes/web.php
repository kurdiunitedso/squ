<?php


use App\Http\Controllers\Conversations\{
    SysNotifiController,
    SysSmsNotifiController,
    WhatsAppHistoryController,
};


use App\Http\Controllers\Restaurant\{
    RestaurantController,
    RestaurantEmployeeController,
    RestaurantMenuItemController,
    RestaurantBranchController,
    RestaurantAttachmentController
};

use App\Http\Controllers\Facility\{
    FacilityController,
    FacilityEmployeeController,

    FacilityBranchController,
    FacilityAttachmentController
};

use App\Http\Controllers\InsuranceCompany\{
    InsuranceCompanyController,
    InsuranceCompanyTeamController,
    InsuranceCompanyBranchController,
    InsuranceCompanyClientController,
    InsuranceCompanyAttachmentController
};

use App\Http\Controllers\MarketingAgency\{
    MarketingAgencyController,
    MarketingAgencyTeamController,
    MarketingAgencyBranchController,
    MarketingAgencyClientController,
    MarketingAgencyAttachmentController
};

use App\Http\Controllers\Claims\{
    ClaimController,
    ClaimItemController,
    ClaimAttachmentController
};

use App\Http\Controllers\Leads\{
    LeadController,
    LeadAttachmentController
};


use App\Http\Controllers\Offers\{
    OfferController,
    OfferItemController,
    OfferAttachmentController
};

use App\Http\Controllers\Tickets\{
    TicketController,
};
use App\Http\Controllers\Orders\{
    OrderController,
};
use App\Http\Controllers\Vacations\{
    VacationController,
    MyVacationController,
};
use App\Http\Controllers\Salarys\{
    SalaryController,
};

use App\Http\Controllers\Visits\{
    VisitController,
};


use App\Http\Controllers\VisitRequests\{
    VisitRequestController,
};


use App\Http\Controllers\Captins\{
    CaptinController,
    CaptinAttachmentController,
};

use App\Http\Controllers\Vehicles\{
    VehicleController,
    VehicleAttachmentController,
};

use App\Http\Controllers\PolicyOffers\{
    PolicyOfferController,
    PolicyOfferAttachmentController,
    PolicyOfferDriverController
};


use App\Http\Controllers\Clients\{
    ClientController,
    ClientAttachmentController,
};

use App\Http\Controllers\ClientTrillions\{
    ClientTrillionController,
    ClientTrillionAttachmentController,
    ClientTrillionSocialController,
    ClientTrillionTeamController,
    ClientTrillionClaimController
};

use App\Http\Controllers\Calls\{
    CaptinCallController,
    CallTasksCallController,
};
use App\Http\Controllers\SMS\{
    CaptinSMSController,
    CallTaskSMSController
};

use App\Http\Controllers\Settings\{
    ConstantsController,
    MenuController,
    QuestionnaireController,
};
use App\Http\Controllers\UserManagement\{
    PermissionController,
    RolesController,
    UsersController
};
use App\Http\Controllers\{
    Authentication\LoginController,
    CallScheduleController,
    CountryCityController,
    DashboardController,

    LanguageSwitcherController,
    MarketingCallController,

    Procedures\ProcedureController,
};
use App\Http\Controllers\Employee\{
    EmployeeController,
    EmployeeAttachmentController,
    EmployeeWhourController,
    EmployeeSwhourController,
    EmployeeVacationController,
    EmployeePayment_RollController,
    EmployeeSalaryController,
};

use App\Http\Controllers\MyEmployee\{
    MyEmployeeController,
    MyEmployeeAttachmentController,
    MyEmployeeWhourController,
};

use App\Http\Controllers\CDR\{
    CallsController,
    CdrController,
    CallTaskController
};

use App\Http\Controllers\Contracts\ContractController;
use App\Http\Controllers\Contracts\ContractItemController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\Projects\ProjectEmployeeController;
use App\Http\Controllers\Departments\DepartmentController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ProjectTaskController;
use App\Http\Controllers\Projects\ProjectTaskAttachmentController;
use App\Http\Controllers\Projects\TaskProcessCommentController;
use App\Http\Controllers\Tasks\TaskController;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Objective;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectEmployee;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskProcess;
use App\Models\TaskProcessComment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', function () {
    return view('authentication.signIn');
})->name('login');
Route::get('/createOrderCallCenter', [OrderController::class, 'createOrderCallCenter'])->name('createOrderCallCenter');
Route::get('EmployeeWhourReport/{from?}/{to?}', [EmployeeController::class, 'employeeWhourReport'])->name('employeeWhourReport');;

Route::get('autoCheckOut', [EmployeeController::class, 'autoCheckOut'])->name('autoCheckOut');;


Route::get('/webhookwa', [LoginController::class, 'webhookwa'])->name('webhookwa');
Route::post('/webhookwa', [LoginController::class, 'webhookwa2'])->name('webhookwa2');
Route::post('/testwhatsapp', [LoginController::class, 'testwhatsapp'])->name('testwhatsapp');
Route::get('/updateBalance', [EmployeeVacationController::class, 'updateBalance'])->name('updateBalance');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/updateCDR', [CdrController::class, 'updateLocalCDR'])->name('updateLocalCDR');
Route::middleware(['auth', 'language'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::impersonate();

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });


    //Set Locale
    Route::get('/setLangauge/{language}', [LanguageSwitcherController::class, 'setLanguage'])->name('setLanguage');
    Route::get('getSelect', [\App\Http\Controllers\Controller::class, 'getSelect'])->name('getSelect');
    Route::get('getSelect2Details', [DashboardController::class, 'getSelect2Details'])->name('getSelect2Details'); //this is a v2 of getSelect (we should update the getSelect later to be like getSelect2)
    Route::get('getSelect2', [DashboardController::class, 'getSelect2'])->name('getSelect2'); //this is a v2 of getSelect (we should update the getSelect later to be like getSelect2)
    Route::get('getSelect2WithoutSearchOrPaginate', [DashboardController::class, 'getSelect2WithoutSearchOrPaginate'])->name('getSelect2WithoutSearchOrPaginate'); //this is a v2 of getSelect (we should update the getSelect later to be like getSelect2)
    Route::post('/store-objective', [DashboardController::class, 'storeObjective'])->name('store-objective');
    Route::get('/get-objectives', [DashboardController::class, 'getObjectives'])->name('get-objectives');
    Route::delete('attachments/{attachment}', [DashboardController::class, 'remove_attachment'])->name('remove-attachment');



    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::prefix('permissions')->name('permissions.')
            ->middleware(['permission:user_management_access'])
            ->group(function () {
                Route::match(['get', 'post'], '/', [PermissionController::class, 'index'])->name('index');
                Route::post('/add-permission', [PermissionController::class, 'addPermission'])->name('add');
                Route::post('/delete-permission/{permission}', [PermissionController::class, 'deletePermission'])->name('delete');
            });

        Route::prefix('roles')->name('roles.')
            ->middleware(['permission:user_management_access'])
            ->group(function () {
                Route::get('/', [RolesController::class, 'index'])->name('index');
                Route::get('/getCards', [RolesController::class, 'getCards'])->name('getCards');
                Route::get('/create', [RolesController::class, 'create'])->name('create');
                Route::post('/store', [RolesController::class, 'store'])->name('store');
                Route::get('/{role}/edit', [RolesController::class, 'edit'])->name('edit');
                Route::post('{role}/update', [RolesController::class, 'update'])->name('update');
                Route::delete('{role}/delete', [RolesController::class, 'delete'])->name('delete');
            });

        Route::prefix('users')->name('users.')
            ->middleware(['permission:user_management_access'])
            ->group(function () {
                Route::match(['get', 'post'], '/', [UsersController::class, 'index'])->name('index');
                Route::get('/create', [UsersController::class, 'create'])->name('create');
                Route::post('/store', [UsersController::class, 'store'])->name('store');
                Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit');
                Route::post('{user}/update', [UsersController::class, 'update'])->name('update');
                Route::delete('{user}/delete', [UsersController::class, 'delete'])->name('delete');

                Route::get('/export', [UsersController::class, 'export'])->name('export');
            });
    });


    Route::prefix('settings')->name('settings.')
        ->group(function () {
            Route::prefix('CountriesCities')->name('country-city.')
                ->middleware(['permission:settings_country_city_access'])
                ->group(function () {
                    Route::get('/', [CountryCityController::class, 'index'])->name('index');
                    Route::post('/Countries', [CountryCityController::class, 'countries'])->name('countries');
                    Route::post('/Cities', [CountryCityController::class, 'cities'])->name('cities');

                    Route::get('country/create', [CountryCityController::class, 'country_create'])->name('country.create');
                    Route::post('country/store', [CountryCityController::class, 'country_store'])->name('country.store');
                    Route::get('country/{country}/edit', [CountryCityController::class, 'country_edit'])->name('country.edit');
                    Route::post('country/{country}/update', [CountryCityController::class, 'country_update'])->name('country.update');
                    Route::delete('country/{country}/delete', [CountryCityController::class, 'country_delete'])->name('country.delete');

                    Route::get('city/create', [CountryCityController::class, 'city_create'])->name('city.create');
                    Route::post('city/store', [CountryCityController::class, 'city_store'])->name('city.store');
                    Route::get('city/{city}/edit', [CountryCityController::class, 'city_edit'])->name('city.edit');
                    Route::post('city/{city}/update', [CountryCityController::class, 'city_update'])->name('city.update');
                    Route::delete('city/{city}/delete', [CountryCityController::class, 'city_delete'])->name('city.delete');
                });
            Route::prefix(Objective::ui['route'])
                ->name(Objective::ui['route'] . '.')
                ->middleware(['permission:settings_' . Objective::ui['route'] . '_access'])
                ->controller(ObjectiveController::class)
                ->group(function () {
                    Route::match(['get', 'post'], '/', 'index')->name('index');
                    Route::get('create', 'create')->name('create');
                    Route::post('store', 'store')->name('store');
                    Route::get('{' . Objective::ui['s_lcf'] . '}/edit', 'edit')->name('edit');
                    Route::post('{' . Objective::ui['s_lcf'] . '}/update', 'update')->name('update');
                    Route::delete('{' . Objective::ui['s_lcf'] . '}/delete', 'delete')->name('delete');
                });
            Route::prefix('Menus')->name('menus.')
                ->middleware(['permission:settings_menu_access'])
                ->group(function () {
                    Route::match(['GET', 'POST'], '/', [MenuController::class, 'index'])->name('index');
                    Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
                    Route::post('{menu}/update', [MenuController::class, 'update'])->name('update');
                });


            Route::prefix('questionnaires')->name('questionnaires.')
                ->middleware(['permission:settings_questionnaire_access'])
                ->group(function () {
                    Route::match(['GET', 'POST'], '/', [QuestionnaireController::class, 'index'])->name('index');
                    Route::get('/create', [QuestionnaireController::class, 'create'])->name('create');
                    Route::post('/store', [QuestionnaireController::class, 'store'])->name('store');
                    Route::get('/{questionnaire}/edit', [QuestionnaireController::class, 'edit'])->name('edit');
                    Route::post('{questionnaire}/update', [QuestionnaireController::class, 'update'])->name('update');
                    Route::delete('{questionnaire}/delete', [QuestionnaireController::class, 'delete'])->name('delete');

                    Route::get('{questionnaire}/get_questions', [QuestionnaireController::class, 'getQuestionnaireQuestions'])->name('get_questions');
                });


            Route::prefix('Constants')->name('constants.')
                ->middleware(['permission:settings_constants_access'])
                ->group(function () {
                    Route::match(['GET', 'POST'], '/', [ConstantsController::class, 'index'])->name('index');
                    Route::post('/store', [ConstantsController::class, 'store'])->name('store');
                    Route::get('/{constant}/edit/{module?}', [ConstantsController::class, 'edit'])->name('edit');
                    Route::post('/{constant}/update', [ConstantsController::class, 'update'])->name('update');
                });
        });

    Route::prefix('restaurants')->name('restaurants.')
        ->group(function () {
            Route::get('/export', [RestaurantController::class, 'export'])->name('export')->middleware(['permission:restaurant_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [RestaurantController::class, 'index'])->name('index')
                ->middleware(['permission:restaurant_access']);
            Route::get('/create', [RestaurantController::class, 'create'])->name('create')->middleware(['permission:restaurant_add']);
            Route::post('/store', [RestaurantController::class, 'store'])->name('store')->middleware(['permission:restaurant_add']);
            Route::get('/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('edit')->middleware(['permission:restaurant_edit']);
            Route::post('{restaurant}/update', [RestaurantController::class, 'update'])->name('update')->middleware(['permission:restaurant_edit']);
            Route::delete('{restaurant}/delete', [RestaurantController::class, 'delete'])->name('delete')->middleware(['permission:restaurant_delete']);
            Route::post('/Restaurant/{Id?}', [RestaurantController::class, 'Restaurant'])->name('addedit')
                ->middleware(['permission:restaurant_add']);
            Route::get('/getByTelephone/{telephone}', [RestaurantBranchController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/addEmployee', [RestaurantEmployeeController::class, 'createEmployee'])->name('employees.add')->middleware(['permission:restaurant_edit']);
            Route::post('/storeEmployee', [RestaurantEmployeeController::class, 'storeEmployee'])->name('employees.store')->middleware(['permission:restaurant_edit']);
            Route::get('{employee}/editEmployee', [RestaurantEmployeeController::class, 'editEmployee'])->name('employees.edit')->middleware(['permission:restaurant_edit']);
            Route::get('{employee}/view_calls', [RestaurantEmployeeController::class, 'viewCalls'])->name('employees.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateEmployee', [RestaurantEmployeeController::class, 'updateEmployee'])->name('employees.update')->middleware(['permission:restaurant_edit']);
            Route::delete('{employee}/deleteEmployee', [RestaurantEmployeeController::class, 'deleteEmployee'])->name('employees.delete')->middleware(['permission:restaurant_edit']);
            Route::match(['get', 'post'], '{restaurant?}/restaurantEmployee', [RestaurantEmployeeController::class, 'indexEmployee'])->name('employees.index')
                ->middleware(['permission:restaurant_edit']);

            Route::get('/addMenuItem', [RestaurantMenuItemController::class, 'createMenuItem'])->name('menuItems.add')->middleware(['permission:restaurant_edit']);
            Route::post('/storeMenuItem', [RestaurantMenuItemController::class, 'storeMenuItem'])->name('menuItems.store')->middleware(['permission:restaurant_edit']);
            Route::get('{menuItem}/editMenuItem', [RestaurantMenuItemController::class, 'editMenuItem'])->name('menuItems.edit')->middleware(['permission:restaurant_edit']);
            Route::post('/updateMenuItem', [RestaurantMenuItemController::class, 'updateMenuItem'])->name('menuItems.update')->middleware(['permission:restaurant_edit']);
            Route::delete('{menuItem}/deleteMenuItem', [RestaurantMenuItemController::class, 'deleteMenuItem'])->name('menuItems.delete')->middleware(['permission:restaurant_edit']);
            Route::match(['get', 'post'], '{restaurant?}/restaurantMenuItem', [RestaurantMenuItemController::class, 'indexMenuItem'])->name('menuItems.index')
                ->middleware(['permission:restaurant_edit']);


            Route::get('/addBranch', [RestaurantBranchController::class, 'createBranch'])->name('branchs.add')->middleware(['permission:restaurant_edit']);
            Route::post('/storeBranch', [RestaurantBranchController::class, 'storeBranch'])->name('branchs.store')->middleware(['permission:restaurant_edit']);
            Route::get('{branch}/editBranch', [RestaurantBranchController::class, 'editBranch'])->name('branchs.edit')->middleware(['permission:restaurant_edit']);
            Route::post('/updateBranch', [RestaurantBranchController::class, 'updateBranch'])->name('branchs.update')->middleware(['permission:restaurant_edit']);
            Route::delete('{branch}/deleteBranch', [RestaurantBranchController::class, 'deleteBranch'])->name('branchs.delete')->middleware(['permission:restaurant_edit']);
            Route::match(['get', 'post'], '{restaurant?}/restaurantBranch', [RestaurantBranchController::class, 'indexBranch'])->name('branchs.index')
                ->middleware(['permission:restaurant_edit']);

            Route::match(['GET', 'POST'], '/{restaurant}/attachments', [RestaurantAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:restaurant_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:restaurant_edit'])
                ->group(function () {
                    Route::get('/{restaurant}/create', [RestaurantAttachmentController::class, 'create'])->name('create');
                    Route::post('/{restaurant}/store', [RestaurantAttachmentController::class, 'store'])->name('store');
                    Route::get('/{restaurant}/{attachment}/edit', [RestaurantAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{restaurant}/{attachment}/update', [RestaurantAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [RestaurantAttachmentController::class, 'delete'])->name('delete');
                });

            Route::get('{restaurant}/sms', [RestaurantController::class, 'viewSMS'])->name('view_sms')
                ->middleware(['permission:restaurant_edit']);
            Route::get('{restaurant}/calls', [RestaurantController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:restaurant_edit']);

            Route::get('{restaurant}/items', [RestaurantController::class, 'viewItems'])->name('view_items')
                ->middleware(['permission:restaurant_edit']);

            Route::get('{restaurant}/visits', [RestaurantController::class, 'viewVisits'])->name('view_visits')
                ->middleware(['permission:restaurant_edit']);
            Route::get('{restaurant}/tickets', [RestaurantController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:restaurant_edit']);


            Route::get('{restaurant}/viewattachments', [RestaurantController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:restaurant_edit']);

            Route::get('{restaurant}/employees', [RestaurantController::class, 'viewEmployees'])->name('view_employees')
                ->middleware(['permission:restaurant_edit']);
            Route::get('{restaurant}/branches', [RestaurantController::class, 'viewBrnaches'])->name('view_brnaches')
                ->middleware(['permission:restaurant_edit']);


            Route::get('{branch}/sms', [RestaurantBranchController::class, 'viewSms'])->name('branch_view_sms')
                ->middleware(['permission:restaurant_edit']);
            Route::get('{branch}/branch_calls', [RestaurantBranchController::class, 'viewCalls'])->name('branch_view_calls')
                ->middleware(['permission:restaurant_edit']);
        });
    Route::prefix('facilities')->name('facilities.')
        ->group(function () {
            Route::get('/export', [FacilityController::class, 'export'])->name('export')->middleware(['permission:facility_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [FacilityController::class, 'index'])->name('index')
                ->middleware(['permission:facility_access']);
            Route::get('/create', [FacilityController::class, 'create'])->name('create')->middleware(['permission:facility_add']);
            Route::post('/store', [FacilityController::class, 'store'])->name('store')->middleware(['permission:facility_add']);
            Route::get('/{facility}/edit', [FacilityController::class, 'edit'])->name('edit')->middleware(['permission:facility_edit']);
            Route::post('{facility}/update', [FacilityController::class, 'update'])->name('update')->middleware(['permission:facility_edit']);
            Route::delete('{facility}/delete', [FacilityController::class, 'delete'])->name('delete')->middleware(['permission:facility_delete']);
            Route::post('/Facility/{Id?}', [FacilityController::class, 'Facility'])->name('addedit')
                ->middleware(['permission:facility_add']);
            Route::get('/getByTelephone/{telephone}', [FacilityBranchController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/addEmployee', [FacilityEmployeeController::class, 'createEmployee'])->name('employees.add')->middleware(['permission:facility_edit']);
            Route::post('/storeEmployee', [FacilityEmployeeController::class, 'storeEmployee'])->name('employees.store')->middleware(['permission:facility_edit']);
            Route::get('{employee}/editEmployee', [FacilityEmployeeController::class, 'editEmployee'])->name('employees.edit')->middleware(['permission:facility_edit']);
            Route::get('{employee}/view_calls', [FacilityEmployeeController::class, 'viewCalls'])->name('employees.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateEmployee', [FacilityEmployeeController::class, 'updateEmployee'])->name('employees.update')->middleware(['permission:facility_edit']);
            Route::delete('{employee}/deleteEmployee', [FacilityEmployeeController::class, 'deleteEmployee'])->name('employees.delete')->middleware(['permission:facility_edit']);
            Route::match(['get', 'post'], '{facility?}/facilityEmployee', [FacilityEmployeeController::class, 'indexEmployee'])->name('employees.index')
                ->middleware(['permission:facility_edit']);


            Route::get('/addBranch', [FacilityBranchController::class, 'createBranch'])->name('branchs.add')->middleware(['permission:facility_edit']);
            Route::post('/storeBranch', [FacilityBranchController::class, 'storeBranch'])->name('branchs.store')->middleware(['permission:facility_edit']);
            Route::get('{branch}/editBranch', [FacilityBranchController::class, 'editBranch'])->name('branchs.edit')->middleware(['permission:facility_edit']);
            Route::post('/updateBranch', [FacilityBranchController::class, 'updateBranch'])->name('branchs.update')->middleware(['permission:facility_edit']);
            Route::delete('{branch}/deleteBranch', [FacilityBranchController::class, 'deleteBranch'])->name('branchs.delete')->middleware(['permission:facility_edit']);
            Route::match(['get', 'post'], '{facility?}/facilityBranch', [FacilityBranchController::class, 'indexBranch'])->name('branchs.index')
                ->middleware(['permission:facility_edit']);

            Route::match(['GET', 'POST'], '/{facility}/attachments', [FacilityAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:facility_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:facility_edit'])
                ->group(function () {
                    Route::get('/{facility}/create', [FacilityAttachmentController::class, 'create'])->name('create');
                    Route::post('/{facility}/store', [FacilityAttachmentController::class, 'store'])->name('store');
                    Route::get('/{facility}/{attachment}/edit', [FacilityAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{facility}/{attachment}/update', [FacilityAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [FacilityAttachmentController::class, 'delete'])->name('delete');
                });

            Route::get('{facility}/sms', [FacilityController::class, 'viewSMS'])->name('view_sms')
                ->middleware(['permission:facility_edit']);
            Route::get('{facility}/calls', [FacilityController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:facility_edit']);

            Route::get('{facility}/items', [FacilityController::class, 'viewItems'])->name('view_items')
                ->middleware(['permission:facility_edit']);

            Route::get('{facility}/visits', [FacilityController::class, 'viewVisits'])->name('view_visits')
                ->middleware(['permission:facility_edit']);
            Route::get('{facility}/tickets', [FacilityController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:facility_edit']);


            Route::get('{facility}/viewattachments', [FacilityController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:facility_edit']);

            Route::get('{facility}/employees', [FacilityController::class, 'viewEmployees'])->name('view_employees')
                ->middleware(['permission:facility_edit']);
            Route::get('{facility}/branches', [FacilityController::class, 'viewBrnaches'])->name('view_brnaches')
                ->middleware(['permission:facility_edit']);


            Route::get('{branch}/sms', [FacilityBranchController::class, 'viewSms'])->name('branch_view_sms')
                ->middleware(['permission:facility_edit']);
            Route::get('{branch}/branch_calls', [FacilityBranchController::class, 'viewCalls'])->name('branch_view_calls')
                ->middleware(['permission:facility_edit']);

            Route::post('{_model}/add_offer', [FacilityController::class, 'add_offer'])->name('add_offer')
                ->middleware(['permission:facility_edit']);
        });


    Route::prefix('insuranceCompanys')->name('insuranceCompanys.')
        ->group(function () {
            Route::get('/export', [InsuranceCompanyController::class, 'export'])->name('export')->middleware(['permission:insuranceCompany_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [InsuranceCompanyController::class, 'index'])->name('index')
                ->middleware(['permission:insuranceCompany_access']);
            Route::get('/create', [InsuranceCompanyController::class, 'create'])->name('create')->middleware(['permission:insuranceCompany_add']);
            Route::post('/store', [InsuranceCompanyController::class, 'store'])->name('store')->middleware(['permission:insuranceCompany_add']);
            Route::get('/{insuranceCompany}/edit', [InsuranceCompanyController::class, 'edit'])->name('edit')->middleware(['permission:insuranceCompany_edit']);
            Route::post('{insuranceCompany}/update', [InsuranceCompanyController::class, 'update'])->name('update')->middleware(['permission:insuranceCompany_edit']);
            Route::delete('{insuranceCompany}/delete', [InsuranceCompanyController::class, 'delete'])->name('delete')->middleware(['permission:insuranceCompany_delete']);
            Route::post('/InsuranceCompany/{Id?}', [InsuranceCompanyController::class, 'InsuranceCompany'])->name('addedit')
                ->middleware(['permission:insuranceCompany_add']);
            Route::get('/getByTelephone/{telephone}', [InsuranceCompanyBranchController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/addTeam', [InsuranceCompanyTeamController::class, 'createTeam'])->name('teams.add')->middleware(['permission:insuranceCompany_edit']);
            Route::post('/storeTeam', [InsuranceCompanyTeamController::class, 'storeTeam'])->name('teams.store')->middleware(['permission:insuranceCompany_edit']);
            Route::get('{team}/editTeam', [InsuranceCompanyTeamController::class, 'editTeam'])->name('teams.edit')->middleware(['permission:insuranceCompany_edit']);
            Route::get('{team}/view_calls', [InsuranceCompanyTeamController::class, 'viewCalls'])->name('teams.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateTeam', [InsuranceCompanyTeamController::class, 'updateTeam'])->name('teams.update')->middleware(['permission:insuranceCompany_edit']);
            Route::delete('{team}/deleteTeam', [InsuranceCompanyTeamController::class, 'deleteTeam'])->name('teams.delete')->middleware(['permission:insuranceCompany_edit']);
            Route::match(['get', 'post'], '{insuranceCompany?}/insuranceCompanyTeam', [InsuranceCompanyTeamController::class, 'indexTeam'])->name('teams.index')
                ->middleware(['permission:insuranceCompany_edit']);


            Route::get('/addBranch', [InsuranceCompanyBranchController::class, 'createBranch'])->name('branchs.add')->middleware(['permission:insuranceCompany_edit']);
            Route::post('/storeBranch', [InsuranceCompanyBranchController::class, 'storeBranch'])->name('branchs.store')->middleware(['permission:insuranceCompany_edit']);
            Route::get('{branch}/editBranch', [InsuranceCompanyBranchController::class, 'editBranch'])->name('branchs.edit')->middleware(['permission:insuranceCompany_edit']);
            Route::post('/updateBranch', [InsuranceCompanyBranchController::class, 'updateBranch'])->name('branchs.update')->middleware(['permission:insuranceCompany_edit']);
            Route::delete('{branch}/deleteBranch', [InsuranceCompanyBranchController::class, 'deleteBranch'])->name('branchs.delete')->middleware(['permission:insuranceCompany_edit']);
            Route::match(['get', 'post'], '{insuranceCompany?}/insuranceCompanyBranch', [InsuranceCompanyBranchController::class, 'indexBranch'])->name('branchs.index')
                ->middleware(['permission:insuranceCompany_edit']);


            Route::get('/addClient', [InsuranceCompanyClientController::class, 'createClient'])->name('clients.add')->middleware(['permission:insuranceCompany_edit']);
            Route::post('/storeClient', [InsuranceCompanyClientController::class, 'storeClient'])->name('clients.store')->middleware(['permission:insuranceCompany_edit']);
            Route::get('{client}/editClient', [InsuranceCompanyClientController::class, 'editClient'])->name('clients.edit')->middleware(['permission:insuranceCompany_edit']);
            Route::post('/updateClient', [InsuranceCompanyClientController::class, 'updateClient'])->name('clients.update')->middleware(['permission:insuranceCompany_edit']);
            Route::delete('{client}/deleteClient', [InsuranceCompanyClientController::class, 'deleteClient'])->name('clients.delete')->middleware(['permission:insuranceCompany_edit']);
            Route::match(['get', 'post'], '{insuranceCompany?}/insuranceCompanyClient', [InsuranceCompanyClientController::class, 'indexClient'])->name('clients.index')
                ->middleware(['permission:insuranceCompany_edit']);


            Route::match(['GET', 'POST'], '/{insuranceCompany}/attachments', [InsuranceCompanyAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:insuranceCompany_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:insuranceCompany_edit'])
                ->group(function () {
                    Route::get('/{insuranceCompany}/create', [InsuranceCompanyAttachmentController::class, 'create'])->name('create');
                    Route::post('/{insuranceCompany}/store', [InsuranceCompanyAttachmentController::class, 'store'])->name('store');
                    Route::get('/{insuranceCompany}/{attachment}/edit', [InsuranceCompanyAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{insuranceCompany}/{attachment}/update', [InsuranceCompanyAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [InsuranceCompanyAttachmentController::class, 'delete'])->name('delete');
                });

            Route::get('{insuranceCompany}/sms', [InsuranceCompanyController::class, 'viewSMS'])->name('view_sms')
                ->middleware(['permission:insuranceCompany_edit']);
            Route::get('{insuranceCompany}/calls', [InsuranceCompanyController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:insuranceCompany_edit']);

            Route::get('{insuranceCompany}/items', [InsuranceCompanyController::class, 'viewItems'])->name('view_items')
                ->middleware(['permission:insuranceCompany_edit']);

            Route::get('{insuranceCompany}/clients', [InsuranceCompanyController::class, 'viewClients'])->name('view_clients')
                ->middleware(['permission:insuranceCompany_edit']);
            Route::get('{insuranceCompany}/tickets', [InsuranceCompanyController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:insuranceCompany_edit']);


            Route::get('{insuranceCompany}/viewattachments', [InsuranceCompanyController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:insuranceCompany_edit']);

            Route::get('{insuranceCompany}/teams', [InsuranceCompanyController::class, 'viewTeams'])->name('view_teams')
                ->middleware(['permission:insuranceCompany_edit']);
            Route::get('{insuranceCompany}/branches', [InsuranceCompanyController::class, 'viewBrnaches'])->name('view_brnaches')
                ->middleware(['permission:insuranceCompany_edit']);


            Route::get('{branch}/sms', [InsuranceCompanyBranchController::class, 'viewSms'])->name('branch_view_sms')
                ->middleware(['permission:insuranceCompany_edit']);
            Route::get('{branch}/branch_calls', [InsuranceCompanyBranchController::class, 'viewCalls'])->name('branch_view_calls')
                ->middleware(['permission:insuranceCompany_edit']);
        });



    Route::prefix('marketingAgencys')->name('marketingAgencys.')
        ->group(function () {
            Route::get('/export', [MarketingAgencyController::class, 'export'])->name('export')->middleware(['permission:marketingAgency_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [MarketingAgencyController::class, 'index'])->name('index')
                ->middleware(['permission:marketingAgency_access']);
            Route::get('/create', [MarketingAgencyController::class, 'create'])->name('create')->middleware(['permission:marketingAgency_add']);
            Route::post('/store', [MarketingAgencyController::class, 'store'])->name('store')->middleware(['permission:marketingAgency_add']);
            Route::get('/{marketingAgency}/edit', [MarketingAgencyController::class, 'edit'])->name('edit')->middleware(['permission:marketingAgency_edit']);
            Route::post('{marketingAgency}/update', [MarketingAgencyController::class, 'update'])->name('update')->middleware(['permission:marketingAgency_edit']);
            Route::delete('{marketingAgency}/delete', [MarketingAgencyController::class, 'delete'])->name('delete')->middleware(['permission:marketingAgency_delete']);
            Route::post('/MarketingAgency/{Id?}', [MarketingAgencyController::class, 'MarketingAgency'])->name('addedit')
                ->middleware(['permission:marketingAgency_add']);
            Route::get('/getByTelephone/{telephone}', [MarketingAgencyBranchController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/addTeam', [MarketingAgencyTeamController::class, 'createTeam'])->name('teams.add')->middleware(['permission:marketingAgency_edit']);
            Route::post('/storeTeam', [MarketingAgencyTeamController::class, 'storeTeam'])->name('teams.store')->middleware(['permission:marketingAgency_edit']);
            Route::get('{team}/editTeam', [MarketingAgencyTeamController::class, 'editTeam'])->name('teams.edit')->middleware(['permission:marketingAgency_edit']);
            Route::get('{team}/view_calls', [MarketingAgencyTeamController::class, 'viewCalls'])->name('teams.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateTeam', [MarketingAgencyTeamController::class, 'updateTeam'])->name('teams.update')->middleware(['permission:marketingAgency_edit']);
            Route::delete('{team}/deleteTeam', [MarketingAgencyTeamController::class, 'deleteTeam'])->name('teams.delete')->middleware(['permission:marketingAgency_edit']);
            Route::match(['get', 'post'], '{marketingAgency?}/marketingAgencyTeam', [MarketingAgencyTeamController::class, 'indexTeam'])->name('teams.index')
                ->middleware(['permission:marketingAgency_edit']);


            Route::get('/addBranch', [MarketingAgencyBranchController::class, 'createBranch'])->name('branchs.add')->middleware(['permission:marketingAgency_edit']);
            Route::post('/storeBranch', [MarketingAgencyBranchController::class, 'storeBranch'])->name('branchs.store')->middleware(['permission:marketingAgency_edit']);
            Route::get('{branch}/editBranch', [MarketingAgencyBranchController::class, 'editBranch'])->name('branchs.edit')->middleware(['permission:marketingAgency_edit']);
            Route::post('/updateBranch', [MarketingAgencyBranchController::class, 'updateBranch'])->name('branchs.update')->middleware(['permission:marketingAgency_edit']);
            Route::delete('{branch}/deleteBranch', [MarketingAgencyBranchController::class, 'deleteBranch'])->name('branchs.delete')->middleware(['permission:marketingAgency_edit']);
            Route::match(['get', 'post'], '{marketingAgency?}/marketingAgencyBranch', [MarketingAgencyBranchController::class, 'indexBranch'])->name('branchs.index')
                ->middleware(['permission:marketingAgency_edit']);


            Route::get('/addClient', [MarketingAgencyClientController::class, 'createClient'])->name('clients.add')->middleware(['permission:marketingAgency_edit']);
            Route::post('/storeClient', [MarketingAgencyClientController::class, 'storeClient'])->name('clients.store')->middleware(['permission:marketingAgency_edit']);
            Route::get('{client}/editClient', [MarketingAgencyClientController::class, 'editClient'])->name('clients.edit')->middleware(['permission:marketingAgency_edit']);
            Route::post('/updateClient', [MarketingAgencyClientController::class, 'updateClient'])->name('clients.update')->middleware(['permission:marketingAgency_edit']);
            Route::delete('{client}/deleteClient', [MarketingAgencyClientController::class, 'deleteClient'])->name('clients.delete')->middleware(['permission:marketingAgency_edit']);
            Route::match(['get', 'post'], '{marketingAgency?}/marketingAgencyClient', [MarketingAgencyClientController::class, 'indexClient'])->name('clients.index')
                ->middleware(['permission:marketingAgency_edit']);


            Route::match(['GET', 'POST'], '/{marketingAgency}/attachments', [MarketingAgencyAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:marketingAgency_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:marketingAgency_edit'])
                ->group(function () {
                    Route::get('/{marketingAgency}/create', [MarketingAgencyAttachmentController::class, 'create'])->name('create');
                    Route::post('/{marketingAgency}/store', [MarketingAgencyAttachmentController::class, 'store'])->name('store');
                    Route::get('/{marketingAgency}/{attachment}/edit', [MarketingAgencyAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{marketingAgency}/{attachment}/update', [MarketingAgencyAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [MarketingAgencyAttachmentController::class, 'delete'])->name('delete');
                });

            Route::get('{marketingAgency}/sms', [MarketingAgencyController::class, 'viewSMS'])->name('view_sms')
                ->middleware(['permission:marketingAgency_edit']);
            Route::get('{marketingAgency}/calls', [MarketingAgencyController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:marketingAgency_edit']);

            Route::get('{marketingAgency}/items', [MarketingAgencyController::class, 'viewItems'])->name('view_items')
                ->middleware(['permission:marketingAgency_edit']);

            Route::get('{marketingAgency}/clients', [MarketingAgencyController::class, 'viewClients'])->name('view_clients')
                ->middleware(['permission:marketingAgency_edit']);
            Route::get('{marketingAgency}/tickets', [MarketingAgencyController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:marketingAgency_edit']);


            Route::get('{marketingAgency}/viewattachments', [MarketingAgencyController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:marketingAgency_edit']);

            Route::get('{marketingAgency}/teams', [MarketingAgencyController::class, 'viewTeams'])->name('view_teams')
                ->middleware(['permission:marketingAgency_edit']);
            Route::get('{marketingAgency}/branches', [MarketingAgencyController::class, 'viewBrnaches'])->name('view_brnaches')
                ->middleware(['permission:marketingAgency_edit']);


            Route::get('{branch}/sms', [MarketingAgencyBranchController::class, 'viewSms'])->name('branch_view_sms')
                ->middleware(['permission:marketingAgency_edit']);
            Route::get('{branch}/branch_calls', [MarketingAgencyBranchController::class, 'viewCalls'])->name('branch_view_calls')
                ->middleware(['permission:marketingAgency_edit']);
        });


    Route::prefix('claims')->name('claims.')
        ->group(function () {
            Route::get('/export', [ClaimController::class, 'export'])->name('export')->middleware(['permission:claim_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [ClaimController::class, 'index'])->name('index')
                ->middleware(['permission:claim_access']);
            Route::get('/create', [ClaimController::class, 'create'])->name('create')->middleware(['permission:claim_add']);
            Route::post('/store', [ClaimController::class, 'store'])->name('store')->middleware(['permission:claim_add']);
            Route::get('/{claim}/edit', [ClaimController::class, 'edit'])->name('edit')->middleware(['permission:claim_edit']);
            Route::post('{claim}/update', [ClaimController::class, 'update'])->name('update')->middleware(['permission:claim_edit']);
            Route::delete('{claim}/delete', [ClaimController::class, 'delete'])->name('delete')->middleware(['permission:claim_delete']);
            Route::post('/Claim/{Id?}', [ClaimController::class, 'Claim'])->name('addedit')
                ->middleware(['permission:claim_add']);

            Route::get('/addItem', [ClaimItemController::class, 'createItem'])->name('items.add')->middleware(['permission:claim_edit']);
            Route::post('/storeItem', [ClaimItemController::class, 'storeItem'])->name('items.store')->middleware(['permission:claim_edit']);
            Route::get('{item}/editItem', [ClaimItemController::class, 'editItem'])->name('items.edit')->middleware(['permission:claim_edit']);
            Route::get('{item}/view_calls', [ClaimItemController::class, 'viewCalls'])->name('items.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateItem', [ClaimItemController::class, 'updateItem'])->name('items.update')->middleware(['permission:claim_edit']);
            Route::delete('{item}/deleteItem', [ClaimItemController::class, 'deleteItem'])->name('items.delete')->middleware(['permission:claim_edit']);
            Route::match(['get', 'post'], '{claim?}/claimItem', [ClaimItemController::class, 'indexItem'])->name('items.index')
                ->middleware(['permission:claim_access']);


            Route::match(['GET', 'POST'], '/{claim}/attachments', [ClaimAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:claim_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:claim_edit'])
                ->group(function () {
                    Route::get('/{claim}/create', [ClaimAttachmentController::class, 'create'])->name('create');
                    Route::post('/{claim}/store', [ClaimAttachmentController::class, 'store'])->name('store');
                    Route::get('/{claim}/{attachment}/edit', [ClaimAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{claim}/{attachment}/update', [ClaimAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [ClaimAttachmentController::class, 'delete'])->name('delete');
                });

            Route::get('{claim}/sms', [ClaimController::class, 'viewSMS'])->name('view_sms')
                ->middleware(['permission:claim_access']);
            Route::get('{claim}/calls', [ClaimController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:claim_access']);

            Route::get('{claim}/items', [ClaimController::class, 'viewItems'])->name('view_items')
                ->middleware(['permission:claim_access']);

            Route::get('{claim}/clients', [ClaimController::class, 'viewClients'])->name('view_clients')
                ->middleware(['permission:claim_edit']);
            Route::get('{claim}/tickets', [ClaimController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:claim_access']);


            Route::get('{claim}/viewattachments', [ClaimController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:claim_access']);

            Route::get('{claim}/teams', [ClaimController::class, 'viewItems'])->name('view_teams')
                ->middleware(['permission:claim_access']);

            Route::get('{claim}/printClaim', [ClaimController::class, 'printClaim'])->name('printClaim')
                ->middleware(['permission:claim_access']);
            Route::get('{claim}/sendEmail', [ClaimController::class, 'sendEmail'])->name('sendEmail')
                ->middleware(['permission:claim_access']);
            Route::post('sendEmailTo', [ClaimController::class, 'sendEmailTo'])->name('sendEmailTo')
                ->middleware(['permission:claim_access']);
        });


    Route::prefix('offers')->name('offers.')->group(function () {
        Route::get('/export', [OfferController::class, 'export'])->name('export')->middleware(['permission:offer_access']);
        Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
        Route::match(['get', 'post'], '/', [OfferController::class, 'index'])->name('index')
            ->middleware(['permission:offer_access']);
        Route::get('/create', [OfferController::class, 'create'])->name('create')->middleware(['permission:offer_add']);
        Route::post('/store', [OfferController::class, 'store'])->name('store')->middleware(['permission:offer_add']);
        Route::get('/{offer}/edit', [OfferController::class, 'edit'])->name('edit')->middleware(['permission:offer_edit']);
        Route::post('{offer}/update', [OfferController::class, 'update'])->name('update')->middleware(['permission:offer_edit']);
        Route::delete('{offer}/delete', [OfferController::class, 'delete'])->name('delete')->middleware(['permission:offer_delete']);
        Route::post('/Offer/{Id?}', [OfferController::class, 'Offer'])->name('addedit')
            ->middleware(['permission:offer_add']);

        Route::get('/addItem', [OfferItemController::class, 'createItem'])->name('items.add')->middleware(['permission:offer_edit']);
        Route::post('/storeItem', [OfferItemController::class, 'storeItem'])->name('items.store')->middleware(['permission:offer_edit']);
        Route::get('{item}/editItem', [OfferItemController::class, 'editItem'])->name('items.edit')->middleware(['permission:offer_edit']);
        Route::get('{item}/view_calls', [OfferItemController::class, 'viewCalls'])->name('items.view_calls')
            ->middleware(['permission:captin_edit']);
        Route::post('/updateItem', [OfferItemController::class, 'updateItem'])->name('items.update')->middleware(['permission:offer_edit']);
        Route::delete('{item}/deleteItem', [OfferItemController::class, 'deleteItem'])->name('items.delete')->middleware(['permission:offer_edit']);
        Route::match(['get', 'post'], '{offer?}/offerItem', [OfferItemController::class, 'indexItem'])->name('items.index')
            ->middleware(['permission:offer_edit']);

        Route::match(['GET', 'POST'], '/{offer}/attachments', [OfferAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:offer_edit']);
        Route::prefix('attachments')->name('attachments.')
            ->middleware(['permission:offer_edit'])
            ->group(function () {
                Route::get('/{offer}/create', [OfferAttachmentController::class, 'create'])->name('create');
                Route::post('/{offer}/store', [OfferAttachmentController::class, 'store'])->name('store');
                Route::get('/{offer}/{attachment}/edit', [OfferAttachmentController::class, 'edit'])->name('edit');
                Route::post('/{offer}/{attachment}/update', [OfferAttachmentController::class, 'update'])->name('update');
                Route::delete('/{attachment}/delete', [OfferAttachmentController::class, 'delete'])->name('delete');
            });

        Route::get('{offer}/sms', [OfferController::class, 'viewSMS'])->name('view_sms')
            ->middleware(['permission:offer_edit']);
        Route::get('{offer}/calls', [OfferController::class, 'viewCalls'])->name('view_calls')
            ->middleware(['permission:offer_edit']);

        Route::get('{offer}/items', [OfferController::class, 'viewItems'])->name('view_items')
            ->middleware(['permission:offer_edit']);

        Route::get('{offer}/clients', [OfferController::class, 'viewClients'])->name('view_clients')
            ->middleware(['permission:offer_edit']);
        Route::get('{offer}/tickets', [OfferController::class, 'viewTickets'])->name('view_tickets')
            ->middleware(['permission:offer_edit']);


        Route::get('{offer}/viewattachments', [OfferController::class, 'viewAttachments'])->name('view_attachments')
            ->middleware(['permission:offer_edit']);

        Route::get('{offer}/teams', [OfferController::class, 'viewItems'])->name('view_teams')
            ->middleware(['permission:offer_edit']);

        Route::get('{offer}/printOffer', [OfferController::class, 'printOffer'])->name('printOffer')
            ->middleware(['permission:offer_edit']);
        Route::get('{offer}/sendEmail', [OfferController::class, 'sendEmail'])->name('sendEmail')
            ->middleware(['permission:offer_edit']);
        Route::post('sendEmailTo', [OfferController::class, 'sendEmailTo'])->name('sendEmailTo')
            ->middleware(['permission:offer_edit']);
        Route::post('{' . Offer::ui['s_lcf'] . '}/add_contract', [OfferController::class, 'add_contract'])->name('add_contract')
            ->middleware(['permission:offer_edit']);
    });




    Route::prefix(Contract::ui['route'])
        ->name(Contract::ui['route'] . '.')
        ->group(function () {
            Route::controller(ContractController::class)
                ->group(function () {
                    Route::get('/export', 'export')->name('export')->middleware('permission:' . Contract::ui['s_lcf'] . '_access');
                    Route::match(['get', 'post'], '/', 'index')->name('index')->middleware('permission:' . Contract::ui['s_lcf'] . '_access');
                    Route::get('/create', 'create')->name('create')->middleware('permission:' . Contract::ui['s_lcf'] . '_add');
                    Route::get('/{' . Contract::ui['s_lcf'] . '}/edit', 'edit')->name('edit')->middleware('permission:' . Contract::ui['s_lcf'] . '_edit');
                    Route::delete('{' . Contract::ui['s_lcf'] . '}/delete', 'delete')->name('delete')->middleware('permission:' . Contract::ui['s_lcf'] . '_delete');
                    Route::post('/contract/{Id?}', 'addedit')->name('addedit')->middleware('permission:' . Contract::ui['s_lcf'] . '_add');
                    Route::post('/{' . Contract::ui['s_lcf'] . '}/updateTotalDiscount', 'updateTotalDiscount')->name('updateTotalDiscount')->middleware('permission:' . Contract::ui['s_lcf'] . '_edit');
                });

            Route::prefix('items/{' . Contract::ui['s_lcf'] . '}')
                ->name(ContractItem::ui['route'] . '.')
                ->middleware('permission:' . Contract::ui['s_lcf'] . '_edit')
                ->controller(ContractItemController::class)
                ->group(function () {
                    Route::match(['get', 'post'], '/', 'index')->name('index');
                    Route::get('addItem', 'create')->name('add');
                    Route::get('addEditProject/{' . ContractItem::ui['s_lcf'] . '}', 'addEditProject')->name('addEditProject');
                    Route::post('storeProject/{' . ContractItem::ui['s_lcf'] . '}', 'storeProject')->name('storeProject');
                    Route::post('store', 'store')->name('store');
                    Route::get('edit/{' . ContractItem::ui['s_lcf'] . '}', 'edit')->name('edit');
                    Route::delete('delete/{' . ContractItem::ui['s_lcf'] . '}', 'delete')->name('delete');
                });
        });
    Route::prefix(Project::ui['route'])
        ->name(Project::ui['route'] . '.')
        ->group(function () {
            Route::controller(ProjectController::class)->group(function () {
                Route::get('/export', 'export')->name('export')->middleware('permission:' . Project::ui['s_lcf'] . '_access');
                Route::match(['get', 'post'], '/', 'index')->name('index')->middleware('permission:' . Project::ui['s_lcf'] . '_access');
                Route::get('/create', 'create')->name('create')->middleware('permission:' . Project::ui['s_lcf'] . '_add');
                Route::get('/{' . Project::ui['s_lcf'] . '}/edit', 'edit')->name('edit')->middleware('permission:' . Project::ui['s_lcf'] . '_edit');
                Route::delete('{' . Project::ui['s_lcf'] . '}/delete', 'delete')->name('delete')->middleware('permission:' . Project::ui['s_lcf'] . '_delete');
                Route::post('/contract/{Id?}', 'addedit')->name('addedit')->middleware('permission:' . Project::ui['s_lcf'] . '_add');
                Route::post('/{' . Project::ui['s_lcf'] . '}/updateTotalDiscount', 'updateTotalDiscount')->name('updateTotalDiscount')->middleware('permission:' . Project::ui['s_lcf'] . '_edit');
            });

            Route::prefix(ProjectEmployee::ui['route'] . '/{' . Project::ui['s_lcf'] . '}')
                ->name(ProjectEmployee::ui['route'] . '.')
                ->middleware('permission:' . Project::ui['s_lcf'] . '_edit')
                ->controller(ProjectEmployeeController::class)
                ->group(function () {
                    Route::post('saveSelectedEmployees', 'saveSelectedEmployees')->name('saveSelectedEmployees');
                    Route::get('getSelectedEmployees', 'getSelectedEmployees')->name('getSelectedEmployees');
                    Route::post('workflow', 'saveWorkflow')
                        ->name('saveWorkflow');
                });
            Route::prefix(Task::ui['route'] . '/{' . Project::ui['s_lcf'] . '}')
                ->name(Task::ui['route'] . '.')
                ->middleware('permission:' . Project::ui['s_lcf'] . '_edit')

                ->group(function () {
                    Route::controller(ProjectTaskController::class)->group(function () {
                        Route::match(['get', 'post'], '/', 'index')->name('index');
                        Route::post('assign_tasks', 'assign_tasks')->name('assign_tasks');
                        Route::get('/{' . Task::ui['s_lcf'] . '}/details', 'getDetails')->name('getDetails');
                        Route::get('/{' . Task::ui['s_lcf'] . '}/addEditTaskAssignment/{' . TaskAssignment::ui['s_lcf'] . '}', 'addEditTaskAssignment')->name('addEditTaskAssignment');
                        Route::post('/{' . Task::ui['s_lcf'] . '}/storeTaskAssignment/{' . TaskAssignment::ui['s_lcf'] . '}', 'storeTaskAssignment')->name('storeTaskAssignment');
                        Route::get('/getTaskBoard', 'getTaskBoard')->name('getTaskBoard');


                        Route::get('/{task}/timeline', 'getTaskTimeline')->name('getTaskTimeline');
                        Route::get('/{task}/timeline-filters', 'getTimelineFilters')->name('getTimelineFilters');
                    });
                    Route::controller(ProjectTaskAttachmentController::class)->group(function () {
                        Route::post('attachments', 'upload')->name('upload-attachment');
                        Route::delete('attachments/{attachment}', 'remove')->name('remove-attachment');
                        Route::get('assignments/{taskAssignment}/attachments',  'getAttachments')->name('get-attachments');
                    });
                });
            Route::get('/task_process_comments/{' . TaskProcess::ui['s_lcf'] . '}', [TaskProcessCommentController::class, 'task_process_comments'])->name('task_process_comments');
            Route::post('/store_task_process_comments', [TaskProcessCommentController::class, 'store_task_process_comments'])->name('store_task_process_comments');
        });
    Route::prefix(Task::ui['route'])
        ->name(Task::ui['route'] . '.')
        ->group(function () {
            Route::controller(TaskController::class)->group(function () {
                Route::match(['get', 'post'], '/', 'index')->name('index')->middleware('permission:' . Task::ui['s_lcf'] . '_access');
                Route::post('/move', 'moveTask')->name('move')->middleware('permission:' . Task::ui['s_lcf'] . '_edit');
                Route::get('/{' . TaskAssignment::ui['s_lcf'] . '}/details', 'details')->name('details')->middleware('permission:' . Task::ui['s_lcf'] . '_edit');
                Route::get('/{task}/timeline', 'getTaskTimeline')->name('timeline')->middleware('permission:' . Task::ui['s_lcf'] . '_access');
                Route::get('/get-task-board', 'getTaskBoard')->name('getTaskBoard')->middleware('permission:' . Task::ui['s_lcf'] . '_access');

                Route::post('/comments/{task_assignment}', 'storeComment')->name('storeComment');

                Route::get('/comments/{task_assignment}', 'getComments')->name('getComments');
                Route::post('/comments/attachments', 'uploadAttachments')->name('uploadAttachments');



                // Route::post('/{task_assignment}/comments', 'storeComment')->name('storeComment')->middleware('permission:' . Task::ui['s_lcf'] . '_edit');
                // Route::get('/{task_assignment}/comments', 'getComments')->name('getComments')->middleware('permission:' . Task::ui['s_lcf'] . '_access');
                // Route::post('/{task_assignment}/upload-attachment', 'uploadAttachment')->name('uploadAttachment')->middleware('permission:' . Task::ui['s_lcf'] . '_edit');
            });
        });




    Route::prefix('leads')->name('leads.')
        ->group(function () {
            Route::get('/export', [LeadController::class, 'export'])->name('export')->middleware(['permission:lead_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [LeadController::class, 'index'])->name('index')
                ->middleware(['permission:lead_access']);
            Route::get('/create', [LeadController::class, 'create'])->name('create')->middleware(['permission:lead_add']);
            Route::post('/store', [LeadController::class, 'store'])->name('store')->middleware(['permission:lead_add']);
            Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('edit')->middleware(['permission:lead_edit']);
            Route::post('{lead}/update', [LeadController::class, 'update'])->name('update')->middleware(['permission:lead_edit']);
            Route::delete('{lead}/delete', [LeadController::class, 'delete'])->name('delete')->middleware(['permission:lead_delete']);
            Route::post('/Lead/{Id?}', [LeadController::class, 'Lead'])->name('addedit')
                ->middleware(['permission:lead_add']);


            Route::match(['GET', 'POST'], '/{lead}/attachments', [LeadAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:lead_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:lead_edit'])
                ->group(function () {
                    Route::get('/{lead}/create', [LeadAttachmentController::class, 'create'])->name('create');
                    Route::post('/{lead}/store', [LeadAttachmentController::class, 'store'])->name('store');
                    Route::get('/{lead}/{attachment}/edit', [LeadAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{lead}/{attachment}/update', [LeadAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [LeadAttachmentController::class, 'delete'])->name('delete');
                });

            Route::get('{lead}/sms', [LeadController::class, 'viewSMS'])->name('view_sms')
                ->middleware(['permission:lead_edit']);
            Route::get('{lead}/calls', [LeadController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:lead_edit']);

            Route::get('{lead}/items', [LeadController::class, 'viewItems'])->name('view_items')
                ->middleware(['permission:lead_edit']);

            Route::get('{lead}/clients', [LeadController::class, 'viewClients'])->name('view_clients')
                ->middleware(['permission:lead_edit']);
            Route::get('{lead}/tickets', [LeadController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:lead_edit']);


            Route::get('{lead}/viewattachments', [LeadController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:lead_edit']);

            Route::get('{lead}/teams', [LeadController::class, 'viewItems'])->name('view_teams')
                ->middleware(['permission:lead_edit']);
        });


    Route::prefix('employees')->name('employees.')
        ->group(function () {
            Route::get('employeewhour/checkin', [EmployeeWhourController::class, 'checkIn'])->name('employeewhour.checkin');
            Route::get('employeewhour/checkout', [EmployeeWhourController::class, 'checkOut'])->name('employeewhour.checkout');
            Route::get('employeewhour/getCheckInOut', [EmployeeWhourController::class, 'getCheckInOut'])->name('employeewhour.checkcheckout');

            Route::get('/exportWhour', [EmployeeController::class, 'export'])->name('exportWhour')->middleware(['permission:employee_access']);

            Route::post('/listWhour', [EmployeeController::class, 'listWhour'])->name('listWhour')->middleware(['permission:employee_access']);

            //  Route::post('/listWhour', [EmployeeController::class, 'listWhour'])->name('listWhour')->middleware(['permission:employee_access']);

            Route::get('/export', [EmployeeController::class, 'export'])->name('export')->middleware(['permission:employee_access']);
            Route::match(['get', 'post'], '/', [EmployeeController::class, 'index'])->name('index')
                ->middleware(['permission:employee_access']);
            Route::get('/create', [EmployeeController::class, 'create'])->name('create')->middleware(['permission:employee_add']);
            Route::post('/store', [EmployeeController::class, 'store'])->name('store')->middleware(['permission:employee_add']);
            Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit')->middleware(['permission:employee_edit']);
            Route::post('{employee}/update', [EmployeeController::class, 'update'])->name('update')->middleware(['permission:employee_edit']);
            Route::delete('{employee}/delete', [EmployeeController::class, 'delete'])->name('delete')->middleware(['permission:employee_delete']);
            Route::post('/Employee/{Id?}', [EmployeeController::class, 'Employee'])->name('addedit')
                ->middleware(['permission:employee_add']);

            Route::get('/addWhour', [EmployeeWhourController::class, 'createWhour'])->name('whours.add')->middleware(['permission:employee_edit|myemployee_access']);
            Route::post('/storeWhour', [EmployeeWhourController::class, 'storeWhour'])->name('whours.store')->middleware(['permission:employee_edit|myemployee_access']);
            Route::get('{whour}/editWhour', [EmployeeWhourController::class, 'editWhour'])->name('whours.edit')->middleware(['permission:employee_edit|myemployee_access']);
            Route::post('/updateWhour', [EmployeeWhourController::class, 'updateWhour'])->name('whours.update')->middleware(['permission:employee_edit|myemployee_access']);
            Route::delete('{whour}/deleteWhour', [EmployeeWhourController::class, 'deleteWhour'])->name('whours.delete')->middleware(['permission:employee_edit|myemployee_access']);
            Route::match(['get', 'post'], '{employee?}/employeeWhour', [EmployeeWhourController::class, 'indexWhour'])->name('whours.index')
                ->middleware(['permission:employee_edit']);
            Route::get('/exportWhours/{employee?}', [EmployeeWhourController::class, 'exportWhours'])->name('whours.export')->middleware(['permission:employee_edit']);


            Route::get('/addSwhour', [EmployeeSwhourController::class, 'createSwhour'])->name('swhours.add')->middleware(['permission:employee_edit']);
            Route::post('/storeSwhour', [EmployeeSwhourController::class, 'storeSwhour'])->name('swhours.store')->middleware(['permission:employee_edit']);
            Route::get('{swhour}/editSwhour', [EmployeeSwhourController::class, 'editSwhour'])->name('swhours.edit')->middleware(['permission:employee_edit']);
            Route::post('/updateSwhour', [EmployeeSwhourController::class, 'updateSwhour'])->name('swhours.update')->middleware(['permission:employee_edit']);
            Route::delete('{swhour}/deleteSwhour', [EmployeeSwhourController::class, 'deleteSwhour'])->name('swhours.delete')->middleware(['permission:employee_edit']);
            Route::match(['get', 'post'], '{employee?}/employeeSwhour', [EmployeeSwhourController::class, 'indexSwhour'])->name('swhours.index')
                ->middleware(['permission:employee_edit']);
            Route::get('/exportSwhours/{employee?}', [EmployeeSwhourController::class, 'exportSwhours'])->name('swhours.export')->middleware(['permission:employee_edit']);

            Route::get('/addVacation', [EmployeeVacationController::class, 'createVacation'])->name('vacations.add')->middleware(['permission:employee_edit']);
            Route::post('/storeVacation', [EmployeeVacationController::class, 'storeVacation'])->name('vacations.store')->middleware(['permission:employee_edit']);
            Route::get('{vacation}/editVacation', [EmployeeVacationController::class, 'editVacation'])->name('vacations.edit')->middleware(['permission:employee_edit']);
            Route::post('/updateVacation', [EmployeeVacationController::class, 'updateVacation'])->name('vacations.update')->middleware(['permission:employee_edit']);
            Route::delete('{vacation}/deleteVacation', [EmployeeVacationController::class, 'deleteVacation'])->name('vacations.delete')->middleware(['permission:employee_edit']);
            Route::match(['get', 'post'], '{employee?}/employeeVacation', [EmployeeVacationController::class, 'indexVacation'])->name('vacations.index')
                ->middleware(['permission:employee_edit']);
            Route::get('/exportVacations/{employee?}', [EmployeeVacationController::class, 'exportVacations'])->name('vacations.export')->middleware(['permission:employee_edit']);


            Route::get('/addPayment_Roll', [EmployeePayment_RollController::class, 'createPayment_Roll'])->name('payment_rolls.add')->middleware(['permission:employee_edit']);
            Route::post('/storePayment_Roll', [EmployeePayment_RollController::class, 'storePayment_Roll'])->name('payment_rolls.store')->middleware(['permission:employee_edit']);
            Route::get('{payment_roll}/editPayment_Roll', [EmployeePayment_RollController::class, 'editPayment_Roll'])->name('payment_rolls.edit')->middleware(['permission:employee_edit']);
            Route::post('/updatePayment_Roll', [EmployeePayment_RollController::class, 'updatePayment_Roll'])->name('payment_rolls.update')->middleware(['permission:employee_edit']);
            Route::delete('{payment_roll}/deletePayment_Roll', [EmployeePayment_RollController::class, 'deletePayment_Roll'])->name('payment_rolls.delete')->middleware(['permission:employee_edit']);
            Route::match(['get', 'post'], '{employee?}/employeePayment_Roll', [EmployeePayment_RollController::class, 'indexPayment_Roll'])->name('payment_rolls.index')
                ->middleware(['permission:employee_edit']);
            Route::get('/exportPayment_Rolls/{employee?}', [EmployeePayment_RollController::class, 'exportPayment_Rolls'])->name('payment_rolls.export')->middleware(['permission:employee_edit']);


            Route::get('/addSalary', [EmployeeSalaryController::class, 'createSalary'])->name('salarys.add')->middleware(['permission:employee_edit']);
            Route::post('/storeSalary', [EmployeeSalaryController::class, 'storeSalary'])->name('salarys.store')->middleware(['permission:employee_edit']);
            Route::get('{salary}/editSalary', [EmployeeSalaryController::class, 'editSalary'])->name('salarys.edit')->middleware(['permission:employee_edit']);
            Route::post('/updateSalary', [EmployeeSalaryController::class, 'updateSalary'])->name('salarys.update')->middleware(['permission:employee_edit']);
            Route::delete('{salary}/deleteSalary', [EmployeeSalaryController::class, 'deleteSalary'])->name('salarys.delete')->middleware(['permission:employee_edit']);
            Route::match(['get', 'post'], '{employee?}/employeeSalary', [EmployeeSalaryController::class, 'indexSalary'])->name('salarys.index')
                ->middleware(['permission:employee_edit']);
            Route::get('/exportSalarys/{employee?}', [EmployeeSalaryController::class, 'exportSalarys'])->name('salarys.export')->middleware(['permission:employee_edit']);


            Route::match(['GET', 'POST'], '/{employee}/attachments', [EmployeeAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:employee_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:employee_edit'])
                ->group(function () {
                    Route::get('/{employee}/create', [EmployeeAttachmentController::class, 'create'])->name('create');
                    Route::post('/{employee}/store', [EmployeeAttachmentController::class, 'store'])->name('store');
                    Route::get('/{employee}/{attachment}/edit', [EmployeeAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{employee}/{attachment}/update', [EmployeeAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [EmployeeAttachmentController::class, 'delete'])->name('delete');
                });

            /*  Route::get('/printForm/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@printForm'])->middleware(['permission:employee_access']);
              Route::post('/addWhour', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@addWhour'])->middleware(['permission:employee_access']);
              Route::get('/addWhour/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@createWhour'])->middleware(['permission:employee_access']);
              Route::get('/listWhour/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@getWhour'])->middleware(['permission:employee_access']);
              Route::get('/editWhour/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@editWhour'])->middleware(['permission:employee_access']);
              Route::post('/storeWhour', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@storeWhour'])->middleware(['permission:employee_access']);
              Route::get('/indexSalary', ['as' => 'salary_view', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@indexSalary'])->middleware(['permission:employee_access']);

              Route::post('/addSWhour', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@addSWhour'])->middleware(['permission:employee_access']);
              Route::get('/addSWhour/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@createSWhour'])->middleware(['permission:employee_access']);
              Route::get('/listSWhour/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@getSWhour'])->middleware(['permission:employee_access']);
              Route::get('/editSWhour/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@editSWhour'])->middleware(['permission:employee_access']);
              Route::post('/storeSWhour', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@storeSWhour'])->middleware(['permission:employee_access']);


              Route::post('/addPayment_roll', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@addPayment_roll'])->middleware(['permission:employee_access']);
              Route::get('/addPayment_roll/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@createPayment_roll'])->middleware(['permission:employee_access']);
              Route::get('/listPayment_roll/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@getPayment_roll'])->middleware(['permission:employee_access']);
              Route::get('/editPayment_roll/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@editPayment_roll'])->middleware(['permission:employee_access']);
              Route::post('/storePayment_roll', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@storePayment_roll'])->middleware(['permission:employee_access']);
              Route::post('/addVacation', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@addVacation'])->middleware(['permission:employee_access']);
              Route::get('/addVacation/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@createVacation'])->middleware(['permission:employee_access']);
              Route::get('/cancelVacation/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@cancelVacation'])->middleware(['permission:employee_access']);

              Route::post('/addSalary', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@addSalary'])->middleware(['permission:employee_access']);
              Route::get('/addSalary/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@createSalary'])->middleware(['permission:employee_access']);
              Route::post('/addAllSalary', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@addAllSalary'])->middleware(['permission:employee_access']);
              Route::get('/addAllSalary', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@createAllSalary'])->middleware(['permission:employee_access']);
              Route::get('/listSalary/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@getSalary'])->middleware(['permission:employee_access']);
              Route::get('/listSalary', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@getSalary2'])->middleware(['permission:employee_access']);
              Route::get('/editSalary/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@editSalary'])->middleware(['permission:employee_access']);
              Route::post('/storeSalary', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@storeSalary'])->middleware(['permission:employee_access']);
              Route::get('/approveSalary', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@approveSalary'])->middleware(['permission:employee_access']);
              Route::get('/delete', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\EmployeeController@deleteItem'])->middleware(['permission:employee_access']);*/

            /*
                        Route::get('vacation', ['uses' => 'App\Http\Controllers\Admin\VacationController@index'])->middleware(['permission:employee_access']);
                        Route::get('vacation/view', ['as' => 'vacation_view', 'uses' => 'App\Http\Controllers\Admin\VacationController@index'])->middleware(['permission:employee_access']);
                        Route::get('vacation/list', ['as' => 'vacation_list', 'uses' => 'App\Http\Controllers\Admin\VacationController@get'])->middleware(['permission:employee_access']);
                        Route::get('vacation/myView', ['as' => 'vacation_my_view', 'uses' => 'App\Http\Controllers\Admin\VacationController@indexMy'])->middleware(['permission:employee_access']);
                        Route::get('vacation/myList', ['as' => 'vacation_my_list', 'uses' => 'App\Http\Controllers\Admin\VacationController@getMyVacation'])->middleware(['permission:employee_access']);
                        Route::get('vacation/changeStatus', ['as' => 'change_vacation_status', 'uses' => 'App\Http\Controllers\Admin\VacationController@changeStatus'])->middleware(['permission:employee_access']);
                        Route::get('vacation/edit/{id}', ['as' => 'vacation_user', 'uses' => 'App\Http\Controllers\Admin\VacationController@edit'])->middleware(['permission:employee_access']);
                        Route::post('vacation/update/{id}', ['as' => 'vacation_user', 'uses' => 'App\Http\Controllers\Admin\VacationController@update'])->middleware(['permission:employee_access']);
                        Route::get('vacation/VacationPrint/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@VacationPrint'])->middleware(['permission:employee_access']);
                        Route::get('vacation/process/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@process'])->middleware(['permission:employee_access']);

                        Route::get('vacation/create', ['as' => 'vacation_add', 'uses' => 'App\Http\Controllers\Admin\VacationController@create'])->middleware(['permission:employee_access']);
                        Route::post('vacation/store', ['as' => 'store_vacation', 'uses' => 'App\Http\Controllers\Admin\VacationController@store'])->middleware(['permission:employee_access']);
                        Route::post('vacation/uploadImage/{id}', 'App\Http\Controllers\Admin\VacationController@uploadImage')->middleware(['permission:employee_access']);
                        Route::get('vacation/cstatus/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@cstatus'])->middleware(['permission:employee_access']);
                        Route::get('vacation/addcstatus', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@addcstatus'])->middleware(['permission:employee_access']);
                        Route::post('vacation/storePro', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@storePro'])->middleware(['permission:employee_access']);
                        Route::get('vacation/actionvacation/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@actionvacation'])->middleware(['permission:employee_access']);
                        Route::post('vacation/addactionvacation', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@addactionvacation'])->middleware(['permission:employee_access']);
                        Route::get('vacation/email/{id}', ['as' => '', 'uses' => 'App\Http\Controllers\Admin\VacationController@email'])->middleware(['permission:employee_access']);
                        Route::post('vacation/sendEmail', ['as' => 'send_email', 'uses' => 'App\Http\Controllers\Admin\VacationController@sendEmail'])->middleware(['permission:employee_access']);*/
        });

    Route::prefix('myemployees')->name('myemployees.')
        ->group(function () {
            Route::get('myemployeewhour/checkin', [MyEmployeeWhourController::class, 'checkIn'])->name('employeewhour.checkin');
            Route::get('myemployeewhour/checkout', [MyEmployeeWhourController::class, 'checkOut'])->name('employeewhour.checkout');
            Route::get('myemployeewhour/getCheckInOut', [MyEmployeeWhourController::class, 'getCheckInOut'])->name('employeewhour.checkcheckout');

            Route::get('/exportWhour', [MyEmployeeController::class, 'export'])->name('exportWhour')->middleware(['permission:myemployee_access']);

            Route::post('/listWhour', [MyEmployeeController::class, 'listWhour'])->name('listWhour')->middleware(['permission:myemployee_access']);

            //  Route::post('/listWhour', [EmployeeController::class, 'listWhour'])->name('listWhour')->middleware(['permission:employee_access']);

            Route::get('/export', [MyEmployeeController::class, 'export'])->name('export')->middleware(['permission:myemployee_access']);


            Route::get('/edit', [MyEmployeeController::class, 'edit'])->name('edit')->middleware(['permission:myemployee_edit']);
            Route::post('{employee}/update', [MyEmployeeController::class, 'update'])->name('update')->middleware(['permission:myemployee_edit']);

            Route::post('/Employee/{Id?}', [MyEmployeeController::class, 'Employee'])->name('addedit')
                ->middleware(['permission:myemployee_add']);


            Route::get('{whour}/editWhour', [MyEmployeeWhourController::class, 'editWhour'])->name('whours.edit')->middleware(['permission:myemployee_edit']);
            Route::post('/updateWhour', [MyEmployeeWhourController::class, 'updateWhour'])->name('whours.update')->middleware(['permission:myemployee_edit']);
            // Route::delete('{whour}/deleteWhour', [MyEmployeeWhourController::class, 'deleteWhour'])->name('whours.delete')->middleware(['permission:myemployee_edit']);
            Route::match(['get', 'post'], '{employee?}/employeeWhour', [MyEmployeeWhourController::class, 'indexWhour'])->name('whours.index')
                ->middleware(['permission:myemployee_edit']);
            Route::get('/exportWhours/{employee?}', [MyEmployeeWhourController::class, 'exportWhours'])->name('whours.export')->middleware(['permission:myemployee_edit']);



            Route::match(['GET', 'POST'], '/{employee}/attachments', [MyEmployeeAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:myemployee_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:myemployee_edit'])
                ->group(function () {
                    Route::get('/{employee}/create', [MyEmployeeAttachmentController::class, 'create'])->name('create');
                    Route::post('/{employee}/store', [MyEmployeeAttachmentController::class, 'store'])->name('store');
                    Route::get('/{employee}/{attachment}/edit', [MyEmployeeAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{employee}/{attachment}/update', [MyEmployeeAttachmentController::class, 'update'])->name('update');
                    // Route::delete('/{attachment}/delete', [MyEmployeeAttachmentController::class, 'delete'])->name('delete');
                });
        });
    ///
    Route::prefix('departments')->name('departments.')
        ->group(function () {
            Route::get('/export', [DepartmentController::class, 'export'])->name('export')->middleware(['permission:department_access']);
            Route::match(['get', 'post'], '/', [DepartmentController::class, 'index'])->name('index')->middleware(['permission:department_access']);
            Route::get('/create', [DepartmentController::class, 'create'])->name('create')->middleware(['permission:department_add']);
            Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit')->middleware(['permission:department_edit']);
            Route::delete('{department}/delete', [DepartmentController::class, 'delete'])->name('delete')->middleware(['permission:department_delete']);
            Route::post('/department/{Id?}', [DepartmentController::class, 'addedit'])->name('addedit')
                ->middleware(['permission:department_add']);
        });



    Route::prefix('captins')->name('captins.')
        ->group(function () {
            Route::get('/export', [CaptinController::class, 'export'])->name('export')->middleware(['permission:captin_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [CaptinController::class, 'index'])->name('index')
                ->middleware(['permission:captin_access']);
            Route::get('/getByTelephone/{telephone}', [CaptinController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/create', [CaptinController::class, 'create'])->name('create')->middleware(['permission:captin_add']);
            Route::post('/store', [CaptinController::class, 'store'])->name('store')->middleware(['permission:captin_add']);
            Route::get('/{captin}/edit', [CaptinController::class, 'edit'])->name('edit')->middleware(['permission:captin_edit']);
            Route::post('{captin}/update', [CaptinController::class, 'update'])->name('update')->middleware(['permission:captin_edit']);
            Route::delete('{captin}/delete', [CaptinController::class, 'delete'])->name('delete')->middleware(['permission:captin_delete']);
            Route::post('/Captin/{Id?}', [CaptinController::class, 'Captin'])->name('addedit')
                ->middleware(['permission:captin_add']);
            Route::match(['GET', 'POST'], '/{captin}/attachments', [CaptinAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:captin_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:captin_edit'])
                ->group(function () {
                    Route::get('/{captin}/create', [CaptinAttachmentController::class, 'create'])->name('create');
                    Route::post('/{captin}/store', [CaptinAttachmentController::class, 'store'])->name('store');
                    Route::get('/{captin}/{attachment}/edit', [CaptinAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{captin}/{attachment}/update', [CaptinAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [CaptinAttachmentController::class, 'delete'])->name('delete');
                });
            Route::get('{captin}/captin_calls', [CaptinController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:captin_edit']);
            Route::get('{captin}/viewattachments', [CaptinController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:captin_edit']);
            Route::get('{captin}/visits', [CaptinController::class, 'viewVisits'])->name('view_visits')
                ->middleware(['permission:captin_edit']);
            Route::get('{captin}/tickets', [CaptinController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:captin_edit']);
        });


    Route::prefix('vehicles')->name('vehicles.')
        ->group(function () {
            Route::get('/export', [VehicleController::class, 'export'])->name('export')->middleware(['permission:vehicle_access']);

            Route::match(['get', 'post'], '/', [VehicleController::class, 'index'])->name('index')
                ->middleware(['permission:vehicle_access']);

            Route::get('/create', [VehicleController::class, 'create'])->name('create')->middleware(['permission:vehicle_add']);
            Route::post('/store', [VehicleController::class, 'store'])->name('store')->middleware(['permission:vehicle_add']);
            Route::get('/{vehicle}/edit', [VehicleController::class, 'edit'])->name('edit')->middleware(['permission:vehicle_edit']);
            Route::post('{vehicle}/update', [VehicleController::class, 'update'])->name('update')->middleware(['permission:vehicle_edit']);
            Route::delete('{vehicle}/delete', [VehicleController::class, 'delete'])->name('delete')->middleware(['permission:vehicle_delete']);
            Route::post('/Vehicle/{Id?}', [VehicleController::class, 'Vehicle'])->name('addedit')
                ->middleware(['permission:captin_add']);
            Route::match(['GET', 'POST'], '/{vehicle}/attachments', [VehicleAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:vehicle_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:vehicle_edit'])
                ->group(function () {
                    Route::get('/{vehicle}/create', [VehicleAttachmentController::class, 'create'])->name('create');
                    Route::post('/{vehicle}/store', [VehicleAttachmentController::class, 'store'])->name('store');
                    Route::get('/{vehicle}/{attachment}/edit', [VehicleAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{vehicle}/{attachment}/update', [VehicleAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [VehicleAttachmentController::class, 'delete'])->name('delete');
                });
        });


    Route::prefix('captins')->name('captins.')
        ->group(function () {
            Route::get('/export', [CaptinController::class, 'export'])->name('export')->middleware(['permission:captin_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [CaptinController::class, 'index'])->name('index')
                ->middleware(['permission:captin_access']);
            Route::get('/getByTelephone/{telephone}', [CaptinController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/create', [CaptinController::class, 'create'])->name('create')->middleware(['permission:captin_add']);
            Route::post('/store', [CaptinController::class, 'store'])->name('store')->middleware(['permission:captin_add']);
            Route::get('/{captin}/edit', [CaptinController::class, 'edit'])->name('edit')->middleware(['permission:captin_edit']);
            Route::post('{captin}/update', [CaptinController::class, 'update'])->name('update')->middleware(['permission:captin_edit']);
            Route::delete('{captin}/delete', [CaptinController::class, 'delete'])->name('delete')->middleware(['permission:captin_delete']);
            Route::post('/Captin/{Id?}', [CaptinController::class, 'Captin'])->name('addedit')
                ->middleware(['permission:captin_add']);
            Route::match(['GET', 'POST'], '/{captin}/attachments', [CaptinAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:captin_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:captin_edit'])
                ->group(function () {
                    Route::get('/{captin}/create', [CaptinAttachmentController::class, 'create'])->name('create');
                    Route::post('/{captin}/store', [CaptinAttachmentController::class, 'store'])->name('store');
                    Route::get('/{captin}/{attachment}/edit', [CaptinAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{captin}/{attachment}/update', [CaptinAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [CaptinAttachmentController::class, 'delete'])->name('delete');
                });
            Route::get('{captin}/captin_calls', [CaptinController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:captin_edit']);
            Route::get('{captin}/viewattachments', [CaptinController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:captin_edit']);
            Route::get('{captin}/visits', [CaptinController::class, 'viewVisits'])->name('view_visits')
                ->middleware(['permission:captin_edit']);
            Route::get('{captin}/tickets', [CaptinController::class, 'viewTickets'])->name('view_tickets')
                ->middleware(['permission:captin_edit']);
        });


    Route::prefix('policyOffers')->name('policyOffers.')
        ->group(function () {
            Route::get('/export', [policyOfferController::class, 'export'])->name('export')->middleware(['permission:policyOffer_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [policyOfferController::class, 'index'])->name('index')
                ->middleware(['permission:policyOffer_access']);
            Route::get('/getByTelephone/{telephone}', [policyOfferController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/create', [policyOfferController::class, 'create'])->name('create')->middleware(['permission:policyOffer_add']);
            Route::post('/store', [policyOfferController::class, 'store'])->name('store')->middleware(['permission:policyOffer_add']);
            Route::get('/{policyOffer}/edit', [policyOfferController::class, 'edit'])->name('edit')->middleware(['permission:policyOffer_edit']);
            Route::post('{policyOffer}/update', [policyOfferController::class, 'update'])->name('update')->middleware(['permission:policyOffer_edit']);
            Route::delete('{policyOffer}/delete', [policyOfferController::class, 'delete'])->name('delete')->middleware(['permission:policyOffer_delete']);
            Route::post('/policyOffer/{Id?}', [policyOfferController::class, 'policyOffer'])->name('addedit')
                ->middleware(['permission:policyOffer_add']);
            Route::match(['GET', 'POST'], '/{policyOffer}/attachments', [policyOfferAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:policyOffer_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:policyOffer_edit'])
                ->group(function () {
                    Route::get('/{policyOffer}/create', [policyOfferAttachmentController::class, 'create'])->name('create');
                    Route::post('/{policyOffer}/store', [policyOfferAttachmentController::class, 'store'])->name('store');
                    Route::get('/{policyOffer}/{attachment}/edit', [policyOfferAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{policyOffer}/{attachment}/update', [policyOfferAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [policyOfferAttachmentController::class, 'delete'])->name('delete');
                });
            Route::get('{policyOffer}/policyOffer_calls', [policyOfferController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:policyOffer_edit']);
            Route::get('{policyOffer}/viewattachments', [policyOfferController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:policyOffer_edit']);

            Route::get('/addDriver', [PolicyOfferDriverController::class, 'createDriver'])->name('drivers.add')->middleware(['permission:policyOffer_edit']);
            Route::post('/storeDriver', [PolicyOfferDriverController::class, 'storeDriver'])->name('drivers.store')->middleware(['permission:policyOffer_edit']);
            Route::get('{driver}/editDriver', [PolicyOfferDriverController::class, 'editDriver'])->name('drivers.edit')->middleware(['permission:policyOffer_edit']);
            Route::post('/updateDriver', [PolicyOfferDriverController::class, 'updateDriver'])->name('drivers.update')->middleware(['permission:policyOffer_edit']);
            Route::delete('{driver}/deleteDriver', [PolicyOfferDriverController::class, 'deleteDriver'])->name('drivers.delete')->middleware(['permission:policyOffer_edit']);
            Route::match(['get', 'post'], '{vehicle?}/policyOfferDriver', [PolicyOfferDriverController::class, 'indexDriver'])->name('drivers.index')
                ->middleware(['permission:policyOffer_edit']);
        });

    Route::prefix('clients')->name('clients.')
        ->group(function () {
            Route::get('/export', [ClientController::class, 'export'])->name('export')->middleware(['permission:client_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [ClientController::class, 'index'])->name('index')
                ->middleware(['permission:client_access']);
            Route::get('/getByTelephone/{telephone}', [ClientController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/create', [ClientController::class, 'create'])->name('create')->middleware(['permission:client_add']);
            Route::post('/store', [ClientController::class, 'store'])->name('store')->middleware(['permission:client_add']);
            Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit')->middleware(['permission:client_edit']);
            Route::post('{client}/update', [ClientController::class, 'update'])->name('update')->middleware(['permission:client_edit']);
            Route::delete('{client}/delete', [ClientController::class, 'delete'])->name('delete')->middleware(['permission:client_delete']);
            Route::post('/Client/{Id?}', [ClientController::class, 'Client'])->name('addedit')
                ->middleware(['permission:client_add']);
            Route::match(['GET', 'POST'], '/{client}/attachments', [ClientAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:client_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:client_edit'])
                ->group(function () {
                    Route::get('/{client}/create', [ClientAttachmentController::class, 'create'])->name('create');
                    Route::post('/{client}/store', [ClientAttachmentController::class, 'store'])->name('store');
                    Route::get('/{client}/{attachment}/edit', [ClientAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{client}/{attachment}/update', [ClientAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [ClientAttachmentController::class, 'delete'])->name('delete');
                });
            Route::get('{client}/client_calls', [ClientController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:client_edit']);
            Route::get('{client}/viewattachments', [ClientController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:client_edit']);
        });


    Route::prefix('clientTrillions')->name('clientTrillions.')
        ->group(function () {
            Route::get('/export', [ClientTrillionController::class, 'export'])->name('export')->middleware(['permission:clientTrillion_access']);
            Route::get('/getCitiesForSelectedCountry/{country}', [CountryCityController::class, 'getCountryCities'])->name('getCountryCities');
            Route::match(['get', 'post'], '/', [ClientTrillionController::class, 'index'])->name('index')
                ->middleware(['permission:clientTrillion_access']);
            Route::get('/getByTelephone/{telephone}', [ClientTrillionController::class, 'getByTelephone'])->name('getByTelephone');

            Route::get('/create', [ClientTrillionController::class, 'create'])->name('create')->middleware(['permission:clientTrillion_add']);
            Route::post('/store', [ClientTrillionController::class, 'store'])->name('store')->middleware(['permission:clientTrillion_add']);
            Route::get('/{clientTrillion}/edit', [ClientTrillionController::class, 'edit'])->name('edit')->middleware(['permission:clientTrillion_edit']);
            Route::post('{clientTrillion}/update', [ClientTrillionController::class, 'update'])->name('update')->middleware(['permission:clientTrillion_edit']);
            Route::delete('{clientTrillion}/delete', [ClientTrillionController::class, 'delete'])->name('delete')->middleware(['permission:clientTrillion_delete']);
            Route::post('/ClientTrillion/{Id?}', [ClientTrillionController::class, 'ClientTrillion'])->name('addedit')
                ->middleware(['permission:clientTrillion_add']);
            Route::match(['GET', 'POST'], '/{clientTrillion}/attachments', [ClientTrillionAttachmentController::class, 'index'])->name('attachments')->middleware(['permission:clientTrillion_edit']);
            Route::prefix('attachments')->name('attachments.')
                ->middleware(['permission:clientTrillion_edit'])
                ->group(function () {
                    Route::get('/{clientTrillion}/create', [ClientTrillionAttachmentController::class, 'create'])->name('create');
                    Route::post('/{clientTrillion}/store', [ClientTrillionAttachmentController::class, 'store'])->name('store');
                    Route::get('/{clientTrillion}/{attachment}/edit', [ClientTrillionAttachmentController::class, 'edit'])->name('edit');
                    Route::post('/{clientTrillion}/{attachment}/update', [ClientTrillionAttachmentController::class, 'update'])->name('update');
                    Route::delete('/{attachment}/delete', [ClientTrillionAttachmentController::class, 'delete'])->name('delete');
                });
            Route::get('{clientTrillion}/clientTrillion_calls', [ClientTrillionController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:clientTrillion_edit']);
            Route::get('{clientTrillion}/viewattachments', [ClientTrillionController::class, 'viewAttachments'])->name('view_attachments')
                ->middleware(['permission:clientTrillion_edit']);
            Route::get('{clientTrillion}/teams', [ClientTrillionController::class, 'viewTeams'])->name('view_teams')
                ->middleware(['permission:clientTrillion_edit']);

            Route::get('{clientTrillion}/viewclaims', [ClientTrillionController::class, 'viewclaims'])->name('view_claims')
                ->middleware(['permission:clientTrillion_edit']);


            Route::get('/addTeam', [ClientTrillionTeamController::class, 'createTeam'])->name('teams.add')->middleware(['permission:clientTrillion_edit']);
            Route::post('/storeTeam', [ClientTrillionTeamController::class, 'storeTeam'])->name('teams.store')->middleware(['permission:clientTrillion_edit']);
            Route::get('{team}/editTeam', [ClientTrillionTeamController::class, 'editTeam'])->name('teams.edit')->middleware(['permission:clientTrillion_edit']);
            Route::get('{team}/view_calls', [ClientTrillionTeamController::class, 'viewCalls'])->name('teams.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateTeam', [ClientTrillionTeamController::class, 'updateTeam'])->name('teams.update')->middleware(['permission:clientTrillion_edit']);
            Route::delete('{team}/deleteTeam', [ClientTrillionTeamController::class, 'deleteTeam'])->name('teams.delete')->middleware(['permission:clientTrillion_edit']);
            Route::match(['get', 'post'], '{clientTrillion?}/clientTrillionControllerTeam', [ClientTrillionTeamController::class, 'indexTeam'])->name('teams.index')
                ->middleware(['permission:clientTrillion_edit']);


            Route::get('/addClaim', [ClientTrillionClaimController::class, 'createClaim'])->name('claims.add')->middleware(['permission:clientTrillion_edit']);
            Route::post('/storeClaim', [ClientTrillionClaimController::class, 'storeClaim'])->name('claims.store')->middleware(['permission:clientTrillion_edit']);
            Route::get('{claim}/editClaim', [ClientTrillionClaimController::class, 'editClaim'])->name('claims.edit')->middleware(['permission:clientTrillion_edit']);
            Route::get('{claim}/view_calls', [ClientTrillionClaimController::class, 'viewCalls'])->name('claims.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateClaim', [ClientTrillionClaimController::class, 'updateClaim'])->name('claims.update')->middleware(['permission:clientTrillion_edit']);
            Route::delete('{claim}/deleteClaim', [ClientTrillionClaimController::class, 'deleteClaim'])->name('claims.delete')->middleware(['permission:clientTrillion_edit']);
            Route::match(['get', 'post'], '{clientTrillion?}/clientTrillionControllerClaim', [ClientTrillionClaimController::class, 'indexClaim'])->name('claims.index')
                ->middleware(['permission:clientTrillion_edit']);


            Route::get('{clientTrillion}/socials', [ClientTrillionController::class, 'viewSocials'])->name('view_socials')
                ->middleware(['permission:clientTrillion_edit']);


            Route::get('/addSocial', [ClientTrillionSocialController::class, 'createSocial'])->name('socials.add')->middleware(['permission:clientTrillion_edit']);
            Route::post('/storeSocial', [ClientTrillionSocialController::class, 'storeSocial'])->name('socials.store')->middleware(['permission:clientTrillion_edit']);
            Route::get('{social}/editSocial', [ClientTrillionSocialController::class, 'editSocial'])->name('socials.edit')->middleware(['permission:clientTrillion_edit']);
            Route::get('{social}/view_calls', [ClientTrillionSocialController::class, 'viewCalls'])->name('socials.view_calls')
                ->middleware(['permission:captin_edit']);
            Route::post('/updateSocial', [ClientTrillionSocialController::class, 'updateSocial'])->name('socials.update')->middleware(['permission:clientTrillion_edit']);
            Route::delete('{social}/deleteSocial', [ClientTrillionSocialController::class, 'deleteSocial'])->name('socials.delete')->middleware(['permission:clientTrillion_edit']);
            Route::match(['get', 'post'], '{clientTrillion?}/clientTrillionControllerSocial', [ClientTrillionSocialController::class, 'indexSocial'])->name('socials.index')
                ->middleware(['permission:clientTrillion_edit']);
        });


    Route::prefix('client_calls_actions')->name('client_calls_actions.')
        ->group(function () {
            Route::get('/export', [CallsController::class, 'export'])->name('export')->middleware(['permission:calls_module_access']);
            Route::match(['get', 'post'], '/', [CallsController::class, 'index'])->name('index')
                ->middleware(['permission:calls_module_access']);
            Route::get('/create', [CallsController::class, 'create'])->name('create')->middleware(['permission:calls_module_add']);
            Route::get('/updateCalls', [CdrController::class, 'updateCalls'])->name('updateCalls')->middleware(['permission:calls_module_add']);
            Route::post('/ClientCall/{Id?}', [CallsController::class, 'ClientCall'])->name('ClientCall')->middleware(['permission:calls_module_add']);
            Route::get('/assign/{call}', [CallsController::class, 'Assign'])->name('assign')->middleware(['permission:calls_module_add']);
            Route::post('/storeAssign/{call}', [CallsController::class, 'storeAssign'])->name('storeAssign')->middleware(['permission:calls_module_add']);            // Route::get('/{clientCallAction}/edit', [CallsController::class, 'edit'])->name('edit')->middleware(['permission:calls_module_edit']);
            // Route::post('{clientCallAction}/update', [CallsController::class, 'update'])->name('update')->middleware(['permission:calls_module_edit']);
            Route::delete('{clientCallAction}/delete', [CallsController::class, 'delete'])->name('delete')->middleware(['permission:calls_module_delete']);
            Route::get('{clientCallAction}/view_calls', [CallsController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:calls_module_access']);
        });
    Route::prefix('call_tasks')->name('call_tasks.')
        ->group(function () {
            Route::get('/export', [CallTaskController::class, 'export'])->name('export')->middleware(['permission:callTasks_module_access']);
            Route::match(['get', 'post'], '/', [CallTaskController::class, 'index'])->name('index')
                ->middleware(['permission:callTasks_module_access']);
            Route::get('/create', [CallTaskController::class, 'create'])->name('create')->middleware(['permission:callTasks_module_add']);
            Route::get('/updateCalls', [CdrController::class, 'updateCalls'])->name('updateCalls')->middleware(['permission:callTasks_module_add']);
            Route::post('/ClientCall/{Id?}', [CallTaskController::class, 'ClientCall'])->name('ClientCall')->middleware(['permission:callTasks_module_add']);
            Route::get('/action/{call}', [CallTaskController::class, 'Action'])->name('action')->middleware(['permission:callTasks_module_add']);
            Route::post('/storeAction/{call}', [CallTaskController::class, 'storeAction'])->name('storeAction')->middleware(['permission:callTasks_module_add']);            // Route::get('/{clientCallAction}/edit', [CallTaskController::class, 'edit'])->name('edit')->middleware(['permission:callTasks_module_edit']);
            // Route::post('{clientCallAction}/update', [CallTaskController::class, 'update'])->name('update')->middleware(['permission:callTasks_module_edit']);
            Route::delete('{call}/delete', [CallTaskController::class, 'delete'])->name('delete')->middleware(['permission:callTasks_module_delete']);
        });


    Route::prefix('tickets')->name('tickets.')
        ->group(function () {
            Route::get('/export', [TicketController::class, 'export'])->name('export')->middleware(['permission:ticket_module_access']);
            Route::match(['get', 'post'], '/', [TicketController::class, 'index'])->name('index')
                ->middleware(['permission:ticket_module_access']);
            Route::match(['get', 'post'], '/indexByPhone', [TicketController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:ticket_module_access']);

            //  Route::get('/create', [TicketController::class, 'create'])->name('create')->middleware(['permission:tickets_module_add']);
            Route::get('/create', [TicketController::class, 'create'])->name('create')->middleware(['permission:ticket_module_add']);
            Route::post('/store', [TicketController::class, 'Ticket'])->name('store')->middleware(['permission:ticket_module_add']);
            Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('edit')->middleware(['permission:ticket_module_edit']);
            Route::post('{ticket}/update', [TicketController::class, 'Ticket'])->name('update')->middleware(['permission:ticket_module_edit']);

            Route::post('{ticket}/update', [TicketController::class, 'Ticket'])->name('update')->middleware(['permission:ticket_module_edit']);


            Route::get('{ticket}/createAnswer', [TicketController::class, 'createAnswer'])->name('createAnswer')->middleware(['permission:ticket_module_edit']);
            Route::get('{ticket}/storeAnswer', [TicketController::class, 'storeAnswer'])->name('storeAnswer')->middleware(['permission:ticket_module_edit']);


            Route::delete('{ticket}/delete', [TicketController::class, 'delete'])->name('delete')->middleware(['permission:tickets_module_delete']);

            Route::get('{ticket}/view_calls', [TicketController::class, 'viewCalls'])->name('view_calls')
                ->middleware(['permission:captin_edit']);
        });


    Route::prefix('orders')->name('orders.')
        ->group(function () {
            Route::get('/export', [OrderController::class, 'export'])->name('export')->middleware(['permission:order_module_access']);
            Route::match(['get', 'post'], '/', [OrderController::class, 'index'])->name('index')
                ->middleware(['permission:order_module_access']);
            //  Route::get('/create', [OrderController::class, 'create'])->name('create')->middleware(['permission:orders_module_add']);
            Route::get('/create', [OrderController::class, 'create'])->name('create')->middleware(['permission:order_module_add']);
            Route::get('/create2', [OrderController::class, 'create2'])->name('create2')->middleware(['permission:order_module_add']);
            Route::get('/address', [OrderController::class, 'address'])->name('address')->middleware(['permission:order_module_add']);
            Route::get('/create3', [OrderController::class, 'create3'])->name('create3')->middleware(['permission:order_module_add']);
            Route::post('/store', [OrderController::class, 'Order'])->name('store')->middleware(['permission:order_module_add']);
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit')->middleware(['permission:order_module_edit']);
            Route::post('{order}/update', [OrderController::class, 'Order'])->name('update')->middleware(['permission:order_module_edit']);
            Route::match(['get', 'post'], '/indexByPhone', [OrderController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:order_module_access']);


            Route::delete('{order}/delete', [OrderController::class, 'delete'])->name('delete')->middleware(['permission:order_module_delete']);
        });


    Route::prefix('vacations')->name('vacations.')
        ->group(function () {
            Route::get('/export', [VacationController::class, 'export'])->name('export')->middleware(['permission:vacation_module_access']);
            Route::match(['get', 'post'], '/', [VacationController::class, 'index'])->name('index')
                ->middleware(['permission:vacation_module_access']);
            //  Route::get('/create', [VacationController::class, 'create'])->name('create')->middleware(['permission:vacations_module_add']);
            Route::get('/create', [VacationController::class, 'create'])->name('create')->middleware(['permission:vacation_module_add']);
            Route::get('/address', [VacationController::class, 'address'])->name('address')->middleware(['permission:vacation_module_add']);
            Route::post('/store', [VacationController::class, 'Vacation'])->name('store')->middleware(['permission:vacation_module_add']);
            Route::post('/{vacation}/update', [VacationController::class, 'Vacation'])->name('update')->middleware(['permission:vacation_module_edit']);
            Route::get('/{vacation}/edit', [VacationController::class, 'edit'])->name('edit')->middleware(['permission:vacation_module_edit']);
            Route::match(['get', 'post'], '/indexByPhone', [VacationController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:vacation_module_access']);
            Route::delete('{vacation}/delete', [VacationController::class, 'delete'])->name('delete')->middleware(['permission:vacation_module_delete']);
            Route::get('/approve', [VacationController::class, 'approve'])->name('approve')->middleware(['permission:vacation_module_add']);
        });


    Route::prefix('salarys')->name('salarys.')
        ->group(function () {
            Route::get('/export', [SalaryController::class, 'export'])->name('export')->middleware(['permission:salary_module_access']);
            Route::match(['get', 'post'], '/', [SalaryController::class, 'index'])->name('index')
                ->middleware(['permission:salary_module_access']);
            //  Route::get('/create', [SalaryController::class, 'create'])->name('create')->middleware(['permission:salarys_module_add']);
            Route::get('/create', [SalaryController::class, 'create'])->name('create')->middleware(['permission:salary_module_add']);
            Route::get('/address', [SalaryController::class, 'address'])->name('address')->middleware(['permission:salary_module_add']);
            Route::post('/store', [SalaryController::class, 'Salary'])->name('store')->middleware(['permission:salary_module_add']);
            Route::post('/{salary}/update', [SalaryController::class, 'Salary'])->name('update')->middleware(['permission:salary_module_edit']);
            Route::get('/{salary}/edit', [SalaryController::class, 'edit'])->name('edit')->middleware(['permission:salary_module_edit']);
            Route::match(['get', 'post'], '/indexByPhone', [SalaryController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:salary_module_access']);
            Route::delete('{salary}/delete', [SalaryController::class, 'delete'])->name('delete')->middleware(['permission:salary_module_delete']);
            Route::get('/approve', [SalaryController::class, 'approve'])->name('approve')->middleware(['permission:salary_module_add']);
            Route::get('{salary}/whour_report', [SalaryController::class, 'showWhourReport'])->name('whour_report')
                ->middleware(['permission:salary_module_access|employee_access']);
        });


    Route::prefix('myvacations')->name('myvacations.')
        ->group(function () {
            Route::get('/export', [MyVacationController::class, 'export'])->name('export')->middleware(['permission:myvacation_module_access']);
            Route::match(['get', 'post'], '/', [MyVacationController::class, 'index'])->name('index')
                ->middleware(['permission:myvacation_module_access']);
            //  Route::get('/create', [MyVacationController::class, 'create'])->name('create')->middleware(['permission:myvacations_module_add']);
            Route::get('/create', [MyVacationController::class, 'create'])->name('create')->middleware(['permission:myvacation_module_add']);
            Route::get('/address', [MyVacationController::class, 'address'])->name('address')->middleware(['permission:myvacation_module_add']);
            Route::post('/store', [MyVacationController::class, 'Vacation'])->name('store')->middleware(['permission:myvacation_module_add']);
            Route::post('/{vacation}/update', [MyVacationController::class, 'Vacation'])->name('update')->middleware(['permission:myvacation_module_edit']);
            Route::get('/{vacation}/edit', [MyVacationController::class, 'edit'])->name('edit')->middleware(['permission:myvacation_module_edit']);
            Route::match(['get', 'post'], '/indexByPhone', [MyVacationController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:myvacation_module_access']);
            Route::delete('{vacation}/delete', [MyVacationController::class, 'delete'])->name('delete')->middleware(['permission:myvacation_module_delete']);
            Route::get('/approve', [MyVacationController::class, 'approve'])->name('approve')->middleware(['permission:myvacation_module_add']);
        });


    Route::prefix('visits')->name('visits.')
        ->group(function () {
            Route::get('/export', [VisitController::class, 'export'])->name('export')->middleware(['permission:visit_module_access']);
            Route::match(['get', 'post'], '/', [VisitController::class, 'index'])->name('index')
                ->middleware(['permission:visit_module_access']);
            Route::match(['get', 'post'], '/indexByPhone', [VisitController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:visit_module_access']);
            //  Route::get('/create', [VisitController::class, 'create'])->name('create')->middleware(['permission:visits_module_add']);
            Route::get('/create', [VisitController::class, 'create'])->name('create')->middleware(['permission:visit_module_add']);
            Route::post('/store', [VisitController::class, 'Visit'])->name('store')->middleware(['permission:visit_module_add']);
            Route::get('/{visit}/edit', [VisitController::class, 'edit'])->name('edit')->middleware(['permission:visit_module_edit']);
            Route::post('{visit}/update', [VisitController::class, 'Visit'])->name('update')->middleware(['permission:visit_module_edit']);

            Route::delete('{visit}/delete', [VisitController::class, 'delete'])->name('delete')->middleware(['permission:visit_module_delete']);
        });


    Route::prefix('visitRequests')->name('visitRequests.')
        ->group(function () {
            Route::get('/export', [VisitRequestController::class, 'export'])->name('export')->middleware(['permission:visitRequests_module_access']);
            Route::match(['get', 'post'], '/', [VisitRequestController::class, 'index'])->name('index')
                ->middleware(['permission:visitRequests_module_access']);
            Route::match(['get', 'post'], '/indexByPhone', [VisitRequestController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:visitRequests_module_access']);
            //  Route::get('/create', [VisitRequestController::class, 'create'])->name('create')->middleware(['permission:visitRequests_module_add']);
            Route::get('/create', [VisitRequestController::class, 'create'])->name('create')->middleware(['permission:visitRequest_module_add']);
            Route::post('/store', [VisitRequestController::class, 'VisitRequest'])->name('store')->middleware(['permission:visitRequest_module_add']);
            Route::get('/{visit}/edit', [VisitRequestController::class, 'edit'])->name('edit')->middleware(['permission:visitRequest_module_edit']);
            Route::post('{visit}/update', [VisitRequestController::class, 'VisitRequest'])->name('update')->middleware(['permission:visitRequest_module_edit']);
            Route::get('{visit}/visits', [VisitRequestController::class, 'viewVisits'])->name('view_visits')
                ->middleware(['permission:visitRequests_module_access']);
            Route::delete('{visit}/delete', [VisitRequestController::class, 'delete'])->name('delete')->middleware(['permission:visitRequests_module_delete']);
        });


    Route::prefix('cdr')->name('cdr.')
        ->group(function () {
            Route::match(['get', 'post'], '/', [CdrController::class, 'index'])->name('index')
                ->middleware(['permission:cdr_access']);
            Route::match(['post'], '/indexMobile/{mobile?}', [CdrController::class, 'indexMobile'])->name('indexMobile');


            Route::match(['get', 'post'], '/{telephone}/indexHistory', [CdrController::class, 'indexHistory'])->name('indexHistory')
                ->middleware(['permission:cdr_access']);
        });

    Route::prefix('calls')->name('calls.')
        ->group(function () {
            Route::get('/{captin}/calls', [CaptinCallController::class, 'view_captins_calls'])->name('captin.view_captins_calls')
                ->middleware(['permission:captin_call_access']);
            Route::get('/{captin}/create', [CaptinCallController::class, 'create'])->name('captin.create')
                ->middleware(['permission:captin_call_add']);
            Route::post('/{captin}/store', [CaptinCallController::class, 'store'])->name('captin.store')
                ->middleware(['permission:captin_call_add']);
            Route::get('/{captin}/{call}/edit', [CaptinCallController::class, 'edit'])->name('captin.edit')
                ->middleware(['permission:captin_call_edit']);
            Route::post('/{captin}/{call}/update', [CaptinCallController::class, 'update'])->name('captin.update')
                ->middleware(['permission:captin_call_edit']);


            // Route::get('/{client}/calls', [ClientCallController::class, 'view_clients_calls'])->name('client.view_clients_calls')
            //     ->middleware(['permission:client_call_access']);
            // Route::get('/{client}/create', [ClientCallController::class, 'create'])->name('client.create')
            //     ->middleware(['permission:client_call_add']);
            // Route::post('/{client}/store', [ClientCallController::class, 'store'])->name('client.store')
            //     ->middleware(['permission:client_call_add']);
            // Route::get('/{client}/{call}/edit', [ClientCallController::class, 'edit'])->name('client.edit')
            //     ->middleware(['permission:client_call_edit']);
            // Route::post('/{client}/{call}/update', [ClientCallController::class, 'update'])->name('client.update')
            //     ->middleware(['permission:client_call_edit']);


            // Route::get('/{clientTrillion}/calls', [ClientTrillionCallController::class, 'view_clientTrillions_calls'])->name('clientTrillion.view_clientTrillions_calls')
            //     ->middleware(['permission:clientTrillion_access']);
            // Route::get('/{clientTrillion}/create', [ClientTrillionCallController::class, 'create'])->name('clientTrillion.create')
            //     ->middleware(['permission:clientTrillion_access']);
            // Route::post('/{clientTrillion}/store', [ClientTrillionCallController::class, 'store'])->name('clientTrillion.store')
            //     ->middleware(['permission:clientTrillion_access']);
            // Route::get('/{clientTrillion}/{call}/edit', [ClientTrillionCallController::class, 'edit'])->name('clientTrillion.edit')
            //     ->middleware(['permission:clientTrillion_access']);
            // Route::post('/{clientTrillion}/{call}/update', [ClientTrillionCallController::class, 'update'])->name('clientTrillion.update')
            //     ->middleware(['permission:clientTrillion_access']);


            Route::delete('/{call}/delete', [CaptinCallController::class, 'delete'])->name('captin.delete')
                ->middleware(['permission:captin_call_delete']);

            Route::get('/{call}/questionnaireResponses', [CaptinCallController::class, 'view_call_questionnaire_responses'])->name('captin.view_call_questionnaire_responses')
                ->middleware(['permission:captin_call_access']);


            Route::get('/{callTask}/callCallsTask', [CallTasksCallController::class, 'view_callTasks_calls'])->name('callTask.view_calls')
                ->middleware(['permission:callTasks_module_access']);
            Route::get('/{callTask}/createCallsCallsTask', [CallTasksCallController::class, 'create'])->name('callTask.create')
                ->middleware(['permission:callTasks_module_add']);
            Route::post('/{callTask}/storeCallsCallsTask', [CallTasksCallController::class, 'store'])->name('callTask.store')
                ->middleware(['permission:callTasks_module_add']);
            Route::get('/{callTask}/{call}/editCallsCallsTask', [CallTasksCallController::class, 'edit'])->name('callTask.edit')
                ->middleware(['permission:callTasks_module_edit']);
            Route::post('/{callTask}/{call}/CallsupdateCallsTask', [CallTasksCallController::class, 'update'])->name('callTask.update')
                ->middleware(['permission:callTasks_module_edit']);
            Route::delete('/{callTask}/deleteCallsCallsTask', [CallTasksCallController::class, 'delete'])->name('callTask.delete')
                ->middleware(['permission:callTasks_module_delete']);

            Route::get('/{callTask}/questionnaireResponsesCallsCallsTask', [CallTasksCallController::class, 'view_call_questionnaire_responses'])->name('callTask.view_call_questionnaire_responses')
                ->middleware(['permission:callTasks_module_access']);
            Route::match(['get', 'post'], '/indexByPhone', [CdrController::class, 'indexByPhone'])->name('indexByPhone')
                ->middleware(['permission:calls_module_access']);
        });

    Route::prefix('sms')->name('sms.')
        ->group(function () {
            Route::get('{captin}/sms', [CaptinSMSController::class, 'view_captins_sms'])->name('captin.view_captins_sms')
                ->middleware(['permission:captin_sms_access']);
            Route::get('/{captin}/create', [CaptinSMSController::class, 'create'])->name('captin.create')
                ->middleware(['permission:captin_sms_add']);
            Route::post('/{captin}/store', [CaptinSMSController::class, 'store'])->name('captin.store')
                ->middleware(['permission:captin_sms_add']);


            // Route::get('{client}/sms', [ClientSMSController::class, 'view_clients_sms'])->name('client.view_clients_sms')
            //     ->middleware(['permission:client_sms_access']);
            // Route::get('/{client}/create', [ClientSMSController::class, 'create'])->name('client.create')
            //     ->middleware(['permission:client_sms_add']);
            // Route::post('/{client}/store', [ClientSMSController::class, 'store'])->name('client.store')
            //     ->middleware(['permission:client_sms_add']);


            Route::get('{callTask}/smsCallTask', [CallTaskSMSController::class, 'view_callTasks_sms'])->name('callTask.view_callTasks_sms')
                ->middleware(['permission:callTask_sms_access']);
            Route::get('/{callTask}/createCallTask', [CallTaskSMSController::class, 'create'])->name('callTask.create')
                ->middleware(['permission:callTask_sms_add']);
            Route::post('/{callTask}/storeCallTask', [CallTaskSMSController::class, 'store'])->name('callTask.store')
                ->middleware(['permission:callTask_sms_add']);
        });

    Route::prefix('dashboard')->name('dashboard.')
        ->group(function () {
            Route::get('/employee', [DashboardController::class, 'employee'])->name('employee')->middleware(['permission:employee_access']);
        });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    Route::prefix('getUnreadMessages')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'getUnreadMessages'])->name('getUnreadMessages');
    });
    Route::prefix('getWhatsAppMessage')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'getWhatsAppMessage'])->name('getWhatsAppMessage');
    });
    Route::prefix('sendWhatsappChat')->name('dashboard.')->group(function () {
        Route::post('/', [DashboardController::class, 'sendWhatsappChat'])->name('sendWhatsappChat');
    });
    Route::prefix('createAtt')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'createAtt'])->name('createAtt');
    });
    Route::prefix('storeAtt')->name('dashboard.')->group(function () {
        Route::post('/', [DashboardController::class, 'storeAtt'])->name('storeAtt');
    });

    // Route::prefix('procedures')->name('procedures.')
    //     ->group(function () {
    //     });


});
