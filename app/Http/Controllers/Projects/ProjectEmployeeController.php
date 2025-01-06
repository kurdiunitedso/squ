<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\ProjectEmployee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProjectEmployeeController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(ProjectEmployee $_model)
    {
        $this->_model = $_model;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }
    public function saveSelectedEmployees(Request $request, Project $project)
    {
        $selectedIds = $request->input('selectedEmployees');

        if (empty($selectedIds)) {
            return response()->json(['message' => 'No employees selected'], 400);
        }

        DB::beginTransaction();

        try {
            // Get existing project employees, including soft-deleted ones
            $existingEmployees = $project->projectEmployees()->withTrashed()->get();

            foreach ($selectedIds as $index => $employeeId) {
                $projectEmployee = $existingEmployees->firstWhere('employee_id', $employeeId);

                if ($projectEmployee) {
                    // Update existing record
                    $projectEmployee->order = $index + 1;
                    $projectEmployee->deleted_at = null; // Restore if it was soft-deleted
                    $projectEmployee->save();
                } else {
                    // Create new record
                    $project->projectEmployees()->create([
                        'employee_id' => $employeeId,
                        'order' => $index + 1
                    ]);
                }
            }

            // Soft-delete employees that are not in the new selection
            $project->projectEmployees()
                ->whereNotIn('employee_id', $selectedIds)
                ->delete();

            DB::commit();
            return response()->json(['message' => 'Employees selected and ordered successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving selected employees: ' . $e->getMessage());
            return response()->json(['message' => 'Error saving selected employees'], 500);
        }
    }
    public function getSelectedEmployees(Project $project)
    {
        $selectedEmployees = $project->projectEmployees()
            ->with('employee:id,name')
            ->orderBy('order')
            ->get()
            ->map(function ($projectEmployee) {
                return [
                    'id' => $projectEmployee->employee->id,
                    'name' => $projectEmployee->employee->name
                ];
            });

        return response()->json(['selectedEmployees' => $selectedEmployees]);
    }

    public function saveWorkflow(Request $request, Project $project)
    {
        $validated = $request->validate([
            'workflow' => 'required|array',
            'workflow.*.employee_id' => 'required|exists:employees,id',
            'workflow.*.position_id' => 'required|exists:constants,id',
            'workflow.*.order' => 'required|integer|min:0'
        ]);

        DB::beginTransaction();

        try {
            // Remove existing workflow assignments
            $project->projectEmployees()->delete();

            // Add new workflow assignments
            foreach ($validated['workflow'] as $assignment) {
                $project->projectEmployees()->updateOrCreate([
                    'employee_id' => $assignment['employee_id'],
                    'position_id' => $assignment['position_id'],
                ], [
                    'order' => $assignment['order']
                ]);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
