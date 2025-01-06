<!--begin::Card header-->
<div class="card-header">
    <!--begin::Card title-->
    <div class="card-title m-0">
        <h3 class="fw-bold m-0">{{__('Policy Offer Details')}}</h3>
    </div>
    <!--end::Card title-->
    <div class="card-toolbar">


        <div class="align-items-center d-flex flex-row me-4">
            <div class="form-check form-switch" id="has_insurance_select">
                <input class="form-check-input" type="checkbox" role="switch" id="has_accidents"
                       @if(isset($policyOffer))
                           @checked($policyOffer->has_accidents == 1)
                           @if($policyOffer->has_accidents)
                               value="on"
                       @else
                           value="off"
                       @endif

                       @else
                           value="off"
                       @endif

                       name="has_accidents_c">
                <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                       for="has_accident">
                    {{ __('Has Accident') }}

                   </label>
            </div>
        </div>
        <div class="align-items-center d-flex flex-row me-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="active" name="active_c_policy"
                       @if(isset($policyOffer))
                           @checked($policyOffer->active == 1)
                           @if($policyOffer->active)
                               value="on"
                       @else
                           value="off"
                       @endif

                       @else
                           value="off"
                    @endif>
                <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                       for="status">  {{ __('Active') }}</label>
            </div>
        </div>
        <div class="align-items-center d-flex flex-row me-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_mortgaged" name="is_mortgaged_c"
                       @if(isset($policyOffer))
                           @checked($policyOffer->is_mortgaged == 1)
                           @if($policyOffer->is_mortgaged)
                               value="on"
                       @else
                           value="off"
                       @endif

                       @else
                           value="off"
                    @endif>
                <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                       for="status">  {{ __('Is Mortgaged') }}</label>
            </div>
        </div>
        <div class="align-items-center d-flex flex-row me-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="drivers"
                       name="drivers_under_24_c"
                       @if(isset($policyOffer))
                           @checked($policyOffer->drivers_under_24 == 1)
                           @if($policyOffer->drivers_under_24)
                               value="on"
                       @else
                           value="off"
                       @endif

                       @else
                           value="off"
                    @endif>
                <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                       for="status">  {{ __('Drivers Under 24') }}</label>
            </div>
        </div>
        <div class="align-items-center d-flex flex-row me-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="work_transport_c"
                       name="work_transport_c"
                       @if(isset($policyOffer))
                           @checked($policyOffer->work_transport == 1)
                           @if($policyOffer->work_transport)
                               value="on"
                       @else
                           value="off"
                       @endif

                       @else
                           value="off"
                    @endif>
                <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                       for="status">  {{ __('Work in Transport') }}</label>
            </div>
        </div>


    </div>
</div>
<!--begin::Card body-->
<div class="card-body p-9">
    <div class="row">

        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2"
                       data-input-name="PolicyOffer type">{{ __('Policy Offer Type') }}</label>
                <!--end::Label-->
                <!--begin::Input-->

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="policyOffer_type"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($policyOffer_types as $policyOffer_type)
                        <option value="{{ $policyOffer_type->id }}"
                        @isset($policyOffer)
                            @selected($policyOffer->policyOffer_type == $policyOffer_type->id)
                            @endisset>
                            {{ $policyOffer_type->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>

        <div class="col-md-3 has_accidents  {{isset($policyOffer) && $policyOffer->has_accidents?'':'d-none'}}">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2"
                       data-input-name="PolicyOffer Model">{{ __('Last Accident Year') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="last_accident_year" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($policyOffer) ? $policyOffer->last_accident_year : '' }}"/>

                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3 has_accidents  {{isset($policyOffer) && $policyOffer->has_accidents?'':'d-none'}}">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2"
                       data-input-name="PolicyOffer Model">{{ __('Accident Details') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2" name="accident_desc"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($accident_descs as $m)
                        <option value="{{ $m->id }}"
                        @isset($policyOffer)
                            @selected($policyOffer->accident_desc == $m->id)
                            @endisset>
                            {{ $m->name }}</option>
                    @endforeach
                </select>

                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3 mortgaged {{isset($policyOffer) && $policyOffer->is_mortgaged?'':'d-none'}}">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" data-input-name="Fuel Type">{{ __('Mortgaged Type') }}</label>
                <!--end::Label-->
                <!--begin::Input-->

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2" name="mortgaged_type"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($mortgaged_types as $mortgaged_type)
                        <option value="{{ $mortgaged_type->id }}"
                        @isset($policyOffer)
                            @selected($policyOffer->policyOffer_brand == $mortgaged_type->id)
                            @endisset>
                            {{ $mortgaged_type->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3 mortgaged {{isset($policyOffer) && $policyOffer->is_mortgaged?'':'d-none'}}">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2"
                       data-input-name="{{__('Mortgaged Name')}}">{{__('Mortgaged Name')}}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="mortgaged_name" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($policyOffer) ? $policyOffer->mortgaged_name : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2"
                       data-input-name="License Expire Date">{{__('Insurance Start Date')}}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="position-relative d-flex align-items-center">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                    <span class="svg-icon svg-icon-2 position-absolute mx-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                      d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                      fill="currentColor"></path>
                                <path
                                    d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                    <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Datepicker-->
                    <input type="text" name="insurance_start_date" id="kt_datepicker_8"
                           class="form-control form-control-solid ps-12 flatpickr-input mb-3 mb-lg-0" placeholder=""
                           value="{{ isset($policyOffer) ? $policyOffer->insurance_start_date : '' }}"/>
                    <!--end::Datepicker-->
                </div>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2"
                       data-input-name="License Expire Date">{{__('Insurance End Date')}}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="position-relative d-flex align-items-center">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                    <span class="svg-icon svg-icon-2 position-absolute mx-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                      d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                      fill="currentColor"></path>
                                <path
                                    d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                    <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Datepicker-->
                    <input type="text" name="insurance_end_date" id="kt_datepicker_9"
                           class="form-control form-control-solid ps-12 flatpickr-input mb-3 mb-lg-0" placeholder=""
                           value="{{ isset($policyOffer) ? $policyOffer->insurance_end_date : '' }}"/>
                    <!--end::Datepicker-->
                </div>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="">{{ __('Offer Cost') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="offer_cost" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($policyOffer) ? $policyOffer->offer_cost : '' }}"/>

                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="">{{ __('Approved Cost') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="offer_approved_cost" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($policyOffer) ? $policyOffer->offer_approved_cost : '' }}"/>

                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="">{{ __('Policy ID') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="policy_id" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($policyOffer) ? $policyOffer->policy_id : '' }}"/>

                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2"
                       data-input-name="PolicyOffer type">{{ __('Status') }}</label>
                <!--end::Label-->
                <!--begin::Input-->

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="status_id"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($status_ids as $status_id)
                        <option value="{{ $status_id->id }}"
                        @isset($policyOffer)
                            @selected($policyOffer->status_id == $status_id->id)
                            @endisset>
                            {{ $status_id->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-12">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="">{{ __('Details') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea name="details" class="form-control form-control-solid mb-3 mb-lg-0">
                    {{ isset($policyOffer) ? $policyOffer->details : '' }}
                </textarea>

                <!--end::Input-->
            </div>
        </div>


    </div>


</div>






