<?php

namespace App\Models;

use App\Traits\HasActionButtons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

class Program extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable, HasActionButtons, HasTranslations;
    public $translatable = ['name'];


    protected $fillable = [
        'name',
    ];

    public const ui = [
        'table' => 'programs',
        'route' => 'programs',
        's_ucf' => 'Program',
        'p_ucf' => 'Programs',
        's_lcf' => 'program',
        'p_lcf' => 'programs',
        'view' => 'CP.programs.',
        '_id' => 'program_id',
        'controller_name' => 'ProgramController',
        'image_path' => 'programs'
    ];


    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }





    /**
     * Override getActionButtons to customize buttons for Lead model
     */
    protected function getActionButtons(): array
    {
        return [
            $this->getEditButton(),
            $this->getRemoveButton(),
        ];
    }
}
