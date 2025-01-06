<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdrLog extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'date',
        'from',
        'to',
        'duration',
        'call_status',
        'call_type',
        'uniqueid',
        'record_file_name',
    ];
    public static function updatemyData()
    {
        $date = self::orderBy('date', 'desc')->get()->first();
        if ($date)
            $datetime = $date->date;
        else
            $datetime = 0;

        $pbx = CdrModelPbx::where('datetime', '>', $datetime)
            ->where(function($q){$q->wherein('cdr.src',['225'])->orwherein('cdr.dst',['225']);})->get();

        foreach ($pbx as $p) {
            self::create([
                'name'=>$p->duration,
                'date'=>$p->datetime,
                'from'=>$p->src,
                'to'=>$p->dst,
                'duration'=>$p->duration,
                'call_status'=>$p->disposition,
                'uniqueid'=>$p->uniqueid,
                'record_file_name'=>$p->recordfile,
                'record_path'=>$p->recordpath,
            ]);
        }


        return $pbx;
    }
}
