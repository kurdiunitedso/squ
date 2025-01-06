<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\HasLocalizedNameAttribute;

class Project extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasLocalizedNameAttribute, AuditingAuditable;

    protected $fillable = [
        'contract_id',
        'objective_type_id',
        'item_id',
        ContractItem::ui['_id'],
        'project_type_id',
        'status_id',
        'account_manager_id',
        'art_manager_id',
        'frequency',
        'duration',
        'qty',
        'start_date',
        'end_date',
    ];

    public const ui = [
        'table' => 'projects',
        'route' => 'projects',
        's_lcf' => 'project', //single lowercase first
        's_ucf' => 'Project', //single upercase first

        'p_ucf' => 'Projects', //plural upercase first
        'p_lcf' => 'projects', // plural lowercase first

        '_id' => 'project_id', //model _id in the CRUD opration


        'controller_name' => 'ProjectController',
        'image_path' => 'projects',
    ];

    protected $casts = [
        'frequency' => 'integer',
        'duration' => 'integer',
        'qty' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($project) {
            $existingProject = static::where('contract_id', $project->contract_id)
                ->where('contract_item_id', $project->contract_item_id)
                ->where('item_id', $project->item_id)
                ->where('id', '!=', $project->id)
                ->first();

            if ($existingProject) {
                throw new \Exception('A project already exists for this contract and item combination.');
            }
        });
    }

    public function contract_item()
    {
        return $this->belongsTo(ContractItem::class);
    }
    public function objective_type()
    {
        return $this->belongsTo(Constant::class, 'objective_type_id');
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function project_type()
    {
        return $this->belongsTo(Constant::class, 'project_type_id');
    }

    public function account_manager()
    {
        return $this->belongsTo(Employee::class, 'account_manager_id');
    }
    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }

    public function art_manager()
    {
        return $this->belongsTo(Employee::class, 'art_manager_id');
    }
    public function projectEmployees()
    {
        return $this->hasMany(ProjectEmployee::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function objectives()
    {
        return $this->belongsToMany(Objective::class, 'project_objective')
            ->withPivot('notes')
            ->withTimestamps();
    }

    // Add accessor to maintain backward compatibility
    public function getObjectivesAttribute()
    {
        return $this->objectives()->pluck('name')->implode(',');
    }

    public function getActionButtonsAttribute()
    {
        if (!Auth::user()->can(self::ui['s_lcf'] . '_edit')) {
            return '';
        }

        $buttons = [
            $this->getEditButton(),
            $this->getRemoveButton(),
            $this->getMenuButton()
        ];

        return implode('', array_filter($buttons));
    }

    private function getEditButton()
    {
        $route = route(self::ui['route'] . '.edit', [self::ui['s_lcf'] => $this->id]);
        $title = t('Edit ' . self::ui['s_lcf']);
        $class = 'btnUpdate' . self::ui['s_ucf'];
        $icon = getSvgIcon('edit');

        return generateButton($route, $title, $class, $icon);
    }

    private function getRemoveButton()
    {
        $route = route(self::ui['route'] . '.delete', [self::ui['s_lcf'] => $this->id]);
        $title = t('Remove ' . self::ui['s_lcf']);
        $class = 'btnDelete' . self::ui['s_ucf'];
        $icon = getSvgIcon('delete');
        $attributes = 'data-' . self::ui['s_ucf'] . '-name="' . $this->objectives . '"';

        return generateButton($route, $title, $class, $icon, $attributes);
    }

    private function getMenuButton()
    {
        if (!Auth::user()->canAny([self::ui['s_lcf'] . '_edit'])) {
            return '';
        }

        $menuTrigger = generateButton('#', '', '', getSvgIcon('menu'), 'data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end"');

        $menuItems = '';
        if (Auth::user()->can(self::ui['s_lcf'] . '_edit')) {
            $menuItems .= getAttachmentsMenuItem($this);
        }

        return $menuTrigger . wrapInMenuContainer($menuItems);
    }
}
