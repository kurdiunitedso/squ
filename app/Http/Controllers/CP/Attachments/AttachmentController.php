<?php

namespace App\Http\Controllers\CP\Attachments;

use App\Exports\ApartmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\ApartmentRequest;
use App\Models\Apartment;
use App\Models\Attachment;
use App\Services\CP\Filters\ApartmentFilterService;
use App\Traits\HasCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class AttachmentController extends Controller
{
    use HasCommonData;

    protected $filterService;
    private $_model;


    public function __construct(Attachment $_model, ApartmentFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }

    /**
     * Override getRequiredDropdowns instead of defining $requiredDropdowns property
     */
    protected function getRequiredDropdowns(): array
    {
        return [
            'index' =>
            [],
            'create' =>
            ['attachment_type_list'],
            'edit' =>
            ['attachment_type_list'],
            'store' =>
            [],
            'update' =>
            [],
        ];
    }

    public function index(Request $request)
    {
        Log::info('Starting index method', ['method' => $request->method()]);

        try {
            $data = $this->getCommonData('index');
            Log::info('Common data retrieved', ['data' => array_keys($data)]);

            if ($request->isMethod('GET')) {
                Log::info('Processing GET request');
                return view($data['view'] . 'index', $data);
            }

            if ($request->isMethod('POST')) {
                Log::info('Processing POST request');

                $model = $request['params']['model'];
                $model_id = $request['params']['model_id'];
                Log::info('Request parameters received', [
                    'model' => $model,
                    'model_id' => $model_id
                ]);

                // Validate model class
                if (!class_exists($model)) {
                    Log::error("Model class validation failed", ['model' => $model]);
                    throw new \Exception("Model class {$model} does not exist");
                }
                Log::info("Model class validated successfully");

                // Validate model ID
                if (!isset($model_id)) {
                    Log::error("Model ID validation failed");
                    throw new \Exception("Model ID does not exist");
                }
                Log::info("Model ID validated successfully");

                // Build query
                Log::info("Building query with relationships");
                $items = $this->_model->query()
                    ->with(['attachment_type']);

                // Apply model filter
                if ($model) {
                    Log::info("Applying model type filter", ['attachable_type' => $model]);
                    $items->where('attachable_type', $model);
                }

                // Apply model ID filter
                if ($model_id) {
                    Log::info("Applying model ID filter", ['attachable_id' => $model_id]);
                    $items->where('attachable_id', $model_id);
                }

                // Apply sorting
                $items->latest($data['table'] . '.updated_at');
                Log::info("Query built successfully");

                // Build DataTables response
                Log::info("Preparing DataTables response");
                $response = DataTables::eloquent($items)
                    ->addColumn('source', function ($attachment) {
                        Log::debug("Processing source column", ['attachment_id' => $attachment->id]);
                        return $attachment->source;
                    })
                    ->addColumn('title', function ($attachment) {
                        Log::debug("Processing title column", ['attachment_id' => $attachment->id]);
                        return '<a target="_blank" href="' . asset($attachment->file_path) . '">' . $attachment->file_name . '</a>';
                    })
                    ->editColumn('created_at', function ($attachment) {
                        Log::debug("Processing created_at column", ['attachment_id' => $attachment->id]);
                        return [
                            'display' => e(
                                $attachment->created_at->format('m/d/Y')
                            ),
                            'timestamp' => $attachment->created_at->timestamp
                        ];
                    })
                    ->addColumn('action', function ($item) use ($model, $model_id) {
                        Log::debug("Processing action column", ['item_id' => $item->id]);
                        return $item->action_buttons;
                    })
                    ->rawColumns(['source', 'title', 'action']);

                Log::info("DataTables response prepared successfully");
                return $response->make();
            }
        } catch (\Exception $e) {
            Log::error('Error in index method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }


    public function create(Request $request)
    {
        $data = $this->getCommonData('create');
        $data['model'] = $request->model;
        $data['model_id'] = $request->model_id;
        $createView = view(
            $this->_model::ui['view'] . '.addedit_modal',
            $data
        )->render();
        return response()->json(['createView' => $createView]);
    }
    public function edit(Request $request, Attachment $_model)
    {
        $data = $this->getCommonData('edit');
        // is not required becuase i just need to update the type and the file
        $data['model'] = $request->model;
        $data['model_id'] = $request->model_id;
        $data['_model'] = $_model;

        $createView = view(
            $this->_model::ui['view'] . '.addedit_modal',
            $data
        )->render();
        return response()->json(['createView' => $createView]);
    }




    private function handleError($request, $message, $errors = [])
    {
        Log::warning('Handling error response', [
            'message' => $message,
            'errors' => $errors
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'errors' => ['name' => [$message]] // Change to specific field error
            ], 422);
        }

        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['name' => $message]) // Attach error to specific field
            ->with('error', null); // Don't set general error message
    }

    public function addedit(Request $request)
    {

        Log::info('Starting attachment add/edit process', [
            'request_id' => $request->get($this->_model::ui['_id']),
            'model' => $request->model,
            'model_id' => $request->model_id
        ]);

        $id = $request->get($this->_model::ui['_id']);

        // Check for duplicates before validation
        $duplicateQuery = $this->_model->where([
            'attachable_type' => $request->model,
            'attachable_id' => $request->model_id,
            'attachment_type_id' => $request->attachment_type_id
        ]);

        // Exclude current record if updating
        if ($id) {
            $duplicateQuery->where('id', '!=', $id);
        }

        $duplicate = $duplicateQuery->first();

        if ($duplicate) {
            Log::warning('Duplicate attachment detected', [
                'attachable_type' => $request->model,
                'attachable_id' => $request->model_id,
                'attachment_type_id' => $request->attachment_type_id,
                'existing_id' => $duplicate->id
            ]);
            return jsonCRMResponse(
                false,
                t('An attachment of this type already exists for this record'),
                422  // Using 422 for validation/business rule violations
            );
        }

        // Continue with regular validation
        $request->validate([
            'attachment_file' => (isset($id) ? 'nullable|' : 'required|') . 'file',
            'attachment_type_id' => 'required|integer|exists:constants,id',
        ]);

        try {
            DB::beginTransaction();
            Log::info('DB transaction started');

            $data = $request->all();
            $data['attachment_type_id'] = $request->attachment_type_id;
            $data['attachable_type'] = $request->model;
            $data['attachable_id'] = $request->model_id;

            // If updating, store the old file path to delete later
            $oldPath = null;
            $oldName = null;
            if ($id) {
                $item = $this->_model->findOrFail($id);
                $oldPath = $item->file_path;
                $oldName = $item->file_name;
                Log::info('Found existing attachment', [
                    'id' => $id,
                    'old_path' => $oldPath,
                    'old_name' => $oldName
                ]);
            }

            // Handle new file upload
            if ($request->has('attachment_file') && $request->attachment_file != "undefined") {
                Log::info('Processing new file upload');
                $path = uploadImage($request->file('attachment_file'), 'attachments');
                $fileName = basename($path);
                $data['file_path'] = $path;
                $data['file_hash'] = $fileName;
                $data['file_name'] = $request->attachment_file->getClientOriginalName();
                Log::info('New file uploaded', [
                    'new_path' => $path,
                    'new_name' => $data['file_name'],
                    'file_hash' => $fileName
                ]);
            }

            // Create or update the attachment
            if ($id) {
                Log::info('Updating existing attachment', ['id' => $id]);
                $item->update($data);

                // Delete old file if a new one was uploaded
                if ($oldPath && isset($data['file_path']) && $oldPath !== $data['file_path']) {
                    Log::info('Attempting to delete old file', [
                        'old_path' => $oldPath,
                        'old_name' => $oldName
                    ]);
                    $deleteResult = deleteFile($oldPath, $oldName);
                    Log::info('Delete file result', ['message' => $deleteResult]);
                }
            } else {
                Log::info('Creating new attachment');
                $item = $this->_model->create($data);
                Log::info('New attachment created', ['id' => $item->id]);
            }

            DB::commit();
            Log::info('DB transaction committed');

            $message = $id
                ? t($this->_model::ui['s_ucf'] . ' has been updated successfully!')
                : t($this->_model::ui['s_ucf'] . ' has been added successfully!');

            Log::info('Attachment operation completed successfully', [
                'operation' => $id ? 'update' : 'create',
                'id' => $item->id
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'id' => $item->id
                ]);
            }

            return redirect()
                ->route($this->_model::ui['route'] . '.edit', ['_model' => $item->id])
                ->with('status', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in attachment add/edit process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password'])
            ]);

            return $this->handleError($request, $e->getMessage());
        }
    }

    public function delete(Request $request, Attachment $_model)
    {
        Log::info('Starting attachment delete process', [
            'attachment_id' => $_model->id,
            'file_name' => $_model->file_name
        ]);

        try {
            DB::beginTransaction();
            Log::info('DB transaction started');

            // Store the file path before deleting the model
            $oldPath = $_model->file_path;
            $oldName = $_model->file_name;

            Log::info('Preparing to delete attachment', [
                'path' => $oldPath,
                'name' => $oldName
            ]);

            // Delete the model
            $_model->delete();
            Log::info('Attachment record deleted from database');

            // Delete the physical file
            if ($oldPath) {
                Log::info('Attempting to delete physical file', [
                    'path' => $oldPath,
                    'name' => $oldName
                ]);
                $deleteResult = deleteFile($oldPath, $oldName);
                Log::info('Delete file result', ['message' => $deleteResult]);
            }

            DB::commit();
            Log::info('DB transaction committed');

            Log::info($_model::ui['s_ucf'] . ' deleted successfully', [
                $_model::ui['_id'] => $_model->id
            ]);

            return jsonCRMResponse(true, t($_model::ui['s_ucf'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting ' . $_model::ui['s_ucf'], [
                $_model::ui['_id'] => $_model->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return jsonCRMResponse(false, 'An error occurred while deleting the ' . $_model::ui['s_ucf'] . '. Please try again.', 500);
        }
    }



    public function export(Request $request)
    {
        $params = $request->all();
        $filterService = $this->filterService;

        return Excel::download(new ApartmentsExport($params, $filterService), $this->_model::ui['p_lcf'] . '.xlsx');
    }
}
