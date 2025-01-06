<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CdrModelPbx extends Model
{

    protected $table = 'cdr';
    public $timestamps = false;
    protected $connection = 'mysql2';
    protected $primaryKey = 'uniqueid';
    protected $fillable = [''];




}
