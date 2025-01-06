<!--begin::Card header-->
<div class="card-header">
    <!--begin::Card title-->
    <div class="card-title m-0">
        <h3 class="fw-bold m-0">{{__('Offer Details')}}</h3>
    </div>
    <!--end::Card title-->
    <div class="card-toolbar">


    </div>
</div>
<!--begin::Card body-->
<div class="card-body p-9">
    <div class="row">

        <div class="col-md-4">
            <div class="fv-row mb-7">
                <div class="align-items-center d-flex flex-row me-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="active" name="active_c"
                               @if(isset($offer))
                                   @checked($offer->active == 1)
                                   @if($offer->active)
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
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <div class="align-items-center d-flex flex-row me-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="wheel" name="wheel_c"
                               @if(isset($offer))
                                   @checked($offer->wheel == 1)
                                   @if($offer->wheel)
                                       value="on"
                               @else
                                   value="off"
                               @endif

                               @else
                                   value="off"
                            @endif>
                        <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                               for="status">  {{ __('Wheel') }}</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="vat" name="vat_c"
                        @isset($offer)
                            @checked($offer->vat == 1)

                            @endisset>
                        <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                               for="status">  {{ __('VAT') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Owner Name') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="owner_name" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->owner_name: '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Owner Email') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="owner_email" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->owner_email : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Owner Mobile') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="owner_mobile" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->owner_mobile : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="separator separator-dashed mb-3"></div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Manager Name') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="manager_name" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->manager_name: '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Manager Social') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="manager_social" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->manager_social : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Manager Email') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="manager_email" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->manager_email : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Manager Mobile') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="mobile" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->mobile : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="separator separator-dashed mb-3"></div>

        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Tiktok') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="tiktok" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->tiktok : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Facebook') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="facebook" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->facebook : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Instagram') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="instagram" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->instagram : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="separator separator-dashed mb-3"></div>

        <div class="col-md-4">
            <div class="fv-row mb-4">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2">{{__('Marketing Type')}}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="type_id" id="category" data-placeholder="Select an option">
                    <option></option>
                    @foreach ($TYPES as $t)
                        <option value="{{ $t->id }}"
                        @if (isset($offer))
                            @selected($offer->type_id ==$t->id)
                            @endif>
                            {{ $t->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Marketing_Name') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="marketing_name" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->marketing_name : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Marketing_Cost') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="marketing_cost" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($offer) ? $offer->marketing_cost : '' }}"/>
                <!--end::Input-->
            </div>
        </div>


    </div>
</div>






