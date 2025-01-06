<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskAssignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        Task::ui['_id'],
        Employee::ui['_id'],
        'next_employee_id',
        'position_id',
        'art_manager_id',
        'title',
        'description',
        'active',
        'start_date',
        'end_date',
        'status_id',
        'actual_start_date',
        'actual_end_date',
        'actual_days',
    ];
    public const ui = [
        'table' => 'task_assignments',
        'route' => 'task_assignments',
        '_id' => 'task_assignment_id',
        'image_path' => 'task_assignments',
        's_lcf' => 'task_assignment', //single lowercase first
        'p_lcf' => 'task_assignments', //plural lowercase first

        's_ucf' => 'Task Assignment', //single uppercase first
        'p_ucf' => 'Task Assignments',
        'controller_name' => 'TaskAssignmentController',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'scheduled_date' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }
    public function task_processes()
    {
        return $this->hasMany(TaskProcess::class, TaskAssignment::ui['_id']);
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function position()
    {
        return $this->belongsTo(Constant::class, 'position_id');
    }
    public function comments()
    {
        return $this->hasMany(TaskAssignmentComment::class);
    }
}
