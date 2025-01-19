@php
    use App\Models\AddOn;
    use App\Models\ApartmentAddOn;
@endphp
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->

                        <input type="text" data-kt-{{ ApartmentAddOn::ui['s_lcf'] }}-table-filter="search"
                            data-col-index="search" {{-- data-kt-teams-table-filter="search" --}}
                            class="form-control form-control-solid w-250px ps-14 datatable-input"
                            placeholder="Search {{ ApartmentAddOn::ui['p_ucf'] }}" />


                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-items-table-toolbar="base">
                        <!--begin::Filter-->
                        <!--begin::offers 1-->
                        <!--end::offers 1-->
                        <!--end::Filter-->
                        <!--begin::Add offers-->
                        <a href="{{ route($_model::ui['route'] . '.' . ApartmentAddOn::ui['route'] . '.create', ['apartment' => $_model->id]) }}"
                            class="btn btn-primary" id="add_{{ ApartmentAddOn::ui['s_lcf'] }}_modal">
                            <span class="indicator-label">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                            rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                {{ __('Add') }}
                            </span>
                            <span class="indicator-progress">
                                {{ t('Please wait...') }} <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </a>
                        <!--end::Add offers-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Modal - Add task-->

                    <!--end::Modal - Add task-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->

            <div class="card-body py-4">
                <!--begin::Table-->


                <div class="row">

                    <div class="row">
                        {{--
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Discount') }}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" name="apartment_total_discount"
                                    style="font-size: 40px;color: red; text-align: center" id="apartment_total_discount"
                                    class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0"
                                    placeholder="" value="{{ isset($_model) ? $_model->total_discount : 0 }}" />
                                <!--end::Input-->
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Total Cost') }}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" name="add_ons_total_cost" id="add_ons_total_cost" disabled
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                    style="font-size: 40px;color: blue; text-align: center"
                                    value="{{ isset($_model) ? $_model->add_ons_total_cost : '' }}" />
                                <!--end::Input-->
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                        id="kt_table_{{ ApartmentAddOn::ui['s_lcf'] }}">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px bold all">{{ __('SN') }}</th>
                                <th class="min-w-100px bold all">{{ t('Name') }}</th>
                                <th class="min-w-125px">{{ __('Notes') }}</th>
                                <th class="min-w-125px">{{ __('Cost') }}</th>
                                <th class="min-w-125px">{{ __('Qty') }}</th>
                                <th class="min-w-125px">{{ __('Discount') }}</th>
                                <th class="min-w-125px">{{ __('Total Cost') }}</th>
                                <th class="min-w-200px bold all">{{ __('Actions') }}</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>

@push('scripts')

    @if ($_model->exists())
        @include(ApartmentAddOn::ui['view'] . 'scripts.datatableJS')
        @include(ApartmentAddOn::ui['view'] . 'scripts.btnsJS')
        {{-- @include(ApartmentAddOn::ui['view'] . 'scripts.textFieldsJS') --}}
    @endif

@endpush
