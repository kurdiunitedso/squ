<?php

namespace App\Models;

use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;


class Contract extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasLocalizedNameAttribute, AuditingAuditable;
    protected $fillable = [
        'client_trillion_id',
        'account_manager_id',
        'objective_type_id',
        'offer_id',
        'type_id',
        'start_date',
        'end_date',
        'duration',
        'status_id',
        'total_cost',
        'total_discount',
        'is_vat',
        'approved_by_admin',
    ];
    public const ui = [
        'table' => 'contracts',
        'route' => 'contracts',

        's_ucf' => 'Contract', //uppercase first
        'p_ucf' => 'Contracts',

        's_lcf' => 'contract', //lowercase first
        'p_lcf' => 'contracts',

        '_id' => 'contract_id',
        'controller_name' => 'ContractController',
        'image_path' => 'contracts',
    ];


    protected $casts = [
        'start_date' => 'date',
        'is_vat' => 'boolean',
        'approved_by_admin' => 'boolean',
    ];

    public function client_trillion(): BelongsTo
    {
        return $this->belongsTo(ClientTrillion::class, 'client_trillion_id');
    }
    public function account_manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'account_manager_id');
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function contract_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }
    public function objective_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'objective_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }
    public function projects()
    {
        return $this->hasMany(Project::class, self::ui['_id']);
    }
    public function contract_items()
    {
        return $this->hasMany(ContractItem::class, self::ui['_id']);
    }
    public function items()
    {
        return $this->belongsToMany(Item::class, 'contract_items')
            ->withPivot('qty', 'cost', 'discount', 'notes')
            ->withTimestamps()
            ->whereNull('contract_items.deleted_at');  // This ensures only non-deleted contract items are included

    }

    public function getTotalCost()
    {
        return $this->contract_items()->sum(DB::raw('(contract_items.cost * contract_items.qty) - contract_items.discount'));
    }

    public function objectives()
    {
        return $this->belongsToMany(Objective::class, 'contract_objective')
            ->withPivot('notes')
            ->withTimestamps();
    }

    // Add accessor to maintain backward compatibility
    public function getObjectivesAttribute()
    {
        return $this->objectives()->pluck('name')->implode(',');
    }

    // // Add mutator to maintain backward compatibility
    // public function setObjectivesAttribute($value)
    // {
    //     // This will be handled in the controller
    //     $this->attributes['objectives_temp'] = $value;
    // }

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
        $attributes = 'data-' . self::ui['s_ucf'] . '-name="' . optional($this->client_trillion)->name . '"';

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
