<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditingAuditable;

class Objective extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'objective_type_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public const ui = [
        'table' => 'objectives',
        'route' => 'objectives',
        's_ucf' => 'Objective',
        'p_ucf' => 'Objectives',
        's_lcf' => 'objective',
        'p_lcf' => 'objectives',
        '_id' => 'objective_id',
        'controller_name' => 'ObjectiveController',
    ];

    public function contracts()
    {
        return $this->belongsToMany(Contract::class, 'contract_objective')
            ->withPivot('notes')
            ->withTimestamps();
    }
    public function objective_type()
    {
        return $this->belongsTo(Constant::class, 'objective_type_id');
    }
    public function getActionButtonsAttribute()
    {
        if (!Auth::user()->can('settings_' . Objective::ui['route'] . '_access')) {
            return '';
        }

        $buttons = [
            $this->getEditButton(),
            $this->getRemoveButton(),
            // $this->getMenuButton()
        ];

        return implode('', array_filter($buttons));
    }

    private function getEditButton()
    {
        $route = route('settings.' . self::ui['route'] . '.edit', [self::ui['s_lcf'] => $this->id]);
        $title = t('Edit ' . self::ui['s_lcf']);
        $class = 'btnUpdate' . self::ui['s_ucf'];
        $icon = getSvgIcon('edit');

        return generateButton($route, $title, $class, $icon);
    }

    private function getRemoveButton()
    {
        $route = route('settings.' . self::ui['route'] . '.delete', [self::ui['s_lcf'] => $this->id]);
        $title = t('Remove ' . self::ui['s_lcf']);
        $class = 'btnDelete' . self::ui['s_ucf'];
        $icon = getSvgIcon('delete');
        $attributes = 'data-' . self::ui['s_ucf'] . '-name="' . optional($this->client_trillion)->name . '"';

        return generateButton($route, $title, $class, $icon, $attributes);
    }
}
