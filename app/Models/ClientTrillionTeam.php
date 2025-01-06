<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class ClientTrillionTeam extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'client_trillion_teams';

    public function shift()
    {
        return $this->belongsTo(Constant::class, 'schedule_id');
    }

    public function department()
    {
        return $this->belongsTo(Constant::class, 'department_id');
    }
    public function title()
    {
        return $this->belongsTo(Constant::class, 'title_id');
    }
}
