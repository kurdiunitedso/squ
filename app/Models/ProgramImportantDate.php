<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Spatie\Translatable\HasTranslations;

class ProgramImportantDate extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable = ['title'];

    protected $fillable = ['program_id', 'title', 'date'];

    protected $casts = [
        'date' => 'date',
        'title' => 'array'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
