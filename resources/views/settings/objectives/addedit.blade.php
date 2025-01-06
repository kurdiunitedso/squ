@php
    use App\Models\Contract;
    use App\Models\ClientTrillion;
    use App\Models\ContractItem;
@endphp
@extends('metronic.index')


@section('subpageTitle', $item_model::ui['p_ucf'])

@section('title', t($item_model::ui['s_ucf'] . '- Add new ' . $item_model::ui['s_ucf']))
@section('subpageTitle', $item_model::ui['s_ucf'])
@section('subpageName', 'Add new ' . $item_model::ui['s_ucf'])

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span
                    class="path2"></span></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">{{ t('Something went wrong!') }}</h4>
                <span>{{ t('Please check your inputs, the error messages are :.') }}</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
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
                <h4 class="mb-1 text-success"> {{ session('status') }}</h4>
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
                            data-bs-target="#kt_tab_pane_1" href="#kt_tab_pane_1">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t($item_model::ui['s_ucf']) }}
                        </a>
                    </li>





                </ul>


            </div>
            <div class="d-flex my-4 justify-content-end order-lg-2 order-1">

                <a href="{{ route('settings.' . $item_model::ui['route'] . '.index') }}" class="btn btn-sm btn-light me-2"
                    id="kt_user_follow_button">
                    <span class="svg-icon svg-icon-2">
                        <!-- SVG content remains unchanged -->
                    </span>
                    {{ __('Exit') }}
                </a>
                <a href="#" class="btn btn-sm btn-primary" data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit">
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

    <form class="tab-content" id="{{ $item_model::ui['s_lcf'] }}_form" method="post"
        action="{{ route('settings.' . $item_model::ui['route'] . '.store') }}">
        @csrf
        @if ($item_model->exists)
            <input type="hidden" name="{{ $item_model::ui['_id'] }}" value="{{ $item_model->id }}">
        @endif
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ t($item_model::ui['s_ucf'] . ' Details') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                @include('settings.' . $item_model::ui['route'] . '.form')
                <!--end::Card body-->
            </div>

        </div>


    </form>

    <div class="modal fade" id="kt_modal_general" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>

@endsection

@push('scripts')
    <script>
        renderValidate('#{{ $item_model::ui['s_lcf'] }}_form',
            '[data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit"]');
    </script>
@endpush
