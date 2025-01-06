<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortMessageTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'short_message_templates';

    protected $fillable = [
        'type_id',
        'template_text',
    ];

    public function messageType()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }
}
