<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAnswer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'ticket_answers';
    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id')->withDefault(['name' => 'NA']);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault(['name' => 'NA']);
    }


}
