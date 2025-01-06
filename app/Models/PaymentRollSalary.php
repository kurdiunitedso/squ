<?php

namespace App\Models;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use Database\Seeders\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trig\Cosecant;

class PaymentRollSalary extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'payment_roll_salary';
    public function currencys()
    {
        return $this->belongsTo(Constant::class, 'currency')->withDefault(['name' => 'NA']);
    }

}
