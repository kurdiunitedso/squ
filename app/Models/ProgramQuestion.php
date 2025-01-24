<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ProgramPageQuestion extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['question', 'options'];

    protected $fillable = [
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
    public const ui = [
        'table' => 'program_page_questions',
        'route' => 'program-page-questions',
        's_ucf' => 'Program Question',
        'p_ucf' => 'Program Questions',
        's_lcf' => 'program_question',
        'p_lcf' => 'program_questions',
        'view' => 'CP.program-questions.',
        '_id' => 'program_question_id',
        'controller_name' => 'ProgramPageQuestionController',
    ];

    public function page()
    {
        return $this->belongsTo(ProgramPage::class, 'program_page_id');
    }
}
