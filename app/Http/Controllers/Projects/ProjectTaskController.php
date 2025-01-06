<?php

namespace App\Http\Controllers\Projects;

use App\Actions\Tasks\TaskDeleteAction;
use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Services\Dashboard\Filters\TaskAssignmentFilterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use Exception;
use Illuminate\Support\Str;

class ProjectTaskController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(TaskAssignment $_model, TaskAssignmentFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ProjectTaskController initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }

    public function index(Request $request, Project $project)
    {
        if ($request->isMethod('GET')) {
            return view(Project::ui['p_lcf'] . '.' . Task::ui['p_lcf'] . '.index', compact('contract'));
        }
    }

    public function assign_tasks(Request $request, Project $project)
    {
        try {
            DB::beginTransaction();
            Log::info("Starting task assignment for Project ID: {$project->id}");

            $tasks = $project->tasks()->with(['taskAssignments.task_processes.comments'])->get();

            $deleteAction = new TaskDeleteAction();
            $deletedCounts = $deleteAction->execute($tasks);


            // Use project start date, or fallback to current date if not set
            $startDate = $project->start_date ? Carbon::parse($project->start_date)->startOfDay() : Carbon::now()->startOfDay();
            $endDate = $startDate->copy()->addDays($project->duration - 1);
            $currentDate = $startDate->copy();

            Log::info("Project start date: {$startDate->format('Y-m-d')}, end date: {$endDate->format('Y-m-d')}");

            $workflow = $project->projectEmployees()->orderBy('order')->get();
            Log::info("Fetched workflow for Project ID: {$project->id}. Employee count: " . $workflow->count());

            if ($workflow->isEmpty()) {
                throw new \Exception(t('No workflow defined for this project.'));
            }

            $totalCycles = floor($project->duration / $project->frequency);
            $totalTasks = $totalCycles * $project->qty;

            Log::info("Project details - Duration: {$project->duration} days, Frequency: {$project->frequency} days, Qty per cycle: {$project->qty}");
            Log::info("Calculated total cycles: {$totalCycles}, Total tasks to create: {$totalTasks}");

            $tasksCreated = 0;
            for ($cycle = 0; $cycle < $totalCycles; $cycle++) {
                $cycleStartDate = $currentDate->copy();
                $cycleEndDate = $cycleStartDate->copy()->addDays($project->frequency - 1);

                Log::info("Starting cycle {$cycle} from {$cycleStartDate->format('Y-m-d')} to {$cycleEndDate->format('Y-m-d')}");

                for ($taskNum = 1; $taskNum <= $project->qty; $taskNum++) {
                    $taskDate = $this->getValidTaskDate($project, $cycleStartDate, $cycleEndDate);

                    $task = $this->createTask($project, $taskDate, $tasksCreated + 1);
                    Log::info("Created Task ID: {$task->id} for date: " . $taskDate->format('Y-m-d'));

                    $this->assignTaskToWorkflow($task, $workflow, $taskDate, $project);

                    $tasksCreated++;
                }

                $currentDate->addDays($project->frequency);
                if ($currentDate > $endDate) {
                    Log::info("Reached project end date. Stopping task creation.");
                    break;
                }
            }

            // Update project status to active
            $project->update(['status_id' => getConstant(Modules::project_module, DropDownFields::status, 'active')->id]);

            DB::commit();
            Log::info("Successfully assigned tasks for Project ID: {$project->id}. Total tasks created: {$tasksCreated}");

            return response()->json([
                'status' => true,
                'message' => t('Tasks assigned successfully'),
                'task_count' => $tasksCreated
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error in assigning tasks for Project ID: {$project->id}. Error: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => t('Error in assigning tasks: ') . $e->getMessage()
            ], 500);
        }
    }

    private function getValidTaskDate(Project $project, Carbon $cycleStart, Carbon $cycleEnd)
    {
        $taskDate = $cycleStart->copy();
        $attempts = 0;
        while ($this->isExceptionDay($project, $taskDate) && $attempts < 5 && $taskDate <= $cycleEnd) {
            $taskDate->addDay();
            $attempts++;
        }
        return $taskDate;
    }
    private function isExceptionDay(Project $project, Carbon $date)
    {
        // Implement your logic to check for exception days
        // For example, check if it's a Sunday or a specific holiday
        return $date->isSunday(); // This is a simple example, adjust as needed
    }

    private function createTask(Project $project, Carbon $date, int $taskNumber)
    {
        $status = getConstant(Modules::task_module, DropDownFields::status, 'not_started');
        return $project->tasks()->create([
            'title' => "Task {$taskNumber} for " . $date->format('Y-m-d'),
            'description' => "Automatically generated task for {$project->name}",
            'start_date' => $date,
            'end_date' => $date->copy()->addDays($project->frequency),
            'status_id' => $status ? $status->id : null,
            'customer_approval_required' => false,
            'customer_approved' => false
        ]);
    }

    private function assignTaskToWorkflow($task, $workflow, $startDate, $project)
    {
        foreach ($workflow as $index => $projectEmployee) {
            $statusValue = 'processing';
            $status = getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, $statusValue);

            if (!$status) {
                Log::error("Status not found for task assignment: $statusValue");
                continue;
            }

            // Determine if this is the first employee in workflow
            $isFirstEmployee = ($index === 0);

            $assignment = TaskAssignment::create([
                'task_id' => $task->id,
                'employee_id' => $projectEmployee->employee_id,
                'position_id' => $projectEmployee->position_id,
                'next_employee_id' => $workflow[$index + 1]->employee_id ?? null,
                'art_manager_id' => $project->art_manager_id,
                'title' => "Assignment for " . $projectEmployee->employee->name,
                'description' => "Part of task: " . $task->title,
                'active' => $isFirstEmployee,
                'start_date' => $isFirstEmployee ? $startDate : null,
                'end_date' => null,
                'status_id' => $status->id,
                'actual_start_date' => $isFirstEmployee ? $startDate : null, // Set actual_start_date for first employee
            ]);

            // Create task process record
            $created_type = getConstant(Modules::task_assignments_module, DropDownFields::task_assignment_process_types, 'created');
            $task_process = $assignment->task_processes()->create([
                'type_id' => $created_type->id,
                'user_id' => auth()->id(),
                'notes' => $created_type->name
            ]);

            // If this is first employee, also create a process record for actual start date
            if ($isFirstEmployee) {
                $start_date_type = getConstant(
                    Modules::task_assignments_module,
                    DropDownFields::task_assignment_process_types,
                    'start_date'
                );

                if ($start_date_type) {
                    $assignment->task_processes()->create([
                        'type_id' => $start_date_type->id,
                        'user_id' => auth()->id(),
                        'new_value' => $startDate->format('Y-m-d'),
                        'notes' => t('Actual start date set during task creation')
                    ]);
                }
            }

            Log::info("Created TaskAssignment ID: {$assignment->id} for Task ID: {$task->id}", [
                'employee_id' => $projectEmployee->employee_id,
                'status' => $status->name,
                'color' => $status->color,
                'is_first_employee' => $isFirstEmployee,
                'actual_start_date' => $isFirstEmployee ? $startDate->format('Y-m-d') : null
            ]);
        }
    }

    public function addEditTaskAssignment(Request $request, Project $project, Task $task, TaskAssignment $task_assignment)
    {
        $data['status_list'] = getConstants(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status);
        $data['project'] = $project;
        $data['task'] = $task;
        $data['item_model'] = $task_assignment;
        $data['task_processes'] = $task_assignment->task_processes()->withCount('comments')->get();
        $createView = view(Project::ui['p_lcf'] . '.' . Task::ui['p_lcf'] . '.task_assignment_addEdit', $data)->render();
        return response()->json(['createView' => $createView]);
    }


    public function storeTaskAssignment(Request $request, Project $project, Task $task, TaskAssignment $task_assignment)
    {
        $logContext = [
            'project_id' => $project->id,
            'task_id' => $task->id,
            'task_assignment_id' => $task_assignment->id,
            'user_id' => auth()->id()
        ];

        Log::info('Starting task assignment update process', $logContext);

        try {
            DB::beginTransaction();
            Log::info('Starting database transaction', $logContext);

            // Get original values before update
            $originalData = $task_assignment->getOriginal();
            Log::info('Retrieved original task assignment data', array_merge($logContext, ['original_data' => $originalData]));

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request[TaskAssignment::ui['s_lcf'] . '_start_date'],
                'actual_start_date' => $request[TaskAssignment::ui['s_lcf'] . '_start_date'],
                'end_date' => $request[TaskAssignment::ui['s_lcf'] . '_end_date'],
                'active' => $request->has('active'),
            ];

            Log::info('Prepared new task assignment data', array_merge($logContext, ['new_data' => $data]));

            // Update task assignment
            Log::info('Attempting to update task assignment', array_merge($logContext, ['update_data' => $data]));
            $task_assignment->update($data);
            Log::info('Task assignment updated successfully', $logContext);

            // Track changes and create process records
            $this->trackTaskAssignmentChanges($task_assignment, $originalData, $data);

            DB::commit();
            Log::info('Database transaction committed successfully', $logContext);

            return response()->json([
                'status' => true,
                'message' => t('Task assignment updated successfully'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error occurred during task assignment update', array_merge($logContext, [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ]));

            return response()->json([
                'status' => false,
                'message' => t('An error occurred while updating the task assignment'),
            ], 500);
        }
    }

    private function trackTaskAssignmentChanges(TaskAssignment $task_assignment, array $originalData, array $newData)
    {
        $logContext = [
            'task_assignment_id' => $task_assignment->id,
            'user_id' => auth()->id()
        ];

        Log::info('Starting to track task assignment changes', $logContext);

        $fieldsToTrack = [
            'title' => 'title',
            'description' => 'description',
            'start_date' => 'start_date',
            'end_date' => 'end_date',
            // 'active' => 'active'
        ];

        foreach ($fieldsToTrack as $field => $processType) {
            $fieldLogContext = array_merge($logContext, [
                'field' => $field,
                'process_type' => $processType,
                'original_value' => $originalData[$field] ?? null,
                'new_value' => $newData[$field] ?? null
            ]);

            Log::info('Checking field for changes', $fieldLogContext);

            // Check if the field has changed
            if (
                isset($newData[$field]) &&
                $this->hasValueChanged($field, $originalData[$field], $newData[$field])
            ) {
                Log::info('Change detected in field', $fieldLogContext);

                try {
                    // Get the process type constant
                    $type = getConstant(
                        Modules::task_assignments_module,
                        DropDownFields::task_assignment_process_types,
                        $processType
                    );

                    Log::info('Retrieved process type constant', array_merge($fieldLogContext, [
                        'type_id' => $type->id,
                        'type_name' => $type->name
                    ]));

                    // Create process record
                    $process = $task_assignment->task_processes()->create([
                        'type_id' => $type->id,
                        // 'employee_id' => auth()->employee->id ?? null,
                        'user_id' => auth()->id(),
                        'old_value' => $originalData[$field],
                        'new_value' => $newData[$field],
                        'notes' => sprintf(
                            t('Changed %s from "%s" to "%s"'),
                            strtolower($type->name),
                            $this->formatValue($originalData[$field]),
                            $this->formatValue($newData[$field])
                        )
                    ]);

                    Log::info('Created task process record', array_merge($fieldLogContext, [
                        'process_id' => $process->id,
                        'formatted_old_value' => $this->formatValue($originalData[$field]),
                        'formatted_new_value' => $this->formatValue($newData[$field])
                    ]));
                } catch (Exception $e) {
                    Log::error('Error creating task process record', array_merge($fieldLogContext, [
                        'error_message' => $e->getMessage(),
                        'error_trace' => $e->getTraceAsString()
                    ]));
                    throw $e;
                }
            } else {
                Log::info('No change detected in field', $fieldLogContext);
            }
        }

        // Handle status change specifically
        if (isset($newData['active']) && $originalData['active'] != $newData['active']) {
            $statusLogContext = array_merge($logContext, [
                'field' => 'active',
                'process_type' => 'active',
                'original_status' => $originalData['active'],
                'new_status' => $newData['active']
            ]);

            Log::info('Status change detected', $statusLogContext);

            try {
                $statusType = getConstant(
                    Modules::task_assignments_module,
                    DropDownFields::task_assignment_process_types,
                    $statusLogContext['process_type']
                    // 'status_change'
                );

                Log::info('Retrieved status change constant', array_merge($statusLogContext, [
                    'type_id' => $statusType->id,
                    'type_name' => $statusType->name
                ]));

                $process = $task_assignment->task_processes()->create([
                    'type_id' => $statusType->id,
                    'user_id' => auth()->id(),
                    'old_value' => $originalData['active'] ? 'Active' : 'Inactive',
                    'new_value' => $newData['active'] ? 'Active' : 'Inactive',
                    'notes' => t('Status changed')
                ]);

                Log::info('Created status change process record', array_merge($statusLogContext, [
                    'process_id' => $process->id
                ]));
            } catch (Exception $e) {
                Log::error('Error creating status change process record', array_merge($statusLogContext, [
                    'error_message' => $e->getMessage(),
                    'error_trace' => $e->getTraceAsString()
                ]));
                throw $e;
            }
        }

        Log::info('Finished tracking task assignment changes', $logContext);
    }

    private function hasValueChanged($field, $oldValue, $newValue): bool
    {
        // If either value is null, compare directly
        if ($oldValue === null || $newValue === null) {
            return $oldValue !== $newValue;
        }

        // For date fields, compare only the dates
        if (in_array($field, ['start_date', 'end_date'])) {
            $oldDate = $oldValue instanceof \DateTime ? $oldValue->format('Y-m-d') : date('Y-m-d', strtotime($oldValue));
            $newDate = $newValue instanceof \DateTime ? $newValue->format('Y-m-d') : date('Y-m-d', strtotime($newValue));

            return $oldDate !== $newDate;
        }

        // For boolean fields
        if ($field === 'active') {
            return (bool)$oldValue !== (bool)$newValue;
        }

        // Default comparison for other fields
        return $oldValue != $newValue;
    }

    private function formatValue($value)
    {
        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d');
        }

        if (is_bool($value)) {
            return $value ? 'Active' : 'Inactive';
        }

        if (empty($value)) {
            return t('Empty');
        }

        // If it's a date string, format it
        if (strtotime($value) !== false) {
            return date('Y-m-d', strtotime($value));
        }

        return $value;
    }

    public function getTaskBoardOld(Request $request, Project $project)
    {
        try {
            // Get base query for task assignments
            $taskAssignmentsQuery = TaskAssignment::with([
                'task' => function ($q) use ($project) {
                    $q->where('project_id', $project->id);
                },
                'status',
                'employee'
            ])->whereHas('task', function ($q) use ($project) {
                $q->where('project_id', $project->id);
            });

            // Apply search filter if provided
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $taskAssignmentsQuery->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%");
                });
            }

            // Apply status filter if provided
            if ($request->has('status_id')) {
                $statusIds = is_array($request->status_id) ? $request->status_id : [$request->status_id];
                $taskAssignmentsQuery->whereIn('status_id', $statusIds);
            }

            // Apply active/inactive filter if provided
            if ($request->has('is_active')) {
                $isActive = $request->is_active === 'YES';
                $taskAssignmentsQuery->where('active', $isActive);
            }

            // Apply work date filter if provided
            if ($request->has('work_date')) {
                $dates = explode(' to ', $request->work_date);
                if (count($dates) === 2) {
                    $taskAssignmentsQuery->where(function ($query) use ($dates) {
                        $query->whereBetween('start_date', $dates)
                            ->orWhereBetween('end_date', $dates);
                    });
                }
            }

            // Get project employees ordered by their defined order
            $projectEmployees = $project->projectEmployees()
                ->with('employee')
                ->orderBy('order')
                ->get();

            // Get task assignments
            $taskAssignments = $taskAssignmentsQuery->get();

            // Group task assignments by employee
            $employeeTaskAssignments = $projectEmployees->map(function ($projectEmployee) use ($taskAssignments) {
                return [
                    'employee' => $projectEmployee->employee,
                    'tasks_assigned' => $taskAssignments->where('employee_id', $projectEmployee->employee_id)->values()
                ];
            });

            $data = [
                'project' => $project,
                'projectEmployees' => $employeeTaskAssignments
            ];

            $createView = view(Project::ui['p_lcf'] . '.' . Task::ui['p_lcf'] . '.task_board', $data)->render();
            return response()->json(['status' => true, 'createView' => $createView]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to load task board: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get task board with filtered results
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaskBoard(Request $request, Project $project)
    {
        try {
            // Get base query for task assignments
            $taskAssignmentsQuery = $this->getBaseTaskAssignmentsQuery($project);

            // Prepare filters from request
            $filters = $this->prepareFilters($request);

            // Apply filters using the filter service
            $taskAssignmentsQuery = $this->filterService->applyTaskBoardFilters($taskAssignmentsQuery, $filters);

            // Log the final query for debugging
            $this->filterService->logQuery($taskAssignmentsQuery);

            // Execute query and get results
            $taskAssignments = $taskAssignmentsQuery->get();

            // Get project employees with their task assignments
            $employeeTaskAssignments = $this->getEmployeeTaskAssignments($project, $taskAssignments);

            // Prepare view data
            $data = [
                'project' => $project,
                'projectEmployees' => $employeeTaskAssignments
            ];

            $createView = view(Project::ui['p_lcf'] . '.' . Task::ui['p_lcf'] . '.task_board', $data)->render();

            return response()->json([
                'status' => true,
                'createView' => $createView
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load task board: ' . $e->getMessage(), [
                'exception' => $e,
                'project_id' => $project->id,
                'filters' => $request->all()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to load task board: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get base query for task assignments
     *
     * @param Project $project
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getBaseTaskAssignmentsQuery(Project $project)
    {
        return TaskAssignment::with([
            'task' => function ($q) use ($project) {
                $q->where('project_id', $project->id);
            },
            'status',
            'employee',
            'position',
        ])->whereHas('task', function ($q) use ($project) {
            $q->where('project_id', $project->id);
        });
    }

    /**
     * Prepare filters from request
     *
     * @param Request $request
     * @return array
     */
    protected function prepareFilters(Request $request)
    {
        return [
            'search' => $request->search,
            'status_id' => $request->status_id,
            'is_active' => $request->is_active,
            'work_date' => $request->work_date
        ];
    }
    /**
     * Get employee task assignments grouped by employee with their project positions
     *
     * @param Project $project
     * @param \Illuminate\Database\Eloquent\Collection $taskAssignments
     * @return \Illuminate\Support\Collection
     */
    protected function getEmployeeTaskAssignments(Project $project, $taskAssignments)
    {
        // Get project employees with relationships and ordering
        $projectEmployees = $project->projectEmployees()
            ->with([
                'employee',
                'position',
                'employee.tasks_assigned' => function ($query) use ($project) {
                    $query->whereHas('task', function ($q) use ($project) {
                        $q->where('project_id', $project->id);
                    });
                }
            ])
            ->orderBy('order')
            ->get();

        return $projectEmployees->map(function ($projectEmployee) use ($taskAssignments) {
            // Filter tasks for this specific employee AND position combination
            $positionTasks = $taskAssignments
                ->where('employee_id', $projectEmployee->employee_id)
                ->where('position_id', $projectEmployee->position_id)
                ->values();

            return [
                'employee' => $projectEmployee->employee,
                'position' => $projectEmployee->position,
                'tasks_assigned' => $positionTasks
            ];
        });
        // ->filter(function ($employeeData) {
        //     // Remove empty task lists
        //     return $employeeData['tasks_assigned']->isNotEmpty();
        // });
    }
    public function getTaskTimeline(Request $request, Project $project, Task $task)
    {
        try {
            // Get task assignments with joins to project_employees for ordering
            $query = TaskAssignment::with([
                'employee',
                'position',
                'status',
                'task.status'
            ])
                ->join('project_employees', function ($join) use ($project) {
                    $join->on('task_assignments.employee_id', '=', 'project_employees.employee_id')
                        ->where('project_employees.project_id', '=', $project->id)
                        ->whereNull('project_employees.deleted_at');
                })
                ->where('task_assignments.task_id', $task->id)
                ->orderBy('project_employees.order')
                ->orderBy('task_assignments.start_date');

            // Apply filters if any
            if ($request->filled('search')) {
                $query->where('task_assignments.title', 'like', "%{$request->search}%");
            }
            if ($request->filled('status_id')) {
                $query->where('task_assignments.status_id', $request->status_id);
            }
            if ($request->filled('employee_id')) {
                $query->where('task_assignments.employee_id', $request->employee_id);
            }

            // Select specific columns to avoid ambiguous column names
            $query->select('task_assignments.*');

            $assignments = $query->get();

            if ($assignments->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'timelineHtml' => '<div class="alert alert-info">No assignments found for this task.</div>',
                    'stats' => $this->getEmptyStats()
                ]);
            }

            // Calculate date range
            $minDate = Carbon::parse($assignments->min('start_date'))->startOfDay();
            $maxDate = Carbon::parse($assignments->max('end_date'))->endOfDay();

            // Add padding days
            $startDate = $minDate->copy()->subDays(1);
            $endDate = $maxDate->copy()->addDays(1);

            // Create date range collection
            $dateRange = collect();
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                $dateRange->push($currentDate->copy());
                $currentDate->addDay();
            }

            $totalDays = $dateRange->count();

            // Calculate positions for each assignment
            foreach ($assignments as $assignment) {
                $assignmentStart = Carbon::parse($assignment->start_date)->startOfDay();
                $assignmentEnd = Carbon::parse($assignment->end_date)->endOfDay();

                // Calculate days from start of timeline
                $startDayIndex = $startDate->diffInDays($assignmentStart);
                $duration = $assignmentStart->diffInDays($assignmentEnd) + 1;

                // Calculate percentage positions
                $assignment->position_left = ($startDayIndex / $totalDays) * 100;
                $assignment->width = ($duration / $totalDays) * 100;

                \Log::info('Assignment position calculated', [
                    'assignment_id' => $assignment->id,
                    'title' => $assignment->title,
                    'start_date' => $assignmentStart->format('Y-m-d'),
                    'end_date' => $assignmentEnd->format('Y-m-d'),
                    'start_day_index' => $startDayIndex,
                    'duration' => $duration,
                    'total_days' => $totalDays,
                    'position_left' => $assignment->position_left,
                    'width' => $assignment->width
                ]);
            }

            // Calculate stats
            $stats = [
                'total_assignments' => $assignments->count(),
                'completed_assignments' => $assignments->where('status.constant_name', 'completed')->count(),
                'processing_assignments' => $assignments->where('status.constant_name', 'processing')->count(),
                'art_manager_approval_assignments' => $assignments->where('status.constant_name', 'art_manager_approval')->count(),
                'customer_approval_assignments' => $assignments->where('status.constant_name', 'customer_approval')->count(),
            ];

            // Render timeline
            $timelineHtml = view('projects.tasks.partials.timeline_content', [
                'task' => $task,
                'assignments' => $assignments,
                'dateRange' => $dateRange,
                'stats' => (object)$stats
            ])->render();

            return response()->json([
                'status' => true,
                'timelineHtml' => $timelineHtml,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            \Log::error('Timeline generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to load timeline: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getEmptyStats()
    {
        return [
            'total_assignments' => 0,
            'completed_assignments' => 0,
            'processing_assignments' => 0,
            'art_manager_approval_assignments' => 0,
            'customer_approval_assignments' => 0,
        ];
    }
}
