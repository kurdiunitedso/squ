<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskProcessComment extends Model
{
    use SoftDeletes;

    protected $fillable = ['task_process_id', 'user_id', 'notes'];
    public const ui = [
        'table' => 'task_processe_comments',
        'route' => 'task_processe_comments',
        '_id' => 'task_process_comment_id',
        'image_path' => 'task_processe_comments',
        's_lcf' => 'task_process_comment', //single lowercase first
        'p_lcf' => 'task_processe_comments', //plural lowercase first

        's_ucf' => 'Task Process Comment', //single uppercase first
        'p_ucf' => 'Task Process Comments',
        'controller_name' => 'TaskProcessCommentController',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
