@php
    use App\Models\Lead;
    use App\Models\Client;
    use App\Models\Apartment;
    use App\Models\AddOn;
    use App\Models\Sale;
    use App\Models\Payment;
@endphp
@extends('metronic.index')


@section('subpageTitle', $_model::ui['p_ucf'])

@section('title', t($_model::ui['s_ucf'] . '- Add new ' . $_model::ui['s_ucf']))
@section('subpageTitle', $_model::ui['s_ucf'])
@section('subpageName', 'Add new ' . $_model::ui['s_ucf'])
@push('styles')
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@section('content')
    {{-- Show any validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">{{ t('Something went wrong!') }}</h4>
                <span>{{ t('Please check your inputs:') }}</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Show success message --}}
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center p-5">
            <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                    <path
                        d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-success">{{ session('status') }}</h4>
            </div>
        </div>
    @endif

    {{-- Show single error message --}}
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center p-5">
            <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3"
                        d="M12 10.6L14.8 7.8C15.2 7.4 15.8 7.4 16.2 7.8C16.6 8.2 16.6 8.80002 16.2 9.20002L13.4 12L16.2 14.8C16.6 15.2 16.6 15.8 16.2 16.2C15.8 16.6 15.2 16.6 14.8 16.2L12 13.4L9.2 16.2C8.8 16.6 8.2 16.6 7.8 16.2C7.4 15.8 7.4 15.2 7.8 14.8L10.6 12L7.8 9.2C7.4 8.8 7.4 8.2 7.8 7.8C8.2 7.4 8.8 7.4 9.2 7.8L12 10.6Z"
                        fill="currentColor" />
                </svg>
            </span>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">{{ session('error') }}</h4>
            </div>
        </div>
    @endif
    <!--begin::Content container-->
    <div class="card mb-5 mb-xl-5" id="kt_department_form_tabs">
        <div class="card-body pt-0 pb-0">
            <div class="d-flex flex-column flex-lg-row justify-content-between">
                <!--begin::Navs-->
                <ul id="myTab"
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold order-lg-1 order-2">
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_{{ Client::ui['s_lcf'] }}"
                            href="#kt_tab_pane_{{ Client::ui['s_lcf'] }}">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t(Client::ui['s_ucf']) }}
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 " data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_{{ Apartment::ui['s_lcf'] }}"
                            href="#kt_tab_pane_{{ Apartment::ui['s_lcf'] }}">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t(Apartment::ui['s_ucf'] . ' Out') }}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 " data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_{{ AddOn::ui['s_lcf'] }}"
                            href="#kt_tab_pane_{{ AddOn::ui['s_lcf'] }}">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t(AddOn::ui['p_ucf']) }}
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 " data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_{{ Sale::ui['s_lcf'] }}"
                            href="#kt_tab_pane_{{ Sale::ui['s_lcf'] }}">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t($_model::ui['s_ucf']) }}
                        </a>
                    </li>


                    @if (!$_model->hasPaymentPlan())
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5" data-bs-toggle="tab"
                                data-bs-target="#kt_tab_pane_payment_plan" href="#kt_tab_pane_payment_plan">
                                <span class="svg-icon svg-icon-2 me-2">
                                </span>
                                {{ t('Create Payment Plan') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5" data-bs-toggle="tab"
                                data-bs-target="#kt_tab_pane_{{ 'payments_overview' }}"
                                href="#kt_tab_pane_{{ 'payments_overview' }}">
                                <span class="svg-icon svg-icon-2 me-2">
                                </span>
                                {{ t('Payments Overview') }}
                            </a>
                        </li>
                    @endif




                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_7" href="#kt_tab_pane_7">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('Attachments') }} </a>
                    </li>
                    {{--
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_history" href="#kt_tab_pane_history">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('History') }} </a>
                    </li> --}}


                    <!--end::Nav item-->
                    <!--begin::Nav item-->

                </ul>


            </div>
            <div class="d-flex my-4 justify-content-end order-lg-2 order-1">

                <a href="{{ route($_model::ui['route'] . '.index') }}" class="btn btn-sm btn-light me-2"
                    id="kt_user_follow_button">
                    <span class="svg-icon svg-icon-2">
                        <!-- SVG content remains unchanged -->
                    </span>
                    {{ __('Exit') }}
                </a>
                <a href="#" class="btn btn-sm btn-primary" data-kt-{{ $_model::ui['s_lcf'] }}-action="submit">
                    <span class="indicator-label">
                        <span class="svg-icon svg-icon-2">
                            <!-- SVG content remains unchanged -->
                        </span>
                        {{ __('Save Form') }}
                    </span>
                    <span class="indicator-progress">
                        {{ __('Please wait...') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </a>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Content container-->
    <!--begin::Modal - Add task-->

    <form class="tab-content" id="{{ $_model::ui['s_lcf'] }}_form" method="post"
        action="{{ route($_model::ui['route'] . '.addedit') }}">
        @csrf
        @if ($_model->exists)
            <input type="hidden" name="{{ $_model::ui['_id'] }}" value="{{ $_model->id }}">
        @endif
        @isset(request()->price_offer)
            <input type="hidden" name="price_offer_id" value="{{ request()->price_offer }}">
        @endisset
        <div class="tab-pane fade show active" id="kt_tab_pane_{{ Client::ui['s_lcf'] }}" role="tabpanel">
            @include($_model::ui['view'] . 'tabs.client', [
                '_model' => $_model->client,
            ])


        </div>
        <div class="tab-pane fade show" id="kt_tab_pane_{{ Apartment::ui['s_lcf'] }}" role="tabpanel">
            @include($_view_path . '.tabs.apartment')
        </div>

        <div class="tab-pane fade show" id="kt_tab_pane_{{ AddOn::ui['s_lcf'] }}" role="tabpanel">
            @include(Apartment::ui['view'] . '.tabs.add_ons.index', [
                '_model' => $_model->apartment ?? null,
            ])

        </div>

        <div class="tab-pane fade show " id="kt_tab_pane_{{ Sale::ui['s_lcf'] }}" role="tabpanel">
            @include($_view_path . '.tabs.form')



        </div>

        @if ($_model->exists)
            @if (!$_model->hasPaymentPlan())
                <div class="tab-pane fade " id="kt_tab_pane_payment_plan" role="tabpanel">
                    @include('CP.sales.tabs.payment_plan_tab')
                </div>
            @else
                <div class="tab-pane fade " id="kt_tab_pane_{{ 'payments_overview' }}" role="tabpanel">
                    @include('CP.sales.tabs.payment_tab')
                </div>
            @endif

        @endif


        <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_attachments_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{ t('Attachments') }}
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @if ($_model->exists)
                        @include('CP.attachments.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>


    </form>


@endsection

@push('scripts')
    <script>
        // Initialize the form handler
        document.addEventListener('DOMContentLoaded', () => {
            RegularFormHandler.initialize(
                '#{{ $_model::ui['s_lcf'] }}_form',
                '[data-kt-{{ $_model::ui['s_lcf'] }}-action="submit"]'
            );
        });
    </script>
    @include($_view_path . '.scripts.addeditJS')
@endpush
