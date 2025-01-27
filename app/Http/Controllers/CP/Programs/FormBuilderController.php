<?php

namespace App\Http\Controllers\CP\Programs;

use App\Exports\LeadsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\Program\ProgramRequest;
use App\Models\Attachment;
use App\Models\Constant;
use App\Models\Program;
use App\Models\ProgramPage;
use App\Models\ProgramPageQuestion;
use App\Services\Constants\GetConstantService;
use App\Services\CP\Filters\ProgramFilterService;
use App\Traits\HasCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class FormBuilderController extends Controller
{
    use HasCommonData;

    protected $filterService;
    protected $checkApartmentStatusReadyToSale;
    private $_model;

    public function __construct(Program $_model, ProgramFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }
    public function formBuilder(Program $program)
    {
        $fieldTypes = GetConstantService::get_question_type_list();
        return view('CP.programs.form-builder.index', compact('program', 'fieldTypes'));
    }

    public function getPageContent(Program $program, ProgramPage $page)
    {
        $pageData = $page->load(['questions' => function ($q) {
            $q->ordered();
        }]);

        return response()->json([
            'success' => true,
            'data' => $pageData
        ]);
    }

    public function savePage(Request $request, Program $program, ProgramPage $page = null)
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'title' => 'required|array',
                'title.en' => 'required|string',
                'title.ar' => 'required|string',
                'questions' => 'array'
            ]);

            if ($page) {
                $page->update($data);
            } else {
                $page = $program->pages()->create($data);
            }

            // Handle questions
            if (!empty($data['questions'])) {
                foreach ($data['questions'] as $index => $questionData) {
                    if (isset($questionData['id'])) {
                        $question = ProgramPageQuestion::find($questionData['id']);
                        $question->update([
                            'field_type_id' => $questionData['field_type_id'],
                            'question' => $questionData['question'],
                            'options' => $questionData['options'] ?? [],
                            'required' => $questionData['required'] ?? false,
                            'order' => $index
                        ]);
                    } else {
                        $program->questions()->create([
                            'program_page_id' => $page->id,
                            'field_type_id' => $questionData['field_type_id'],
                            'question' => $questionData['question'],
                            'options' => $questionData['options'] ?? [],
                            'required' => $questionData['required'] ?? false,
                            'order' => $index
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Page saved successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
