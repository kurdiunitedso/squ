@extends('metronic.index')

@section('title', $_model::ui['p_ucf'])
@section('subpageTitle', $_model::ui['p_ucf'])

@section('content')
    <!--begin::Content container-->
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
                            <input type="text" data-col-index="search" data-kt-table-filter="search"
                                class="form-control datatable-input form-control-solid w-250px ps-14"
                                placeholder="{{ t('Search ' . $_model::ui['s_ucf']) }}" />
                            <input type="hidden" name="selectedCaptin">
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-nationalities-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::policyOffers 1-->
                            <!--end::policyOffers 1-->
                            <!--end::Filter-->
                            <!--begin::Add policyOffers-->
                            <a href="{{ route($_model::ui['route'] . '.create') }}" class="btn btn-primary"
                                id="btnAdd{{ $_model::ui['s_lcf'] }}">
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
                            <!--end::Add policyOffers-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->

                        <!--end::Modal - Add task-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                        id="kt_table_{{ $_model::ui['s_lcf'] }}">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px bold all">{{ __('SN') }}</th>
                                <th class="min-w-100px bold all">{{ t('Name') }}</th>
                                <th class="min-w-100px bold all">{{ t('Description') }}</th>
                                <th class="min-w-100px bold all">{{ t('Price') }}</th>
                                <th class="min-w-100px bold all">{{ t('Active') }}</th>
                                <th class="min-w-200px bold all">{{ __('Actions') }}</th>

                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content container-->


@endsection


@push('scripts')
    @include($_view_path . '.scripts.datatableJS')
    @include($_view_path . '.scripts.btnsJS')
@endpush