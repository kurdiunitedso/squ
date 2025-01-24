<?php

namespace App\Models;

use App\Traits\HasActionButtons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;


class ProgramPage extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, HasActionButtons;

    public $translatable = ['title'];

    protected $fillable = [
        'program_id',
        'title',
        'order',
        'structure'
    ];
    public const ui = [
        'table' => 'program_pages',
        'route' => 'program-pages',
        's_ucf' => 'Program Page',
        'p_ucf' => 'Program Pages',
        's_lcf' => 'program_page',
        'p_lcf' => 'program_pages',
        'view' => Program::ui['view'] . 'tabs.program-pages.',
        '_id' => 'program_page_id',
        'controller_name' => 'ProgramPageController',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function questions()
    {
        return $this->hasMany(ProgramPageQuestion::class);
    }

    /**
     * Override this method in your model to customize buttons
     */
    protected function getActionButtons(): array
    {
        return [
            $this->getEditButton(),
            $this->getRemoveButton(),
        ];
    }


    protected function getEditButton($route = null)
    {
        if (!isset($route)) {
            $route = route(Program::ui['route'] . '.' . self::ui['route'] . '.edit', ['program' => $this->program_id, '_model' => $this->id]);
        }
        $title = t('Edit ' . self::ui['s_ucf']);
        $class = 'btn_update_' . self::ui['s_lcf'];
        $icon = getSvgIcon('edit', $title);

        return generateButton($route, $title, $class, $icon);
    }

    protected function getRemoveButton($route = null, $attributes = null)
    {
        // i do it becuase of the attachemnt (has file name not name directly )
        if (!isset($attributes)) {
            $attributes = 'data-' . self::ui['s_lcf'] . '-name="' . ($this->title ?? '') . '"';
        }
        if (!isset($route)) {
            $route = route(Program::ui['route'] . '.' . self::ui['route'] . '.delete', ['program' => $this->program_id, '_model' => $this->id]);
        }
        $title = t('Remove ' . self::ui['s_ucf']);
        $class = 'btn_delete_' . self::ui['s_lcf'];
        $icon = getSvgIcon('delete', $title);

        return generateButton($route, $title, $class, $icon, $attributes);
    }
}
