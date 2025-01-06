<?php

namespace App\Http\Controllers\Projects;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Constant;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskProcess;
use App\Models\TaskProcessComment;
use App\Services\Dashboard\Filters\TaskFilterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use Exception;
use Illuminate\Support\Str;

class TaskProcessCommentController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(Task $_model, TaskFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }
    public function task_process_comments(TaskProcess $taskProcess)
    {
        Log::info('Fetching comments for task process', [
            'task_process_id' => $taskProcess->id
        ]);

        try {
            $comments = $taskProcess->comments()
                ->with(['user', 'attachments'])
                ->latest()
                ->get();

            Log::info('Successfully fetched comments', [
                'comment_count' => $comments->count()
            ]);

            return response()->json(['comments' => $comments]);
        } catch (Exception $e) {
            Log::error('Error fetching comments', [
                'error' => $e->getMessage(),
                'task_process_id' => $taskProcess->id
            ]);

            return response()->json(['error' => 'Failed to fetch comments'], 500);
        }
    }

    public function store_task_process_comments(Request $request)
    {
        Log::info('Starting to store task process comment', [
            'task_process_id' => $request->task_process_id,
            'user_id' => auth()->id()
        ]);

        try {
            DB::beginTransaction();

            // Create comment
            $comment = TaskProcessComment::create([
                'task_process_id' => $request->task_process_id,
                'user_id' => auth()->id(),
                'notes' => $request->content
            ]);

            Log::info('Created task process comment', [
                'comment_id' => $comment->id
            ]);

            // Handle attachments
            if ($request->hasFile('files')) {
                $this->handleAttachments($request, $comment);
            }

            DB::commit();

            Log::info('Successfully stored task process comment with attachments');

            return response()->json(['success' => true, 'comment' => $comment->load(['user', 'attachments'])]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing task process comment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Failed to store comment'], 500);
        }
    }

    protected function handleAttachments($request, $comment)
    {
        Log::info('Starting to handle attachments');

        foreach ($request->file('files') as $index => $file) {
            Log::info('Processing file', [
                'index' => $index,
                'original_name' => $file->getClientOriginalName()
            ]);

            try {
                if ($file->isValid()) {
                    $this->saveAttachment($file, $comment);
                } else {
                    Log::error("Invalid file", [
                        'index' => $index,
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    throw new Exception("Invalid file uploaded");
                }
            } catch (Exception $e) {
                Log::error('Error processing file', [
                    'index' => $index,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        }

        Log::info('Finished handling attachments');
    }

    protected function saveAttachment($file, $comment)
    {
        Log::info('Saving attachment', [
            'original_name' => $file->getClientOriginalName()
        ]);

        try {
            $path = uploadImage($file, 'task_process_comments');
            Log::info('File uploaded successfully', [
                'path' => $path
            ]);

            $fileName = basename($path);

            $attachment = new Attachment([
                'file_path' => $path,
                'file_hash' => $fileName,
                'attachable_type' => TaskProcessComment::class,
                'attachable_id' => $comment->id,
                'file_name' => $file->getClientOriginalName(),
                'source' => 'App'
            ]);

            $attachment->save();

            Log::info('Attachment saved successfully', [
                'attachment_id' => $attachment->id
            ]);

            return $attachment;
        } catch (Exception $e) {
            Log::error('Error saving attachment', [
                'error' => $e->getMessage(),
                'file_name' => $file->getClientOriginalName()
            ]);
            throw $e;
        }
    }
    /**
     * Delete the specified attachment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Log::info('Attempting to delete task process comment attachment', ['attachment_id' => $id]);

            $attachment = TaskProcessCommentAttachment::findOrFail($id);

            // Store the file path before deleting the record
            $filePath = $attachment->file_path;

            // Delete the record from database
            $attachment->delete();

            // Delete the actual file from storage
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
                Log::info('Successfully deleted file from storage', ['file_path' => $filePath]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Attachment deleted successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Error deleting task process comment attachment', [
                'attachment_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete attachment: ' . $e->getMessage()
            ], 500);
        }
    }
}
