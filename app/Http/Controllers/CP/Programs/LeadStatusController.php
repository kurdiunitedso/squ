<?php

namespace App\Http\Controllers\CP\Leads;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\Lead\UpdateLeadStatusRequest;
use App\Models\Constant;
use App\Models\Lead;
use App\Traits\HasCommonData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadStatusController extends Controller
{
    use HasCommonData;

    private Lead $_model;

    public function __construct(Lead $_model)
    {
        $this->_model = $_model;
        Log::info('Controller initialized', [
            'controller' => self::class,
            'model' => $_model::ui['s_ucf']
        ]);
    }

    protected function getRequiredDropdowns(): array
    {
        return [
            'get_status_form' => ['lead_status_list'],
        ];
    }

    public function get_status_form(Request $request, Lead $_model): JsonResponse
    {
        Log::info('Starting get_status_form action', [
            'lead_id' => $_model->id,
            'current_status' => [
                'id' => $_model->status_id,
                'name' => $_model->status?->name
            ]
        ]);

        try {
            $data = $this->getCommonData('get_status_form');
            $data['title'] = t('Change Status');
            $data['_model'] = $_model;

            $view = view($data['_view_path'] . '.modals.status_form', $data)->render();

            Log::info('Status form rendered successfully', [
                'lead_id' => $_model->id,
                'view_path' => $data['_view_path'] . '.modals.status_form'
            ]);

            return response()->json(['createView' => $view]);
        } catch (\Exception $e) {
            Log::error('Error in get_status_form', [
                'lead_id' => $_model->id,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile()
            ]);

            return response()->json([
                'error' => t('An error occurred while rendering the status form.')
            ], 500);
        }
    }

    public function update_status(UpdateLeadStatusRequest $request, Lead $_model): JsonResponse
    {
        DB::beginTransaction();

        Log::info('Starting updateStatus action', [
            'lead_id' => $_model->id,
            'requested_status_id' => $request->status_id,
            'current_status' => [
                'id' => $_model->status_id,
                'name' => $_model->status?->name
            ]
        ]);

        try {
            // Step 1: Get current status details
            $oldStatus = $_model->status;
            Log::info('Current status details', [
                'lead_id' => $_model->id,
                'old_status' => [
                    'id' => $oldStatus->id,
                    'name' => $oldStatus->name,
                    'last_updated' => $_model->updated_at
                ]
            ]);

            // Step 2: Get new status details
            $newStatus = Constant::findOrFail($request->status_id);
            Log::info('New status details', [
                'lead_id' => $_model->id,
                'new_status' => [
                    'id' => $newStatus->id,
                    'name' => $newStatus->name
                ]
            ]);

            // Step 3: Update the status
            $updateResult = $_model->update([
                'status_id' => $newStatus->id,
                'status_updated_at' => now(),
            ]);

            Log::info('Status update operation completed', [
                'lead_id' => $_model->id,
                'update_success' => $updateResult,
                'old_status' => [
                    'id' => $oldStatus->id,
                    'name' => $oldStatus->name
                ],
                'new_status' => [
                    'id' => $newStatus->id,
                    'name' => $newStatus->name
                ]
            ]);

            DB::commit();
            Log::info('Transaction committed successfully', [
                'lead_id' => $_model->id,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => true,
                'message' => t('Status has been updated successfully!')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in updateStatus', [
                'lead_id' => $_model->id,
                'requested_status_id' => $request->status_id,
                'current_status_id' => $_model->status_id,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => false,
                'message' => t('An error occurred while updating the status.')
            ], 500);
        }
    }
}
