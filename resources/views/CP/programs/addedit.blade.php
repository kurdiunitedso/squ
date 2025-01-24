@php
    use App\Models\ProgramPage;

@endphp
@extends('CP.metronic.index')


@section('subpageTitle', $_model::ui['p_ucf'])
@section('subpageTitleLink', route($_model::ui['route'] . '.index'))

@section('title', t($_model::ui['s_ucf'] . ($_model->exists ? ' Edit ' : '- Add new ') . $_model::ui['s_ucf']))
@section('subpageTitle', $_model::ui['s_ucf'])
@section('subpageName', ($_model->exists ? ' Edit ' : '- Add new ') . $_model::ui['s_ucf'])
@push('styles')
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    @include('CP.partials.notification')

    <!--begin::Content container-->
    <div class="card mb-5 mb-xl-5" id="kt_department_form_tabs">
        <div class="card-body pt-0 pb-0">
            <div class="d-flex flex-column flex-lg-row justify-content-between">
                <!--begin::Navs-->
                <ul id="myTab"
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold order-lg-1 order-2">

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_1" href="#kt_tab_pane_1">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t($_model::ui['s_ucf']) }}
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 " data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_{{ ProgramPage::ui['s_lcf'] }}"
                            href="#kt_tab_pane_{{ ProgramPage::ui['s_lcf'] }}">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t(ProgramPage::ui['s_ucf']) }}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 " data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_application_setup" href="#kt_tab_pane_application_setup">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t('Application Setup') }}
                        </a>
                    </li>



                    <!--end::Nav item-->
                    <!--begin::Nav item-->

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_7" href="#kt_tab_pane_7">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('Attachments') }} </a>
                    </li>


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
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            @include($_view_path . '.tabs.form')
        </div>

        <div class="tab-pane fade show" id="kt_tab_pane_{{ ProgramPage::ui['s_lcf'] }}" role="tabpanel">
            @include($_model::ui['view'] . '.tabs.program-pages.index')

        </div>
        <div class="tab-pane fade show " id="kt_tab_pane_application_setup" role="tabpanel">
            {{-- @include($_view_path . '.tabs.application_setup') --}}
        </div>

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
