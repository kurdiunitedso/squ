<?php

namespace App\Http\Controllers\CP\Programs;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\Program\ProgramPageRequestQuestion;
use App\Models\Program;
use App\Models\ProgramPage;
use App\Models\ProgramPageQuestion;
use App\Services\Constants\GetConstantService;
use App\Services\CP\Filters\ProgramPageQuestionFilterService;
use App\Traits\HasCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProgramPageQuestionController extends Controller
{
    use HasCommonData;

    protected $filterService;
    private $_model;

    public function __construct(ProgramPageQuestion $_model, ProgramPageQuestionFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
    }

    protected function getRequiredDropdowns(): array
    {
        return [
            'index' => [],
            'create' => [],
            'edit' => []
        ];
    }

    public function index(Request $request, Program $program)
    {
        if ($request->isMethod('GET')) {
            $data = $this->getCommonData('index');
            $data['program'] = $program;
            return view($data['_view_path'] . 'index', $data);
        }

        if ($request->isMethod('POST')) {
            $items = $this->_model->query()
                ->where('program_id', $program->id)
                ->orderBy('order', 'asc');

            if ($request->input('params')) {
                $this->filterService->applyFilters($items, $request->input('params'));
            }

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
                // ->editColumn('title', function ($item) {
                //     return '<a href="' . route('programs.program-pages.edit', ['program' => $item->program_id, 'program_page' => $item->id]) . '" class="modal-link">
                //         ' . $item->title . '
                //     </a>';
                // })
                ->addColumn('action', function ($item) {
                    return $item->action_buttons;
                })
                ->escapeColumns([])
                ->make();
        }
    }


    protected function getCommonData($program)
    {
        $data = [
            '_view_path' =>  $this->_model::ui['view'],
            '_model' => $this->_model
        ];
        $data['question_type_list'] = GetConstantService::get_question_type_list();
        $data['program_page_list'] = $program->pages()->get();
        return $data;
    }


    public function create(Request $request, Program $program)
    {
        $data = $this->getCommonData($program);
        $data['program'] = $program;
        $_view_path = $program::ui['view'] . 'tabs.' . $this->_model::ui['view'] . 'modals.addedit';
        $createView = view($_view_path, $data)->render();
        return response()->json(['createView' => $createView]);
    }

    public function edit(Request $request, Program $program, ProgramPageQuestion $_model)
    {
        $data = $this->getCommonData($program);
        $data['program'] = $program;
        $data['_model'] = $_model;
        // dd($programPage, $data);

        $_view_path = $program::ui['view'] . 'tabs.' . $this->_model::ui['view'] . 'modals.addedit';
        $editView = view($_view_path, $data)->render();
        return response()->json(['createView' => $editView]);
    }

    public function addedit(ProgramPageRequestQuestion $request, Program $program)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $id = $request->get('program_page_id');

            // Prepare the data
            $saveData = [
                'question' => $data['question'],
                'type' => $data['type'],
                'score' => $data['score'] ?? 0,
                'order' => $data['order'],
                'required' => $request->boolean('required'),
            ];

            // Add options if present
            if ($request->has('options')) {
                $saveData['options'] = $data['options'];
            }

            if (isset($id)) {
                $item = $this->_model->findOrFail($id);
                $item->update($saveData);
            } else {
                $saveData['program_id'] = $program->id;
                $item = $this->_model->create($saveData);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => isset($id)
                    ? t($this->_model::ui['s_ucf'] . ' has been updated successfully!')
                    : t($this->_model::ui['s_ucf'] . ' has been added successfully!'),
                'id' => $item->id,
                'data' => $item
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in program page add/edit process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'token'])
            ]);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => []
            ], 422);
        }
    }

    public function delete(Request $request, Program $program, ProgramPageQuestion $_model)
    {
        try {
            DB::beginTransaction();
            $_model->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => t($this->_model::ui['s_ucf'] . ' Deleted Successfully!')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting program page', [
                'error' => $e->getMessage(),
                'program_page_id' => $_model->id
            ]);

            return response()->json([
                'status' => false,
                'message' => t('An error occurred while deleting the ' . $this->_model::ui['s_ucf'] . '. Please try again.')
            ], 500);
        }
    }

    public function updateOrder(Request $request, Program $program)
    {
        $request->validate([
            'pages' => 'required|array',
            'pages.*.id' => 'required|exists:program_pages,id',
            'pages.*.order' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->pages as $page) {
                $this->_model->where('id', $page['id'])
                    ->where('program_id', $program->id)
                    ->update(['order' => $page['order']]);
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => t('Order updated successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function formGenerator(Request $request, Program $program, ProgramPageQuestion $_model)
    {
        $data = $this->getCommonData('form-generator');
        $data['program'] = $program;
        $data['_model'] = $_model;

        $formView = view($data['_view_path'] . 'modals.form-generator', $data)->render();
        return response()->json(['createView' => $formView]);
    }
    public function updateStructure(Request $request, Program $program, ProgramPageQuestion $_model)
    {
        try {
            DB::beginTransaction();

            $_model->update([
                'structure' => $request->input('structure')
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => t('Form structure updated successfully')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
