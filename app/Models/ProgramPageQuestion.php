<?php

namespace App\Models;

use App\Traits\HasActionButtons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ProgramPageQuestion extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, HasActionButtons;

    public $translatable = ['question', 'options'];

    protected $fillable = [
        'program_id',
        'program_page_id',
        'field_type_id',
        'question',
        'options',
        'score',
        'required',
        'order'
    ];

    protected $casts = [
        'question' => 'array',
        'options' => 'array',
        'score' => 'integer',
        'required' => 'boolean',
        'order' => 'integer'
    ];

    public const ui = [
        'table' => 'program_page_questions',
        'route' => 'program-page-questions',
        's_ucf' => 'Program Page Question',
        'p_ucf' => 'Program Page Questions',
        's_lcf' => 'program_page_question',
        'p_lcf' => 'program_page_questions',
        'view' => 'program-page-questions.',
        '_id' => 'program_page_question_id',
        'controller_name' => 'ProgramPageQuestionController',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function page()
    {
        return $this->belongsTo(ProgramPage::class, 'program_page_id');
    }

    public function field_type()
    {
        return $this->belongsTo(Constant::class, 'field_type_id');
    }

    public function answers()
    {
        return $this->hasMany(ProgramAnswer::class);
    }

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

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
