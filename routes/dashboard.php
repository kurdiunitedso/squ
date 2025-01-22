<?php

use App\Http\Controllers\CP\Settings\CountryCityController;
use App\Http\Controllers\CP\Attachments\AttachmentController;
use App\Http\Controllers\CP\DashboardController;
use App\Http\Controllers\LanguageSwitcherController;
use App\Http\Controllers\CP\Settings\ConstantsController;
use App\Http\Controllers\CP\Settings\MenuController;
use App\Http\Controllers\CP\UserManagement\PermissionController;
use App\Http\Controllers\CP\UserManagement\RolesController;
use App\Http\Controllers\CP\UserManagement\UsersController;
use App\Models\Attachment;
use App\Models\WebsiteSection;

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\CP\WebsiteManagement\WebsiteSectionController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard'], function () {

    Route::get('/login', [LoginController::class, 'signIn'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');


    Route::post('getSelect', [\App\Http\Controllers\Controller::class, 'getSelect'])->name('getSelect');
    Route::post('getSelect2Details', [DashboardController::class, 'getSelect2Details'])->name('getSelect2Details'); //this is a v2 of getSelect (we should update the getSelect later to be like getSelect2)
    Route::post('getSelect2', [DashboardController::class, 'getSelect2'])->name('getSelect2'); //this is a v2 of getSelect (we should update the getSelect later to be like getSelect2)
    Route::post('getSelect2WithoutSearchOrPaginate', [DashboardController::class, 'getSelect2WithoutSearchOrPaginate'])->name('getSelect2WithoutSearchOrPaginate'); //this is a v2 of getSelect (we should update the getSelect later to be like getSelect2)
    Route::post('/store-objective', [DashboardController::class, 'storeObjective'])->name('store-objective');
    Route::post('/get-objectives', [DashboardController::class, 'getObjectives'])->name('get-objectives');
    Route::delete('attachments/{attachment}', [DashboardController::class, 'remove_attachment'])->name('remove-attachment');




    Route::middleware(['auth'])->group(function () {
        Route::get('/form-generate', function () {
            return view('CP.form-generate');
        }); //->name('login');
        Route::get('/setDashboardLanguage/{language}', [LanguageSwitcherController::class, 'setDashboardLanguage'])->name('setDashboardLanguage');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::impersonate();
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
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


        Route::prefix('settings')->group(function () {
            Route::name('settings.')->group(function () {
                Route::prefix('CountriesCities')->name('country-city.')->middleware(['permission:settings_country_city_access'])->group(function () {
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

                Route::prefix('Menus')->name('menus.')
                    ->middleware(['permission:settings_menu_access'])
                    ->group(function () {
                        Route::match(['GET', 'POST'], '/', [MenuController::class, 'index'])->name('index');
                        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
                        Route::post('{menu}/update', [MenuController::class, 'update'])->name('update');
                    });



                Route::prefix('Constants')->name('constants.')
                    ->middleware(['permission:settings_constants_access'])
                    ->group(function () {
                        Route::match(['GET', 'POST'], '/', [ConstantsController::class, 'index'])->name('index');
                        Route::post('/store', [ConstantsController::class, 'store'])->name('store');
                        Route::get('/{constant}/edit/{module?}', [ConstantsController::class, 'edit'])->name('edit');
                        Route::post('/{constant}/update/{module?}', [ConstantsController::class, 'update'])->name('update');
                    });
            });
        });
        Route::prefix('website-management')->group(function () {
            Route::prefix(WebsiteSection::ui['route'])->name(WebsiteSection::ui['route'] . '.')->controller(WebsiteSectionController::class)->group(function () {
                Route::match(['get', 'post'], '/', 'index')->name('index')->middleware('permission:' . WebsiteSection::ui['s_lcf'] . '_access');
                Route::get('/create', 'create')->name('create')->middleware('permission:' . WebsiteSection::ui['s_lcf'] . '_access');
                Route::get('/{_model}/edit', 'edit')->name('edit')->middleware('permission:' . WebsiteSection::ui['s_lcf'] . '_access');
                Route::delete('{_model}/delete', 'delete')->name('delete')->middleware('permission:' . WebsiteSection::ui['s_lcf'] . '_access');
                Route::post('/' . WebsiteSection::ui['s_lcf'] . '/{Id?}', 'addedit')->name('addedit')->middleware('permission:' . WebsiteSection::ui['s_lcf'] . '_access');
            });
        });



        Route::prefix(Attachment::ui['route'])
            ->name(Attachment::ui['route'] . '.')
            ->controller(AttachmentController::class)
            ->group(function () {
                Route::get('/export', 'export')->name('export')->middleware('permission:' . Attachment::ui['s_lcf'] . '_access');
                Route::match(['get', 'post'], '/', 'index')->name('index')->middleware('permission:' . Attachment::ui['s_lcf'] . '_access');
                Route::get('/create', 'create')->name('create')->middleware('permission:' . Attachment::ui['s_lcf'] . '_add');
                Route::get('/{_model}/edit', 'edit')->name('edit')->middleware('permission:' . Attachment::ui['s_lcf'] . '_edit');
                Route::delete('{_model}/delete', 'delete')->name('delete')->middleware('permission:' . Attachment::ui['s_lcf'] . '_delete');
                Route::post('/' . Attachment::ui['s_lcf'] . '/{Id?}', 'addedit')->name('addedit')->middleware('permission:' . Attachment::ui['s_lcf'] . '_add');
            });
    });
});
