<?php

namespace App\Models;

use App\Traits\HasActionButtons;
use App\Services\Constants\GetConstantService;
use App\Enums\DropDownFields;
use App\Enums\Modules;
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
        'question',
        'type',
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

    protected $appends = ['type_text'];

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

    public function answers()
    {
        return $this->hasMany(ProgramAnswer::class);
    }

    /**
     * Get translated type text from constants
     */
    public function getTypeTextAttribute()
    {
        $typeConstant = GetConstantService::get_question_type_list($this->type)->first();
        return $typeConstant ? $typeConstant->name : $this->type;
    }

    /**
     * Get available question types
     */
    public static function getTypes()
    {
        return GetConstantService::get_question_type_list();
    }

    protected function getActionButtons(): array
    {
        return [
            $this->getEditButton(),
            $this->getRemoveButton(),
        ];
    }

    protected function getEditButton()
    {
        $route = route(Program::ui['route'] . '.pages.' . self::ui['route'] . '.edit', [
            'program' => $this->page->program_id,
            'page' => $this->program_page_id,
            '_model' => $this->id
        ]);

        return generateButton(
            $route,
            t('Edit ' . self::ui['s_ucf']),
            'btn_update_' . self::ui['s_lcf'],
            getSvgIcon('edit', 'Edit')
        );
    }

    protected function getRemoveButton()
    {
        $route = route(Program::ui['route'] . '.pages.' . self::ui['route'] . '.delete', [
            'program' => $this->page->program_id,
            'page' => $this->program_page_id,
            '_model' => $this->id
        ]);

        $attributes = 'data-' . self::ui['s_lcf'] . '-name="' . ($this->question['en'] ?? '') . '"';

        return generateButton(
            $route,
            t('Remove ' . self::ui['s_ucf']),
            'btn_delete_' . self::ui['s_lcf'],
            getSvgIcon('delete', 'Delete'),
            $attributes
        );
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
