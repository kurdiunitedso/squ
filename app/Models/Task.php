<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        Project::ui['_id'],
        'title',
        'description',
        'start_date',
        'end_date',
        'status_id',
    ];
    public const ui = [
        'table' => 'tasks',
        'route' => 'tasks',
        '_id' => 'task_id',
        'image_path' => 'tasks',
        's_lcf' => 'task', //single lowercase first
        'p_lcf' => 'tasks', //plural lowercase first

        's_ucf' => 'Task', //single uppercase first
        'p_ucf' => 'Tasks',
        'controller_name' => 'TaskController',
    ];
    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }
    public function taskAssignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function taskProcesses()
    {
        return $this->hasManyThrough(TaskProcess::class, TaskAssignment::class);
    }
}
