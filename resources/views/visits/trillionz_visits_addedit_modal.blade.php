<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_visit_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{ __('Add Visit') }}</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>
    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-5">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_visit_form" class="form" data-editMode="{{ isset($visit) ? 'enabled' : 'disabled' }}"
            action="{{ isset($visit) ? route('visits.update', ['visit' => $visit->id]) : route('visits.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_visit_scroll" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_modal_add_visit_header"
                data-kt-scroll-wrappers="#kt_modal_add_visit_scroll" data-kt-scroll-offset="300px">
                <!--begin::Input group-->
                @isset($visitRequest)
                    <input type="hidden" name="visit_request_id" value="{{ $visitRequest->id }}">
                @endisset
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <div class="align-items-center d-flex flex-row me-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="active"
                                        name="active_c"
                                        @if (isset($lead)) @checked($lead->active == 1)
                                               @if ($lead->active)
                                                   value="on"
                                           @else
                                               value="off" @endif
                                    @else value="off" @endif>
                                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                                        for="status"> {{ __('Active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <div class="align-items-center d-flex flex-row me-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="wheel"
                                        name="wheel_c"
                                        @if (isset($lead)) @checked($lead->wheel == 1)
                                               @if ($lead->wheel)
                                                   value="on"
                                           @else
                                               value="off" @endif
                                    @else value="off" @endif>
                                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                                        for="status"> {{ __('Wheel') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <div class="align-items-center d-flex flex-row me-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="has_agency"
                                        name="has_agency_c"
                                        @if (isset($lead)) @checked($lead->has_agency == 1)
                                               @if ($lead->has_agency)
                                                   value="on"
                                           @else
                                               value="off" @endif
                                    @else value="off" @endif>
                                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                                        for="status"> {{ __('Has Agency') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <div class="align-items-center d-flex flex-row me-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="intersted"
                                        name="intersted_c"
                                        @if (isset($lead)) @checked($lead->intersted == 1)
                                               @if ($lead->intersted)
                                                   value="on"
                                           @else
                                               value="off" @endif
                                    @else value="off" @endif>
                                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                                        for="status"> {{ __('Is interested') }}</label>
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
                            <input type="text" name="owner_name"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required" placeholder=""
                                value="{{ isset($lead) ? $lead->owner_name : '' }}" />
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
                            <input type="text" name="owner_email"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-email" placeholder=""
                                value="{{ isset($lead) ? $lead->owner_email : '' }}" />
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
                            <input type="text" name="owner_mobile"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required" placeholder=""
                                value="{{ isset($lead) ? $lead->owner_mobile : '' }}" />
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
                            <input type="text" name="manager_name"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                value="{{ isset($lead) ? $lead->manager_name : '' }}" />
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
                            <input type="text" name="manager_social"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                value="{{ isset($lead) ? $lead->manager_social : '' }}" />
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
                            <input type="text" name="manager_email"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-email" placeholder=""
                                value="{{ isset($lead) ? $lead->manager_email : '' }}" />
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
                                placeholder="" value="{{ isset($lead) ? $lead->mobile : '' }}" />
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
                                placeholder="" value="{{ isset($lead) ? $lead->tiktok : '' }}" />
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
                            <input type="text" name="facebook"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                value="{{ isset($lead) ? $lead->facebook : '' }}" />
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
                            <input type="text" name="instagram"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                value="{{ isset($lead) ? $lead->instagram : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="separator separator-dashed mb-3"></div>

                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{ __('Marketing Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                name="type_id" id="category" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($TYPES as $t)
                                    <option value="{{ $t->id }}"
                                        @if (isset($lead)) @selected($lead->type_id == $t->id) @endif>
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
                            <input type="text" name="marketing_name"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                value="{{ isset($lead) ? $lead->marketing_name : '' }}" />
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
                            <input type="text" name="marketing_cost"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-number validate-min-0"
                                placeholder="" value="{{ isset($lead) ? $lead->marketing_cost : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="separator separator-dashed mb-3"></div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Lat') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="lat" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="" value="{{ isset($lead) ? $lead->lat : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Long') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="long" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="" value="{{ isset($lead) ? $lead->long : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>



                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
            </div>


            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-visit-modal-action="cancel"
                    data-bs-dismiss="modal">{{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-visit-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">{{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>

        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
