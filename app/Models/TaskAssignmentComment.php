<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskAssignmentComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_assignment_id',
        'user_id',
        'content',
        'active'
    ];

    // Relationships
    public function taskAssignment()
    {
        return $this->belongsTo(TaskAssignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
