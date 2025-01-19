@php
    use App\Models\Apartment;
    use App\Models\AddOn;
    use App\Models\ApartmentAddOn;
@endphp


<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_item_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ t('Add ' . ApartmentAddOn::ui['s_ucf']) }}</h2>
        <!--end::Modal preparation_time-->
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
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="{{ ApartmentAddOn::ui['s_lcf'] }}_modal_form" class="form"
            action="{{ route(Apartment::ui['route'] . '.' . $_model::ui['route'] . '.addedit', ['apartment' => $apartment->id]) }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_item_scroll" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_modal_add_item_header"
                data-kt-scroll-wrappers="#kt_modal_add_item_scroll" data-kt-scroll-offset="300px">
                @if (isset($_model))
                    <input type="hidden" name="{{ ApartmentAddOn::ui['_id'] }}" value="{{ $_model->id }}">
                @endif
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2"
                                data-input-name="Item">{{ t('Add On') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0 validate-required"
                                data-control="select2" name="{{ ApartmentAddOn::ui['s_lcf'] . '_' . AddOn::ui['_id'] }}"
                                data-placeholder="Select an option">
                                <option></option>
                                @foreach ($active_add_on_list as $i)
                                    <option value="{{ $i->id }}" price="{{ $i->price }}"
                                        @isset($_model)
                                        @selected($_model->add_on_id == $i->id)
                                        @endisset>
                                        {{ $i->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2 ">{{ t('Notes') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="{{ ApartmentAddOn::ui['s_lcf'] . '_notes' }}" id="text" rows="4"
                                class="form-control form-control-solid mb-3 mb-lg-0">{{ isset($_model) ? $_model->notes : '' }}</textarea>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2 ">{{ t('Cost') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="{{ ApartmentAddOn::ui['s_lcf'] }}_cost"
                                id="{{ ApartmentAddOn::ui['s_lcf'] }}_cost"
                                class="form-control form-control-solid calculation mb-3 mb-lg-0 validate-required validate-number validate-min-1"
                                placeholder="" value="{{ isset($_model) ? $_model->cost : '0' }}" />
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('Qty') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="{{ ApartmentAddOn::ui['s_lcf'] }}_qty"
                                id="{{ ApartmentAddOn::ui['s_lcf'] }}_qty"
                                class="form-control form-control-solid calculation mb-3 mb-lg-0 validate-required validate-number validate-min-1"
                                placeholder="" value="{{ isset($_model) ? $_model->qty : '1' }}" />
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Discount') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="{{ ApartmentAddOn::ui['s_lcf'] }}_discount"
                                id="{{ ApartmentAddOn::ui['s_lcf'] }}_discount"
                                class="form-control text-danger calculation form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0"
                                placeholder="" value="{{ isset($_model) ? $_model->discount : '0' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Total_Cost') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="{{ ApartmentAddOn::ui['s_lcf'] }}_total_cost"
                                id="{{ ApartmentAddOn::ui['s_lcf'] }}_total_cost" value="0">
                            <h1 class="text-primary  mb-3 mb-lg-0"
                                id="{{ ApartmentAddOn::ui['s_lcf'] }}_total_cost_h1">
                                {{ isset($_model) ? $_model->total_cost : '0' }}</h1>
                            <!--end::Input-->
                        </div>
                    </div>

                </div>

                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="button" class="btn btn-light me-3" data-kt-contract_item-modal-action="cancel"
                    data-bs-dismiss="modal">
                    {{ __('Discard') }}
                </button>
                <button item="submit" class="btn btn-primary"
                    data-kt-modal-action="submit{{ $_model::ui['s_lcf'] }}">
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
