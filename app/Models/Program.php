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
    public $translatable = ['name', 'description', 'how_to_apply'];


    protected $fillable = [
        'name',
        'description',
        'deadline',
        'how_to_apply',
        'target_applicant_id',
        'category_id',
        'fund',
    ];

    protected $casts = [
        'name' => 'array',
        'deadline' => 'datetime',
        'fund' => 'decimal:2'

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
    public function pages()
    {
        return $this->hasMany(ProgramPage::class)->orderBy('order');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }



    public function eligibilities()
    {
        return $this->belongsToMany(Constant::class, 'program_eligibility', 'program_id', 'eligibility_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Constant::class, 'program_facility', 'program_id', 'facility_id');
    }

    public function target_applicant()
    {
        return $this->belongsTo(Constant::class, 'target_applicant_id');
    }

    public function category()
    {
        return $this->belongsTo(Constant::class, 'category_id');
    }
    public function important_dates()
    {
        return $this->hasMany(ProgramImportantDate::class);
    }

    public function syncEligibilities($eligibilityIds)
    {
        $this->eligibilities()->sync($eligibilityIds);
    }
    public function syncFacilities($facilityIds)
    {
        $this->facilities()->sync($facilityIds);
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
