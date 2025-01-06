<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Attachment extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;
    protected $fillable = [
        'file_name',
        'attachment_type_id',
        'file_hash',
        "file_path",
        "attachable_type",
        "attachable_id",
        "source"
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function source()
    {
        return $this->morphTo();
    }

    public function attachmentType()
    {
        return $this->belongsTo(Constant::class, 'attachment_type_id');
    }
}
