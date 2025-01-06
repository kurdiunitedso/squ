<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contract_id',
        'item_id',
        'cost',
        'qty',
        'discount',
        'total_cost',
        'notes',
    ];
    public const ui = [
        'table' => 'contract_items',
        'route' => 'contract_items',

        's_ucf' => 'Contract Item', //uppercase first
        'p_ucf' => 'Contract Items',

        's_lcf' => 'contract_item', //lowercase first
        'p_lcf' => 'contract_items',

        '_id' => 'contract_item_id',
        'controller_name' => 'ContractItemController',
        'image_path' => 'contract_items',
    ];



    protected $casts = [
        'cost' => 'float',
        'qty' => 'integer',
        'discount' => 'float',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function item() //service
    {
        return $this->belongsTo(Item::class);
    }
    public function project()
    {
        return $this->hasOne(Project::class);
    }

    public function getActionButtonsAttribute()
    {
        $project = $this->project;

        $buttons = [
            $this->getProjectButton($project),
            $this->getEditButton(),
            $this->getRemoveButton()
        ];

        return implode('', $buttons);
    }

    private function getProjectButton($project)
    {
        return $project ? $this->getViewProjectButton($project) : $this->getAddProjectButton();
    }

    private function getAddProjectButton()
    {
        $route = route(Contract::ui['route'] . '.' . self::ui['route'] . '.addEditProject', [
            Contract::ui['s_lcf'] => $this->contract_id,
            self::ui['s_lcf'] => $this->id
        ]);
        $title = t('Create ' . Project::ui['s_lcf']);
        $class = 'btn_add_' . Project::ui['s_lcf'];
        $icon = getSvgIcon('add');

        return generateButton($route, $title, $class, $icon);
    }

    private function getViewProjectButton($project)
    {
        $route = route(Project::ui['route'] . '.edit', [Project::ui['s_lcf'] => $project->id]);
        $title = t('View ' . Project::ui['s_lcf']);
        $icon = getSvgIcon('view');

        return generateButton($route, $title, '', $icon);
    }

    private function getEditButton()
    {
        $route = route(Contract::ui['route'] . '.' . self::ui['route'] . '.edit', [
            Contract::ui['s_lcf'] => $this->contract_id,
            self::ui['s_lcf'] => $this->id
        ]);
        $title = t('Edit ' . self::ui['s_lcf']);
        $class = 'btn_update_' . self::ui['s_lcf'];
        $icon = getSvgIcon('edit');

        return generateButton($route, $title, $class, $icon);
    }

    private function getRemoveButton()
    {
        $route = route(Contract::ui['route'] . '.' . self::ui['route'] . '.delete', [
            Contract::ui['s_lcf'] => $this->contract_id,
            self::ui['s_lcf'] => $this->id
        ]);
        $title = t('Remove ' . self::ui['s_lcf']);
        $class = 'btn_delete_' . self::ui['s_lcf'];
        $icon = getSvgIcon('delete');
        $attributes = 'data-item-name="' . ($this->item->description ?? '') . '"';

        return generateButton($route, $title, $class, $icon, $attributes);
    }
}
