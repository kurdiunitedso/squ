<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectEmployee extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'employee_id',
        'project_id',
        'position_id',
        'order'
    ];

    public const ui = [
        'table' => 'project_employees',
        'route' => 'project_employees',

        's_lcf' => 'project_employee', //lowercase first
        'p_lcf' => 'project_employees',

        '_id' => 'project_employee_id',
        'image_path' => 'project_employees',


        's_ucf' => 'Project Employee', //uppercase first
        'p_ucf' => 'Project Employees',

        'controller_name' => 'ContractController',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    // Add position relationship
    public function position()
    {
        return $this->belongsTo(Constant::class, 'position_id');
    }
}
