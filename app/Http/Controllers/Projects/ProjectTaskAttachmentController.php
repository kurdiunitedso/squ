<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class ProjectTaskAttachmentController extends Controller
{
    /**
     * Upload a new attachment
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, Project $project)
    {
        Log::info('Starting to upload task attachment', [
            'project_id' => $project->id,
            'user_id' => auth()->id()
        ]);

        try {
            // Validate the request
            $request->validate([
                'file' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,pdf,doc,docx,xls,xlsx,txt',
                'task_assignment_id' => 'required|exists:task_assignments,id'
            ]);

            // Verify task assignment belongs to project
            $taskAssignment = TaskAssignment::whereHas('task', function ($query) use ($project) {
                $query->where('project_id', $project->id);
            })->findOrFail($request->task_assignment_id);

            DB::beginTransaction();

            $file = $request->file('file');

            if (!$file->isValid()) {
                throw new Exception("Invalid file uploaded");
            }

            // Upload file using your helper (include project in path)
            $path = uploadImage($file, "projects/{$project->id}/task_assignments");

            Log::info('File uploaded successfully', [
                'path' => $path
            ]);

            $fileName = basename($path);

            // Create attachment
            $attachment = new Attachment([
                'file_path' => $path,
                'file_hash' => $fileName,
                'attachable_type' => TaskAssignment::class,
                'attachable_id' => $taskAssignment->id,
                'file_name' => $file->getClientOriginalName(),
                'source' => 'App'
            ]);

            $attachment->save();

            DB::commit();

            Log::info('Attachment saved successfully', [
                'attachment_id' => $attachment->id,
                'project_id' => $project->id
            ]);

            return response()->json([
                'success' => true,
                'message' => __('File uploaded successfully'),
                'attachment' => [
                    'id' => $attachment->id,
                    'file_name' => $attachment->file_name,
                    'file_path' => asset($attachment->file_path), // Use asset() here
                    'file_hash' => $attachment->file_hash
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error uploading task attachment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'project_id' => $project->id
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to upload file: ') . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attachments for a task assignment
     *
     * @param Project $project
     * @param TaskAssignment $taskAssignment
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAttachments(Project $project, TaskAssignment $taskAssignment)
    {
        try {
            // Verify task assignment belongs to project
            if ($taskAssignment->task->project_id !== $project->id) {
                throw new Exception('Task assignment does not belong to this project');
            }

            $attachments = $taskAssignment->attachments()
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'attachments' => $attachments
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching attachments', [
                'error' => $e->getMessage(),
                'project_id' => $project->id,
                'task_assignment_id' => $taskAssignment->id
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to fetch attachments')
            ], 500);
        }
    }

    /**
     * Remove an attachment
     *
     * @param Project $project
     * @param Attachment $attachment
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Project $project, Attachment $attachment)
    {
        Log::info('Starting to remove task attachment', [
            'attachment_id' => $attachment->id,
            'project_id' => $project->id,
            'user_id' => auth()->id()
        ]);

        try {
            DB::beginTransaction();

            // // Check if attachment belongs to a task assignment in this project
            // if (
            //     $attachment->attachable_type !== TaskAssignment::class ||
            //     !$attachment->attachable->task->project_id === $project->id
            // ) {
            //     throw new Exception('Invalid attachment');
            // }

            // Store file path before deleting
            $filePath = $attachment->file_path;

            // Delete the attachment
            $attachment->delete();

            // Remove the physical file
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }

            DB::commit();

            Log::info('Attachment removed successfully', [
                'attachment_id' => $attachment->id,
                'file_path' => $filePath,
                'project_id' => $project->id
            ]);

            return response()->json([
                'success' => true,
                'message' => __('File removed successfully')
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error removing task attachment', [
                'attachment_id' => $attachment->id,
                'project_id' => $project->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to remove file: ') . $e->getMessage()
            ], 500);
        }
    }
}
