<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;


class ClientTrillion extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];
    protected $table = 'client_trillions';

    public const ui = [
        'table' => 'client_trillions',
        'route' => 'clientTrillions',

        's_ucf' => 'Client Trillion', //uppercase first
        'p_ucf' => 'Client Trillions',

        's_lcf' => 'client_trillion', //lowercase first
        'p_lcf' => 'client_trillions',

        '_id' => 'client_trillion_id',
        'controller_name' => 'ClientTrillionController',
        'image_path' => 'client_trillions',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function type()
    {
        return $this->belongsTo(Constant::class, 'company_type');
    }
    public function bank()
    {
        return $this->belongsTo(Constant::class, 'bank_name');
    }
    public function teams()
    {
        return $this->hasMany(ClientTrillionTeam::class, 'client_trillion_id');
    }

    public function socials()
    {
        return $this->hasMany(ClientTrillionSocial::class, 'client_trillion_id');
    }
    public function claims()
    {
        return $this->hasMany(Claim::class, 'client_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function callPhone()
    {
        return $this->hasMany(CdrLog::class, 'from', 'telephone');
    }

    public function smsPhone()
    {
        return $this->hasMany(SystemSmsNotification::class, 'mobile', 'telephone');
    }

    public function visits()
    {
        return $this->morphMany(VisitRequest::class, 'visitable');
    }
    public function getActionButtonsAttribute()
    {
        $editBtn = $smsAction = $callAction = $menu = '';
        /*    if (Auth::user()->canAny(['clientTrillion_register_history_access', 'clientTrillion_sms_access', 'clientTrillion_call_access', 'clientTrillion_edit'])) {
                                            $menu = '<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect y="6" width="16" height="3" rx="1.5" fill="currentColor"/>
                                                        <rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="currentColor"/>
                                                        <rect opacity="0.3" width="12" height="3" rx="1.5" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-175px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->';

                            */
        if (Auth::user()->can('clientTrillion_edit')) {

            $menu .= '
                        <div class="menu-item px-3">
                            <a href="' . route('clientTrillions.view_attachments', ['clientTrillion' => $this->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                                Show Attachments (' . $this->attachments_count . ')
                            </a>
                        </div>';
        }


        $menu .= '
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                    ';


        $editBtn = '<a href="' . route('clientTrillions.edit', ['clientTrillion' => $this->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateclientTrillion">
                        <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                        <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                        <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                        </svg>
                        </span>
                        </a>';

        $addProject = '  <a href="' . route('clientTrillions.socials.add', ['clientTrillion' => isset($this) ? $this->id : '']) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px " title="add Socail" id="AddSocialModalGrid">
                            <span class="indicator-label">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                              height="2" rx="1"
                                              transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                        <rect x="4.36396" y="11.364" width="16" height="2"
                                              rx="1" fill="currentColor"/>
                                    </svg>
                                </span>

                            </span>
                <span class="indicator-progress">
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
            </a>';
        /*   $callAction = '<a class="btn btn-icon btn-active-light-primary w-30px h-30px btnAddClientCall" href="' . route('calls.clientTrillion.create', ['clientTrillion' => $this->id]) . '">
                                <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"
                                    />
                                </svg>
                                </span>
                            </a>
                            ';*/
        $removeBtn = '';
        $creatVisit = '  <button type="button" url="' . route('visitRequests.create') . '?telephone=' . $this->telephone . '&selectedClientTrillions=' . $this->id . '&visit_name=' . $this->name . '&visit_category=250" class="btn btn-icon btn-active-light-primary w-30px h-30px" id="AddvisitsModal">
                    <span class="indicator-label">
                        <span class="svg-icon svg-icon-2">
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <title>Stockholm-icons / Communication / Clipboard-check</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="currentColor"></path>
                            <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"></path>
                            <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
                        </g>
                    </svg>
                        </span>
                    </span>

                </button>';

        if (Auth::user()->canAny(['clientTrillion_delete']))
            $removeBtn = '<a data-clientTrillion-name="' . $this->name . '" href=' . route('clientTrillions.delete', ['clientTrillion' => $this->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteclientTrillion"
                    >
                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                fill="currentColor" />
                            <path opacity="0.5"
                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                fill="currentColor" />
                            <path opacity="0.5"
                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a>';


        return $menu . $callAction . $smsAction . $creatVisit . $editBtn . $removeBtn . $addProject;
    }
}
