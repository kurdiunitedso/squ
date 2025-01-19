<?php

namespace App\Http\Controllers\CP\Settings;

use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Services\Constants\ConstantService;
use App\Services\CP\Filters\ConstantFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ConstantsController extends Controller
{
    private $filterService;
    public function __construct(ConstantFilterService $filterService)
    {
        $this->filterService = $filterService;
        Log::info('................... ConstantsController .................');
    }


    public function index(Request $request,)
    {
        if ($request->isMethod('GET')) {
            Log::info('Received a GET request to load the constants index page.');
            return view('settings.constants.index');
        }

        if ($request->isMethod('POST')) {
            Log::info('Received a POST request to fetch constants data for DataTable.');

            // Initialize the query
            $constants = Constant::query()
                ->select(['constants.module', 'constants.field', DB::raw('count(*) as total_values')])
                ->groupBy('constants.module', 'constants.field')
                ->orderBy('module', 'asc');

            Log::info('Initial query setup:', ['query' => $constants->toSql(), 'bindings' => $constants->getBindings()]);

            // Apply search filters using the service
            if ($request->input('params')) {
                $this->filterService->applyFilters($constants, $request->input('params'));
            }

            Log::info('Final query after applying all filters:', ['query' => $constants->toSql(), 'bindings' => $constants->getBindings()]);

            // Use DataTables to process and return the data
            return DataTables::eloquent($constants)
                ->editColumn('name', function ($constant) {
                    return $constant->name;
                })
                ->addColumn('action', function ($constant) {
                    return $constant->action_buttons;
                })
                ->rawColumns(['action'])
                ->make();
        }
    }




    public function edit(Request $request, $constant, $module = 0)
    {
        // $id = $role = null;
        $request->validate([
            'constant' => 'string'
        ]);

        $constants = Constant::where('field', $constant);
        if ($module)
            $constants = $constants->where('module', $module);

        $constants = $constants->get();
        $editView = view('settings.constants.addedit_modal', [
            'constants' => $constants,
        ])->render();

        return response()->json(['editView' => $editView]);
    }
    public function update(Request $request, $constant)
    {
        try {
            DB::beginTransaction();

            Log::info('Starting constants update process', [
                'module' => $request->ModuleName,
                'field' => $request->FieldName
            ]);

            // Update or create constants and collect modified constants
            $modifiedConstants = $this->updateOrCreateConstants(
                $request->kt_constant_repeater,
                $request->ModuleName,
                $request->FieldName
            );

            // Delete constants if any are marked for deletion
            if ($request->deleted_constants) {
                $this->deleteConstants($request->deleted_constants);
            }

            // Clear module and field related caches using ConstantService's methods
            $this->clearRelatedCaches($request->ModuleName, $request->FieldName);

            DB::commit();

            Log::info('Successfully updated constants', [
                'module' => $request->ModuleName,
                'field' => $request->FieldName,
                'modified_count' => count($modifiedConstants),
                'deleted_count' => count($request->deleted_constants ?? [])
            ]);

            return response()->json([
                'status' => true,
                'message' => $request->FieldName . t('Constants Updated')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating constants: ' . $e->getMessage(), [
                'module' => $request->ModuleName,
                'field' => $request->FieldName,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => t('Error updating constants')
            ], 500);
        }
    }

    private function updateOrCreateConstants($constants, $moduleName, $fieldName)
    {
        $modifiedConstants = [];

        foreach ($constants as $value) {
            try {
                $constantData = [
                    'name' => [
                        'ar' => $value['name_ar'],
                        'en' => $value['name_en'],
                    ],
                    'description' => [
                        'ar' => $value['description_ar'],
                        'en' => $value['description_en'],
                    ],
                    'constant_name' => str_replace(' ', '_', trim(strtolower($value["name_en"]))),
                    'parent_id' => $value["parent_id"],
                    'value' => $value["constant_value"],
                    'color' => $value["color"],
                ];

                if ($value["constant_id"] != null) {
                    // Update existing constant
                    $constant = Constant::find($value["constant_id"]);
                    if ($constant) {
                        $constant->update($constantData);
                        ConstantService::clearCache($constant);
                        $modifiedConstants[] = $constant;

                        Log::info('Updated constant', [
                            'id' => $constant->id,
                            'name' => $constant->constant_name
                        ]);
                    }
                } else {
                    // Add additional fields for new constants
                    $constantData['module'] = $moduleName;
                    $constantData['field'] = $fieldName;

                    // Create new constant
                    $constant = Constant::create($constantData);
                    $modifiedConstants[] = $constant;

                    Log::info('Created new constant', [
                        'id' => $constant->id,
                        'name' => $constant->constant_name
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error processing constant:', [
                    'data' => $value,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        }

        return $modifiedConstants;
    }

    private function deleteConstants($deletedConstants)
    {
        if (!$deletedConstants) {
            return;
        }

        foreach ($deletedConstants as $constantId) {
            try {
                $constant = Constant::find($constantId);
                if ($constant) {
                    // Clear cache before deleting
                    ConstantService::clearCache($constant);

                    // Store information for logging
                    $constantInfo = [
                        'id' => $constant->id,
                        'name' => $constant->constant_name,
                        'module' => $constant->module,
                        'field' => $constant->field
                    ];

                    // Delete the constant
                    $constant->delete();

                    Log::info('Deleted constant', $constantInfo);
                }
            } catch (\Exception $e) {
                Log::error('Error deleting constant:', [
                    'constant_id' => $constantId,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        }
    }

    private function clearRelatedCaches($module, $field)
    {
        try {
            // Create a dummy constant to clear caches
            $dummyConstant = new Constant([
                'module' => $module,
                'field' => $field
            ]);

            // Use ConstantService's clearCache method
            ConstantService::clearCache($dummyConstant);

            // Force a refresh of the module and field caches by calling the get methods
            // This will clear old caches and prime new ones
            ConstantService::getByModule($module);
            ConstantService::getByField($field);
            ConstantService::getByModuleAndField($module, $field);

            Log::info('Cleared all related caches', [
                'module' => $module,
                'field' => $field
            ]);
        } catch (\Exception $e) {
            Log::error('Error clearing cache:', [
                'module' => $module,
                'field' => $field,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
