<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use mysql_xdevapi\Table;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class EmployeeProject  extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];
protected $table='employee_projects';

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault(['name' => 'NA']);;
    }
    public function project()
    {
        return $this->belongsTo(Constant::class,'project_id')->withDefault(['name' => 'NA']);;
    }

}
