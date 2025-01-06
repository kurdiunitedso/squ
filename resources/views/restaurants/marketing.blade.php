<div class="row">
    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Facebook')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="facebook_address"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($restaurant) ? $restaurant->facebook_address : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Instagram')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="instagram_address"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($restaurant) ? $restaurant->instagram_address : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('TikTok')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="tiktok_address"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($restaurant) ? $restaurant->tiktok_address : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class=" fw-semibold fs-6 mb-2" data-input-name="has_marketing_center">
                {{__('Has Marketing Center')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                    name="has_marketing_center"
                    data-placeholder="Select an option">
                <option></option>
                <option value="1"
                @isset($restaurant)
                    @selected($restaurant->has_marketing_center == '1')
                    @endisset>
                    {{ __('YES') }}
                </option>
                <option value="0"
                @isset($restaurant)
                    @selected($restaurant->has_marketing_center == '0')
                    @endisset>
                    {{ __('NO') }}
                </option>
            </select>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class=" fw-semibold fs-6 mb-2" data-input-name="has_marketing_center">
                {{__('Interst to market')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                    name="has_marketing_center"
                    data-placeholder="Select an option">
                <option></option>
                <option value="1"
                @isset($restaurant)
                    @selected($restaurant->interst_to_market == '1')
                    @endisset>
                    {{ __('YES') }}
                </option>
                <option value="0"
                @isset($restaurant)
                    @selected($restaurant->interst_to_market == '0')
                    @endisset>
                    {{ __('NO') }}
                </option>
            </select>
            <!--end::Input-->
        </div>
    </div>
{{--
    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">     {{__('Marketing Rep Name')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="marketing_rep_name"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($restaurant) ? $restaurant->marketing_rep_name : '' }}"/>
            <!--end::Input-->
        </div>
    </div>--}}


    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">  {{__('Marketing Company Name')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="marketing_rep_co_name"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($restaurant) ? $restaurant->marketing_rep_co_name : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Expected Monthly Payment')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="pay_to_marketing_agent_amount"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($restaurant) ? $restaurant->pay_to_marketing_agent_amount : '' }}"/>
            <!--end::Input-->
        </div>
    </div>


</div>
