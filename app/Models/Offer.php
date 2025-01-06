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

class Offer extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];

    public const ui = [
        'table' => 'offers',
        'route' => 'offers',

        's_ucf' => 'Offer', //uppercase first
        'p_ucf' => 'offers',

        's_lcf' => 'offer', //lowercase first
        'p_lcf' => 'offers',

        '_id' => 'offer_id',
        'controller_name' => 'OfferController',
        'image_path' => 'offers',
    ];
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id')->with('type', 'category');
    }

    public function lead()
    {
        return $this->belongsTo(Facility::class, 'lead_id');
    }


    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function items()
    {
        return $this->hasMany(OfferItem::class, 'offer_id');
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }
    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id')->withDefault(['name' => 'NA']);
    }
    public function contract()
    {
        return $this->hasOne(Contract::class, self::ui['_id']);
    }
    public function getActionButtonsAttribute()
    {
        $contractBtns = $editBtn = $removeBtn = $menu = '';

        if (Auth::user()->can('offer_edit')) {
            if (Auth::user()->canAny(['offer_edit'])) {
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

                if (Auth::user()->can('offer_edit')) {

                    $menu .= '
                            <div class="menu-item px-3">
                                <a href="' . route('offers.view_attachments', ['offer' => $this->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                                    Show Attachments (' . $this->attachments_count . ')
                                </a>

                            </div>';
                }


                $menu .= '
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        ';
            }


            $editBtn = '<a href="' . route('offers.edit', ['offer' => $this->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateoffer">
                                    <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                                    </svg>
                                    </span>
                                    </a>';

            $sendEmail = '<a href="javascript:;"  link="' . route('offers.sendEmail', ['offer' => $this->id]) . '?type=sendEmail"  class="btn btn-icon btn-active-light-primary w-30px h-30px sendEmail">
                                                                <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <title>Mail</title>

                                                <defs/>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M18.1444251,10.8396467 L12,14.1481833 L5.85557487,10.8396467 C5.4908718,10.6432681 5.03602525,10.7797221 4.83964668,11.1444251 C4.6432681,11.5091282 4.77972206,11.9639747 5.14442513,12.1603533 L11.6444251,15.6603533 C11.8664074,15.7798822 12.1335926,15.7798822 12.3555749,15.6603533 L18.8555749,12.1603533 C19.2202779,11.9639747 19.3567319,11.5091282 19.1603533,11.1444251 C18.9639747,10.7797221 18.5091282,10.6432681 18.1444251,10.8396467 Z" fill="#999"/>
                                                    <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#999" fill-rule="nonzero" opacity="0.3" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508) "/>
                                                </g>
                                            </svg>
                                                                </span>
                                                                </a>';

            $printOffer = '<a href="' . route('offers.printOffer', ['offer' => $this->id]) . '?type=printOffer" target="_blank"  class="btn btn-icon btn-active-light-primary w-30px h-30px printOffer">
                                                                                <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <title>Print</title>

                                                                <defs/>
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                    <path d="M16,17 L16,21 C16,21.5522847 15.5522847,22 15,22 L9,22 C8.44771525,22 8,21.5522847 8,21 L8,17 L5,17 C3.8954305,17 3,16.1045695 3,15 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,15 C21,16.1045695 20.1045695,17 19,17 L16,17 Z M17.5,11 C18.3284271,11 19,10.3284271 19,9.5 C19,8.67157288 18.3284271,8 17.5,8 C16.6715729,8 16,8.67157288 16,9.5 C16,10.3284271 16.6715729,11 17.5,11 Z M10,14 L10,20 L14,20 L14,14 L10,14 Z" fill="#999"/>
                                                                    <rect fill="#999" opacity="0.3" x="8" y="2" width="8" height="2" rx="1"/>
                                                                </g>
                                                            </svg>
                                                                                </span>
                                                                                </a>';

            $removeBtn = '<a data-offer-name="' . $this->name . '" href=' . route('offers.delete', ['offer' => $this->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteoffer"
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
            $contractBtns = $this->getContractButton($this->contract);
        }
        return $contractBtns . $editBtn . $sendEmail . $printOffer . $removeBtn . $menu;
    }


    private function getContractButton($contract)
    {
        return $contract ? $this->getViewContractButton($contract) : $this->getAddContractButton();
    }

    private function getAddContractButton()
    {
        $route = route(self::ui['route'] . '.add_contract', [self::ui['s_lcf'] => $this->id]);
        $title = t('Create ' . Contract::ui['s_lcf']);
        $class = 'btn_add_' . Contract::ui['s_lcf'];
        // $icon = getSvgIcon('convert/transorm');
        $icon = getSvgIcon('add');

        return generateButton($route, $title, $class, $icon);
    }

    private function getViewContractButton($contract)
    {
        $route = route(Contract::ui['route'] . '.edit', [Contract::ui['s_lcf'] => $contract->id]);
        $title = t('View ' . Contract::ui['s_lcf']);
        $icon = getSvgIcon('view');

        return generateButton($route, $title, '', $icon);
    }
}
