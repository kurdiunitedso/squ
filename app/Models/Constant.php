<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Constant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['value', 'color', 'name', 'module', 'field', 'hayat_id', 'name_ar', 'parent_id', 'constant_name'];

    public const ui = [
        'table' => 'constants',
        'route' => 'constants',
        '_id' => 'constant_id',
        'image_path' => 'constants',
        's_lcf' => 'constant', //single lowercase first
        'p_lcf' => 'constants', //plural lowercase first
        's_ucf' => 'Constant', //single uppercase first
        'p_ucf' => 'Constants',


        'controller_name' => 'ConstantController',
    ];


    // public static function getAllConstants($module, $field)
    // {
    //     return self::where('module', $module)
    //         ->where('field', $field)
    //         ->orderBy('name')
    //         ->select('name', 'value');
    // }
    public function parent()
    {
        return $this->belongsTo(Constant::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Constant::class, 'parent_id')->orderBy('order');
    }

    public function getAttribute($key)
    {
        if ($key == 'name' && App::getLocale() == 'ar')

            return parent::getAttribute('name_ar') ? parent::getAttribute('name_ar') : parent::getAttribute('name');
        else if ($key == 'name')
            return parent::getAttribute('name');
        else
            return parent::getAttribute($key);
    }
}
