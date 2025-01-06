<?php

namespace App\Http\Controllers\Tasks;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskAssignmentComment;
use App\Services\Dashboard\Filters\TaskFilterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(Task $_model, TaskFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }



    public function index(Request $request)
    {
        $data = [
            'projects' => Project::with(['contract_item.contract.client_trillion', 'contract_item.item'])->get(),
            'employees' => Employee::get(),
            // 'status_list' => Employee::get(),
        ];
        $user = auth()->user();
        $employee = $user->employee;
        $data['status_list'] =
            Constant::where([
                'module' => Modules::task_assignments_module,
                'field' => DropDownFields::employee_task_assignment_status,
            ])
            ->when(isset($user) && $user->hasRole('Trillionz Employees'), function ($query) use ($user) {
                $query->where('constant_name', '<>', 'customer_approval');
            })->get();
        // Get all tasks and group them by status_id
        $data['tasks_assigned'] = TaskAssignment::with(['status'])
            ->when($user->hasRole('Trillionz Employees'), function ($q) use ($employee, $user) {
                $q->where(['employee_id' => $employee->id]);
            })
            ->when($user->hasRole('Art Manager'), function ($q) use ($employee, $user) {
                $q->where(['art_manager_id' => $employee->id]);
            })
            ->get()
            ->groupBy('status_id');

        Log::info('Tasks grouped by status', [
            'status_count' => $data['status_list']->count(),
            'tasks_by_status' => $data['tasks_assigned']->map->count()
        ]);
        return view($this->_model::ui['p_lcf'] . '.index', $data);
    }

    public function getTaskBoard(Request $request)
    {
        try {
            $user = auth()->user();
            $employee = $user->employee;

            // Get status list
            $status_list = Constant::where([
                'module' => Modules::task_assignments_module,
                'field' => DropDownFields::employee_task_assignment_status,
            ])
                ->when($user->hasRole('Trillionz Employees'), function ($query) {
                    $query->where('constant_name', '<>', 'customer_approval');
                })->get();

            // Base query with eager loading
            $query = TaskAssignment::with([
                'status',
                'task.project.contract.client_trillion',
                'task.project.item'
            ])
                ->when($user->hasRole('Trillionz Employees'), function ($q) use ($employee) {
                    $q->where('employee_id', $employee->id);
                })
                ->when($user->hasRole('Art Manager'), function ($q) use ($employee) {
                    $q->where('art_manager_id', $employee->id);
                });

            // Apply filters using the service
            $tasks_assigned = $this->filterService->apply($query)
                ->latest('updated_at')
                ->get()
                ->groupBy('status_id');

            // Render the board view
            $view = view(
                $this->_model::ui['p_lcf'] . '.partials._board',
                compact('status_list', 'tasks_assigned')
            )->render();

            return response()->json([
                'success' => true,
                'data' => compact('status_list', 'tasks_assigned'),
                'html' => $view
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getTaskBoard:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load task board'
            ], 500);
        }
    }


    protected function logAction($message, $context = [], $level = 'info')
    {
        $baseContext = [
            'user_id' => auth()->id(),
            'employee_id' => auth()->user()->employee->id ?? null,
            'timestamp' => now()->toIso8601String()
        ];

        Log::$level("TaskController: {$message}", array_merge($baseContext, $context));
    }

    protected function getAuthenticatedEmployeeId()
    {
        $user = auth()->user();
        $employeeId = $user->employee->id ?? null;

        $this->logAction('Retrieved authenticated employee ID', [
            'user_id' => $user->id,
            'employee_id' => $employeeId
        ]);

        return $employeeId;
    }

    protected function validateArtManagerAccess($assignment)
    {
        $user = auth()->user();
        $userEmployeeId = $this->getAuthenticatedEmployeeId();

        $this->logAction('Validating art manager access', [
            'assignment_art_manager_id' => $assignment->art_manager_id,
            'user_employee_id' => $userEmployeeId,
            'is_art_manager' => $user->hasRole('Art Manager')
        ]);

        if (!$user->hasRole('Art Manager')) {
            throw new \Exception('Only art managers can perform this action');
        }

        if ($assignment->art_manager_id !== $userEmployeeId) {
            $this->logAction('Art manager access denied', [
                'required_art_manager_id' => $assignment->art_manager_id,
                'current_employee_id' => $userEmployeeId
            ], 'warning');

            throw new \Exception('Only the assigned art manager can modify this task');
        }

        return true;
    }

    protected function validateTaskMovement($assignment, $newStatusId, $oldStatusId)
    {
        $user = auth()->user();
        $userEmployeeId = $this->getAuthenticatedEmployeeId();

        $this->logAction('Starting task movement validation', [
            'task_id' => $assignment->id,
            'new_status' => $newStatusId,
            'old_status' => $oldStatusId,
            'user_role' => [
                'is_admin' => $user->hasRole('Admin'),
                'is_art_manager' => $user->hasRole('Art Manager'),
                'is_employee' => $user->hasRole('Trillionz Employees')
            ]
        ]);

        // If user is admin or art manager, allow all movements
        if ($user->hasRole(['Admin', 'Art Manager'])) {
            $this->logAction('User is admin or art manager, allowing all movements');
            return true;
        }

        // Get status constants
        $processingStatus = getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'processing');
        $artManagerApprovalStatus = getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'art_manager_approval');
        $customerApprovalStatus = getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'customer_approval');
        $completedStatus = getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'completed');

        // If user is Trillionz Employee, only allow specific movements
        if ($user->hasRole('Trillionz Employees')) {
            $allowedTransitions = [
                // From Processing to Art Manager Approval
                [$processingStatus->id => [$artManagerApprovalStatus->id]],
                // From Art Manager Approval back to Processing
                [$artManagerApprovalStatus->id => [$processingStatus->id]]
            ];

            $isAllowed = false;
            foreach ($allowedTransitions as $transition) {
                if (isset($transition[$oldStatusId]) && in_array($newStatusId, $transition[$oldStatusId])) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                $this->logAction('Invalid movement for Trillionz Employee', [
                    'from_status' => $oldStatusId,
                    'to_status' => $newStatusId
                ], 'warning');

                throw new \Exception('As an employee, you can only move tasks between Processing and Art Manager Approval states');
            }

            // Verify the task is assigned to this employee
            if ($assignment->employee_id !== $userEmployeeId) {
                $this->logAction('Employee attempted to move task not assigned to them', [
                    'task_employee_id' => $assignment->employee_id,
                    'user_employee_id' => $userEmployeeId
                ], 'warning');

                throw new \Exception('You can only move tasks assigned to you');
            }
        }

        $this->logAction('Task movement validation successful', [
            'from_status' => $oldStatusId,
            'to_status' => $newStatusId
        ]);

        return true;
    }

    public function moveTask(Request $request)
    {
        $this->logAction('Starting task movement request', [
            'request_data' => $request->all()
        ]);

        try {
            DB::beginTransaction();

            $assignment = TaskAssignment::with([
                'task.project.projectEmployees',
                'status',
                'employee'
            ])->findOrFail($request->task_id);

            // Validate the movement
            $this->validateTaskMovement(
                $assignment,
                $request->new_status_id,
                $request->old_status_id
            );

            $oldStatusName = $assignment->status->name;

            // Get status constants
            $processingStatus = getConstant(
                Modules::task_assignments_module,
                DropDownFields::employee_task_assignment_status,
                'processing'
            );

            $completedStatus = getConstant(
                Modules::task_assignments_module,
                DropDownFields::employee_task_assignment_status,
                'completed'
            );

            // If starting processing for the first time
            if ($request->new_status_id == $processingStatus->id && !$assignment->actual_start_date) {
                $assignment->actual_start_date = now();
                $assignment->active = true;
            }

            // If completing the task
            if ($request->new_status_id == $completedStatus->id) {
                // Set completion details
                $assignment->actual_end_date = now();
                if ($assignment->actual_start_date) {
                    $start = Carbon::parse($assignment->actual_start_date);
                    $end = Carbon::parse($assignment->actual_end_date);
                    $assignment->actual_days = $start->diffInDays($end) + 1;
                }
                $assignment->active = false;

                // Handle workflow progression
                $this->progressWorkflow($assignment);
            }

            // Update task status
            $assignment->status_id = $request->new_status_id;
            $assignment->save();
            $assignment->load('status');

            // Record the status change process
            $this->recordTaskProcess(
                $assignment,
                $oldStatusName,
                $assignment->status->name
            );

            DB::commit();

            $this->logAction('Task movement completed successfully', [
                'final_status' => $assignment->status->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task moved successfully',
                'task' => $assignment->load([
                    'task.project',
                    'status',
                    'task_processes' => fn($q) => $q->latest()
                ])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logAction('Task movement failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 'error');

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    protected function progressWorkflow(TaskAssignment $completedAssignment)
    {
        $task = $completedAssignment->task;
        $project = $task->project;

        // Get ordered workflow
        $workflow = $project->projectEmployees()
            ->orderBy('order')
            ->get();

        // Find current position in workflow
        $currentPosition = $workflow->search(function ($item) use ($completedAssignment) {
            return $item->employee_id === $completedAssignment->employee_id;
        });

        if ($currentPosition === false || !isset($workflow[$currentPosition + 1])) {
            return; // No next person in workflow
        }

        // Get next employee in workflow
        $nextEmployee = $workflow[$currentPosition + 1];

        // Find their task assignment
        $nextAssignment = TaskAssignment::where([
            'task_id' => $task->id,
            'employee_id' => $nextEmployee->employee_id,
        ])->first();

        if (!$nextAssignment) {
            Log::error('Next task assignment not found', [
                'task_id' => $task->id,
                'next_employee_id' => $nextEmployee->employee_id
            ]);
            return;
        }

        // Get processing status
        $processingStatus = getConstant(
            Modules::task_assignments_module,
            DropDownFields::employee_task_assignment_status,
            'processing'
        );

        // Update next assignment
        $nextAssignment->update([
            'active' => true,
            'status_id' => $processingStatus->id,
            'actual_start_date' => now(), // Start from current completion time
            'start_date' => now() // Update planned start date too
        ]);

        // Record activation process
        $activationType = getConstant(
            Modules::task_assignments_module,
            DropDownFields::task_assignment_process_types,
            'active'
        );

        $nextAssignment->task_processes()->create([
            'type_id' => $activationType->id,
            'user_id' => auth()->id(),
            'notes' => 'Task activated as next in workflow',
            'old_value' => 'Inactive',
            'new_value' => 'Active'
        ]);

        $this->logAction('Progressed workflow to next assignment', [
            'completed_assignment_id' => $completedAssignment->id,
            'next_assignment_id' => $nextAssignment->id,
            'next_employee_id' => $nextEmployee->employee_id
        ]);
    }
    // protected function recordTaskProcess($assignment, $oldStatus, $newStatus)
    // {
    //     $this->logAction('Recording task process', [
    //         'task_id' => $assignment->id,
    //         'old_status' => $oldStatus,
    //         'new_status' => $newStatus
    //     ]);

    //     $statusChangeType = getConstant(
    //         Modules::task_assignments_module,
    //         DropDownFields::task_assignment_process_types,
    //         'status_change'
    //     );

    //     return $assignment->task_processes()->create([
    //         'type_id' => $statusChangeType->id,
    //         'user_id' => auth()->id(),
    //         'old_value' => $oldStatus,
    //         'new_value' => $newStatus,
    //         'notes' => $statusChangeType->name
    //     ]);
    // }

    protected function recordTaskProcess($assignment, $oldStatus, $newStatus)
    {
        $statusChangeType = getConstant(
            Modules::task_assignments_module,
            DropDownFields::task_assignment_process_types,
            'status_change'
        );

        return $assignment->task_processes()->create([
            'type_id' => $statusChangeType->id,
            'user_id' => auth()->id(),
            'old_value' => $oldStatus,
            'new_value' => $newStatus,
            'notes' => "Status changed from {$oldStatus} to {$newStatus}"
        ]);
    }
    public function details(Request $request, TaskAssignment $task_assignment)
    {
        $task_assignment->load(['task.project.art_manager', 'attachments']);

        $data['item_model'] = $task_assignment;
        $data['task'] = $task_assignment->task;
        $data['project'] = $task_assignment->task->project;
        $data['task_processes'] = $task_assignment->task_processes()->withCount('comments')->get();
        $createView = view($this->_model::ui['p_lcf'] . '.details', $data)->render();
        return response()->json(['createView' => $createView]);
        dd($request->all());
    }

    public function getTaskTimeline(Request $request, Task $task)
    {
        try {
            // Get task assignments with joins to project_employees for ordering
            $query = TaskAssignment::with([
                'employee',
                'position',
                'status',
                'task.status'
            ])
                ->join('project_employees', function ($join) use ($task) {
                    $join->on('task_assignments.employee_id', '=', 'project_employees.employee_id')
                        ->where('project_employees.project_id', '=', $task->project_id)
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
            $timelineHtml = view('tasks.partials.timeline', [
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

    public function storeComment(Request $request, TaskAssignment $task_assignment)
    {
        DB::beginTransaction();
        try {
            \Log::info('Storing comment', [
                'task_assignment_id' => $task_assignment->id,
                'user_id' => auth()->id(),
                'content' => $request->content
            ]);

            // Create the comment
            $comment = $task_assignment->comments()->create([
                'user_id' => auth()->id(),
                'content' => $request->content,
                'task_assignment_id' => $task_assignment->id
            ]);

            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Validate each file
                    if (!$file->isValid()) {
                        throw new \Exception("Invalid file uploaded: " . $file->getClientOriginalName());
                    }

                    // Upload file using your helper
                    $path = uploadImage(
                        $file,
                        "projects/{$task_assignment->task->project_id}/task_assignments/{$task_assignment->id}/comments"
                    );

                    \Log::info('File uploaded successfully', [
                        'path' => $path,
                        'comment_id' => $comment->id
                    ]);

                    // Create attachment record
                    $comment->attachments()->create([
                        'file_path' => $path,
                        'file_hash' => basename($path),
                        'attachable_type' => TaskAssignmentComment::class,
                        'attachable_id' => $comment->id,
                        'file_name' => $file->getClientOriginalName(),
                        'source' => 'App',
                        'attachment_type_id' => 1 // Make sure this is the correct type ID for your system
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at,
                    'user' => [
                        'name' => auth()->user()->name
                    ],
                    'attachments' => $comment->attachments->map(function ($attachment) {
                        return [
                            'id' => $attachment->id,
                            'file_name' => $attachment->file_name,
                            'file_path' => asset($attachment->file_path)
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error storing comment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'task_assignment_id' => $task_assignment->id ?? null,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to store comment: ' . $e->getMessage()
            ], 422);
        }
    }
    public function getComments(TaskAssignment $task_assignment)
    {
        try {
            $comments = $task_assignment->comments()
                ->with(['user', 'attachments'])
                ->latest()
                ->get();

            $html = view('tasks.partials._comments', compact('comments'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'commentsCount' => $comments->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading comments', [
                'error' => $e->getMessage(),
                'task_assignment_id' => $task_assignment->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load comments'
            ], 422);
        }
    }
}
