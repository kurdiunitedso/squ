<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskProcess;
use App\Models\TaskProcessComment;

class TaskDeleteAction
{
    public function execute($tasks)
    {
        $deletedCounts = [
            'tasks' => 0,
            'assignments' => 0,
            'processes' => 0,
            'comments' => 0
        ];

        // Begin transaction
        \DB::beginTransaction();
        try {
            // Get IDs for related records before deletion
            $taskIds = $tasks->pluck('id')->toArray();

            $assignmentIds = TaskAssignment::whereIn('task_id', $taskIds)
                ->pluck('id')
                ->toArray();

            $processIds = TaskProcess::whereIn('task_assignment_id', $assignmentIds)
                ->pluck('id')
                ->toArray();

            // Soft delete all related records
            $deletedCounts['comments'] = TaskProcessComment::whereIn('task_process_id', $processIds)
                ->update(['deleted_at' => now()]);

            $deletedCounts['processes'] = TaskProcess::whereIn('id', $processIds)
                ->update(['deleted_at' => now()]);

            $deletedCounts['assignments'] = TaskAssignment::whereIn('id', $assignmentIds)
                ->update(['deleted_at' => now()]);

            $deletedCounts['tasks'] = Task::whereIn('id', $taskIds)
                ->update(['deleted_at' => now()]);

            \DB::commit();

            \Log::info("Soft deleted task hierarchy", $deletedCounts);
            return $deletedCounts;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error("Error soft deleting task hierarchy: " . $e->getMessage());
            throw $e;
        }
    }

    public function restore($tasks)
    {
        \DB::beginTransaction();
        try {
            $taskIds = $tasks->pluck('id')->toArray();

            $assignmentIds = TaskAssignment::withTrashed()
                ->whereIn('task_id', $taskIds)
                ->pluck('id')
                ->toArray();

            $processIds = TaskProcess::withTrashed()
                ->whereIn('task_assignment_id', $assignmentIds)
                ->pluck('id')
                ->toArray();

            TaskProcessComment::withTrashed()
                ->whereIn('task_process_id', $processIds)
                ->restore();

            TaskProcess::withTrashed()
                ->whereIn('id', $processIds)
                ->restore();

            TaskAssignment::withTrashed()
                ->whereIn('id', $assignmentIds)
                ->restore();

            Task::withTrashed()
                ->whereIn('id', $taskIds)
                ->restore();

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error("Error restoring task hierarchy: " . $e->getMessage());
            throw $e;
        }
    }
}
