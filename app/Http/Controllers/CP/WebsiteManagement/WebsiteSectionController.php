<?php

namespace App\Http\Controllers\CP\WebsiteManagement;

use App\Exports\ApartmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\AddOnRequest;
use App\Http\Requests\CP\WebsiteSectionRequest;
use App\Models\WebsiteSection;
use App\Services\CP\Filters\WebsiteSectionFilterService;
use App\Traits\HasCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class WebsiteSectionController extends Controller
{
    use HasCommonData;

    protected $filterService;
    private $_model;


    public function __construct(WebsiteSection $_model, WebsiteSectionFilterService $filterService)
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
            'index' => ['website_section_type_list'],
            'create' => ['website_section_type_list'],
            'edit' => ['website_section_type_list'],
            'store' => [],
            'update' => [],
        ];
    }
    public function index(Request $request)
    {
        $data = $this->getCommonData('index');
        if ($request->isMethod('GET')) {
            return view($data['view'] . 'index', $data);
        }
        if ($request->isMethod('POST')) {
            $items = $this->_model->query()->with(['type'])->latest($data['table'] . '.updated_at');

            if ($request->input('params')) {
                $this->filterService->applyFilters($items, $request->input('params'));
            }

            //return $items->get();
            return DataTables::eloquent($items)
                ->editColumn('created_at', function ($item) {
                    if ($item->created_at)
                        return [
                            'display' => e(
                                $item->created_at->format('m/d/Y h:i A')
                            ),
                            'timestamp' => $item->created_at->timestamp
                        ];
                })

                ->addColumn('action', function ($item) {
                    return $item->action_buttons;
                })
                //->rawColumns(['action', 'active', 'has_insurance', 'attachments_count', 'name', 'mobile1', 'intersted_in_work_insurance', 'intersted_in_health_insurance'])
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        // dd($this->_model::ui['view'] . '.addedit');
        $data = $this->getCommonData('create');
        $createView = view(
            $this->_model::ui['view'] . '.addedit',
            $data
        )->render();
        return response()->json(['createView' => $createView]);
    }
    public function edit(Request $request, WebsiteSection $_model)
    {
        $data = $this->getCommonData('edit');
        $data['_model'] = $_model;
        // dd($data);
        $createView = view(
            $this->_model::ui['view'] . '.addedit',
            $data
        )->render();
        return response()->json(['createView' => $createView]);
    }


    public function addedit(WebsiteSectionRequest $request)
    {
        Log::info('=== Starting ' . $this->_model::ui['s_ucf'] . ' Add/Edit Process ===', [
            'request_data' => $request->except(['password', 'token']),
            'user_id' => auth()->id()
        ]);

        try {
            DB::beginTransaction();
            // Get validated data
            $data = $request->validated();
            $data['active'] = $request->has('active');
            $id = $request->get($this->_model::ui['_id']);
            // If updating, store the old file path to delete later
            $oldPath = null;
            if ($id) {
                $item = $this->_model->findOrFail($id);
                $oldPath = $item->image;
                Log::info('Found existing attachment', [
                    'id' => $id,
                    'old_path' => $oldPath,
                ]);
            }            // Handle new file upload
            if ($request->has('attachment_file') && $request->attachment_file != "undefined") {
                Log::info('Processing new file upload');
                $data['image'] = uploadImage($request->file('attachment_file'), 'website_sections');
                Log::info('New file uploaded', [
                    'new_path' => $data['image'],
                ]);
            }



            // Create or update the apartment
            if ($id) {
                $item = $this->_model->findOrFail($id);
                // Delete old file if a new one was uploaded
                if ($oldPath && isset($data['file_path']) && $oldPath !== $data['file_path']) {
                    Log::info('Attempting to delete old file', [
                        'old_path' => $oldPath,
                        'old_name' => $oldName
                    ]);
                    $deleteResult = deleteFile($oldPath, $oldName);
                    Log::info('Delete file result', ['message' => $deleteResult]);
                }
                $item->update($data);
            } else {
                $item = $this->_model->create($data);
            }
            DB::commit();
            $message = $id
                ? t($this->_model::ui['s_ucf'] . ' has been updated successfully!')
                : t($this->_model::ui['s_ucf'] . ' has been added successfully!');
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
            Log::error('Error in ' . $this->_model::ui['s_ucf'] . ' add/edit process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password'])
            ]);

            return $this->handleError($request, $e->getMessage());
        }
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


    public function delete(Request $request, WebsiteSection $_model)
    {
        try {
            DB::beginTransaction();
            $_model->delete();
            DB::commit();
            Log::info($_model::ui['s_ucf'] . ' deleted successfully', [$_model::ui['_id']  => $_model->id]);

            return jsonCRMResponse(true, t($_model::ui['s_ucf'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting ' . $_model::ui['s_ucf'], [
                $_model::ui['_id']  => $_model->id,
                'error' => $e->getMessage()
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
