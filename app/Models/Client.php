<?php

namespace App\Models;

use App\Traits\HasActionButtons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

class Client extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable, HasActionButtons, Notifiable, AuditingAuditable, HasTranslations;
    public $translatable = ['name'];


    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'number_family_members',
        'lead_id',
        'active',
        'bank_id',
        'bank_branch_id',
        'bank_iban',
        'bank_account_number',
    ];
    public const ui = [
        'table' => 'clients',
        'route' => 'clients',
        's_ucf' => 'Client',
        'p_ucf' => 'Clients',
        's_lcf' => 'client',
        'p_lcf' => 'clients',
        'view' => 'CP.clients.',
        '_id' => 'client_id',
        'controller_name' => 'ClientController',
        'image_path' => 'clients'
    ];
    public function lead()
    {
        return $this->belongsTo(Lead::class, Lead::ui['_id']);
    }
    public function bank()
    {
        return $this->belongsTo(Constant::class, 'bank_id');
    }
    public function bank_branch()
    {
        return $this->belongsTo(Constant::class, 'bank_branch_id');
    }
}
