<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskProcess extends Model
{
    use SoftDeletes;

    protected $fillable = [
        TaskAssignment::ui['_id'],
        Employee::ui['_id'],
        'user_id',
        'type_id',
        'old_value',
        'new_value',
        'notes',
    ];
    public const ui = [
        'table' => 'task_processes',
        'route' => 'task_processes',
        '_id' => 'task_process_id',
        'image_path' => 'task_processes',
        's_lcf' => 'task_process', //single lowercase first
        'p_lcf' => 'task_processes', //plural lowercase first

        's_ucf' => 'Task Process', //single uppercase first
        'p_ucf' => 'Task Processes',
        'controller_name' => 'TaskProcessController',
    ];
    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    public function task_assignment()
    {
        return $this->belongsTo(TaskAssignment::class, TaskAssignment::ui['_id']);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, Employee::ui['_id']);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }
    public function comments()
    {
        return $this->hasMany(TaskProcessComment::class, TaskProcess::ui['_id']);
    }
}
