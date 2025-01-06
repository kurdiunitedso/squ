@extends('metronic.index')


@section('title', 'Call-' . 'Add new Call')
@section('subpageTitle', 'Call')
@section('subpageName', 'Add new Call')


@section('content')
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span
                    class="path2"></span></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">Something went wrong!</h4>
                <span>Please check your inputs, the error messages are :.</span>
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
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                          fill="currentColor"/>
                    <path
                        d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                        fill="currentColor"/>
                </svg>
            </span>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-success"> {{ session('status') }}</h4>
            </div>
        </div>
    @endif
    <!--begin::Content container-->
    <div class="card mb-5 mb-xl-5" id="kt_clientCallAction_form_tabs">
        <div class="card-body pt-0 pb-0">
            <div class="d-flex flex-column flex-lg-row justify-content-between">
                <!--begin::Navs-->
                <ul id="myTab"
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold order-lg-1 order-2">

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_1" href="#kt_tab_pane_1">
                            <span class="svg-icon svg-icon-2 me-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 20C6 20.6 5.6 21 5 21C4.4 21 4 20.6 4 20H6ZM18 20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20H18Z"
                                        fill="currentColor"/>
                                    <path opacity="0.3"
                                          d="M21 20H3C2.4 20 2 19.6 2 19V3C2 2.4 2.4 2 3 2H21C21.6 2 22 2.4 22 3V19C22 19.6 21.6 20 21 20ZM12 10H10.7C10.5 9.7 10.3 9.50005 10 9.30005V8C10 7.4 9.6 7 9 7C8.4 7 8 7.4 8 8V9.30005C7.7 9.50005 7.5 9.7 7.3 10H6C5.4 10 5 10.4 5 11C5 11.6 5.4 12 6 12H7.3C7.5 12.3 7.7 12.5 8 12.7V14C8 14.6 8.4 15 9 15C9.6 15 10 14.6 10 14V12.7C10.3 12.5 10.5 12.3 10.7 12H12C12.6 12 13 11.6 13 11C13 10.4 12.6 10 12 10Z"
                                          fill="currentColor"/>
                                    <path
                                        d="M18.5 11C18.5 10.2 17.8 9.5 17 9.5C16.2 9.5 15.5 10.2 15.5 11C15.5 11.4 15.7 11.8 16 12.1V13C16 13.6 16.4 14 17 14C17.6 14 18 13.6 18 13V12.1C18.3 11.8 18.5 11.4 18.5 11Z"
                                        fill="currentColor"/>
                                </svg>
                            </span>
                            {{__('Call')}}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5" data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_3" id="history_tab" href="#kt_tab_pane_3">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Calls History')}}  </a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->

                </ul>

                <div class="d-flex my-4 justify-content-end order-lg-2 order-1">
                    <a href="{{ route('client_calls_actions.index') }}" class="btn btn-sm btn-light me-2"
                       id="kt_user_follow_button">
                        <!--begin::Indicator label-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                      rx="10" fill="currentColor"/>
                                <rect x="7" y="15.3137" width="12" height="2" rx="1"
                                      transform="rotate(-45 7 15.3137)" fill="currentColor"/>
                                <rect x="8.41422" y="7" width="12" height="2" rx="1"
                                      transform="rotate(45 8.41422 7)" fill="currentColor"/>
                            </svg>
                        </span>
                        Exit
                    </a>

                    <a href="#" class="btn btn-sm btn-primary ms-5" data-kt-clientCallAction-action="submit">
                        <span class="indicator-label">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                          rx="10" fill="currentColor"/>
                                    <path
                                        d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                                        fill="currentColor"/>
                                </svg>
                            </span>
                            Save Form</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </a>
                </div>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Content container-->
    <!--begin::Modal - Add task-->

    <form class="tab-content" id="myTabContent" method="post"
          action="{{ route('client_calls_actions.ClientCall', ['Id' => isset($clientCallAction) ? $clientCallAction->id : '']) }}?{{ isset($client) ? 'client_id=' . $client->id : '' }}">
        @csrf
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_client_details_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Call Details')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">
                        <div class="col-md-3">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2"
                                       data-input-name="Client Name">{{__('Name')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="client_name"
                                       class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                       value="{{ isset($clientCallAction) ? $clientCallAction->client_name : '' }}"/>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2"
                                       data-input-name="Client Name">{{__('Name Ar')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="client_name_ar"
                                       class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                       value="{{ isset($clientCallAction) ? $clientCallAction->client_name_ar : '' }}"/>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2"
                                       data-input-name="ID">{{__('ID')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="client_sid"
                                       class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                       value="{{ isset($clientCallAction) ? $clientCallAction->client_sid : '' }}"/>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2"
                                       data-input-name="Call Telephone">{{__('Telephone')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="telephone" name="call_telephone"
                                       class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                       value="{{ isset($clientCallAction) ? $clientCallAction->telephone : '' }}"/>
                                <!--end::Input-->
                            </div>
                        </div>
                        @if(isset($clientCallAction))
                            <div class="col-md-3">
                                <a id="viewBranches"
                                   href="#"
                                   class="mt-2 btn btn-sm btn-active-light btn-active-color-primary {{ isset($clientCallAction->telephone) ? '' : ' d-none' }} ">
                                    <span class="indicator-label">
                                       <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/ecommerce/ecm004.svg-->
<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3" d="M18 10V20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20V10H18Z" fill="currentColor"/>
<path opacity="0.3" d="M11 10V17H6V10H4V20C4 20.6 4.4 21 5 21H12C12.6 21 13 20.6 13 20V10H11Z" fill="currentColor"/>
<path opacity="0.3" d="M10 10C10 11.1 9.1 12 8 12C6.9 12 6 11.1 6 10H10Z" fill="currentColor"/>
<path opacity="0.3" d="M18 10C18 11.1 17.1 12 16 12C14.9 12 14 11.1 14 10H18Z" fill="currentColor"/>
<path opacity="0.3" d="M14 4H10V10H14V4Z" fill="currentColor"/>
<path opacity="0.3" d="M17 4H20L22 10H18L17 4Z" fill="currentColor"/>
<path opacity="0.3" d="M7 4H4L2 10H6L7 4Z" fill="currentColor"/>
<path
    d="M6 10C6 11.1 5.1 12 4 12C2.9 12 2 11.1 2 10H6ZM10 10C10 11.1 10.9 12 12 12C13.1 12 14 11.1 14 10H10ZM18 10C18 11.1 18.9 12 20 12C21.1 12 22 11.1 22 10H18ZM19 2H5C4.4 2 4 2.4 4 3V4H20V3C20 2.4 19.6 2 19 2ZM12 17C12 16.4 11.6 16 11 16H6C5.4 16 5 16.4 5 17C5 17.6 5.4 18 6 18H11C11.6 18 12 17.6 12 17Z"
    fill="currentColor"/>
</svg>
</span>
                                        <!--end::Svg Icon-->
                                      Restaurant Branches ({{\App\Models\RestaurantBranch::where(DB::raw('RIGHT(telephone,9)'),'like','%'.substr($clientCallAction->telephone,-9).'%')->count()}})
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>

                                </a>

                            </div>


                            <div class="col-md-3">
                                <a id="viewCaptines"
                                   href="#"
                                   class="mt-2 btn btn-sm btn-active-light btn-active-color-primary {{ isset($clientCallAction->telephone) ? '' : ' d-none' }} ">
                                    <span class="indicator-label">
                                       <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/ecommerce/ecm004.svg-->
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/communication/com014.svg-->
<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
<path
    d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
    fill="currentColor"/>
<rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
<path
    d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
    fill="currentColor"/>
<rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
</svg>
</span>
                                        <!--end::Svg Icon-->

                                        <!--end::Svg Icon-->
                                       Captains ({{\App\Models\Captin::where(DB::raw('RIGHT(mobile1,9)'),'like','%'.substr($clientCallAction->telephone,-9).'%')->orwhere(DB::raw('RIGHT(mobile2,9)'),'like','%'.substr($clientCallAction->telephone,-9).'%')->count()}})
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>

                                </a>

                            </div>
                        @endif

                        <div class="col-md-3">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name=" Call Status">
                                    Call Status
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="call_status" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($call_statuss as $c)
                                        <option value="{{ $c->id }}"
                                        @isset($clientCallAction)
                                            @selected($clientCallAction->call_status == $c->id)
                                            @endisset>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="call_option_id">
                                    Call Option
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="call_option_id" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($CALL_OPTION_TYPES as $c)
                                        <option value="{{ $c->id }}"
                                        @isset($clientCallAction)
                                            @selected($clientCallAction->call_option_id == $c->id)
                                            @endisset>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="caller_type">
                                    Caller Type
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="caller_type" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($caller_types as $c)
                                        <option value="{{ $c->id }}"
                                        @isset($clientCallAction)
                                            @selected($clientCallAction->caller_type == $c->id)
                                            @endisset>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="city_id">
                                    City
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="city_id" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c->id }}"
                                        @isset($clientCallAction)
                                            @selected($clientCallAction->city_id == $c->id)
                                            @endisset>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="assign_employee">
                                    Assign Employee
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="assign_employee" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($employees as $c)
                                        <option value="{{ $c->id }}"
                                        @isset($clientCallAction)
                                            @selected($clientCallAction->assign_employee == $c->id)
                                            @endisset>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="assign_status">
                                    Assign Status
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="assign_status" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($assign_statuss as $c)
                                        <option value="{{ $c->id }}"
                                        @isset($clientCallAction)
                                            @selected($clientCallAction->assign_status == $c->id)
                                            @endisset>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2" data-input-name="urgency">
                                    Urgency
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="urgency" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($urgencys as $c)
                                        <option value="{{ $c->id }}"
                                        @isset($clientCallAction)
                                            @selected($clientCallAction->urgency == $c->id)
                                            @endisset>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Notes</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea class="form-control form-control-solid mb-3 mb-lg-0"
                                          name="call_notes">{{ isset($clientCallAction) ? $clientCallAction->notes : '' }}</textarea>
                                <!--end::Input-->
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_client_details_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Calls History</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @if($clientCallAction)
                        @include('clientCallActions.history.index')
                    @endif
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </form>
    <div class="modal fade" id="kt_modal_view_branch" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_view_captin" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
@endsection

@push('scripts')
    <script>
        var validator;
        const form = document.getElementById('myTabContent');
        $(function () {

            var tabContentEl = document.querySelector("#myTabContent");
            var tabContentElblockUI = new KTBlockUI(tabContentEl, {
                message: '<div class="bg-white blockui-message position-absolute" style="top:25px;"><span class="spinner-border text-primary"></span> Loading...</div>',
            });


            $(document).on('select2:clear', '#client_id', function (e) {
                tabContentElblockUI.block()
                var url = "{{ route('client_calls_actions.create') }}";
                window.location = url;
            });

            const kt_modal_view_branch = document.getElementById('kt_modal_view_branch');
            const modal_kt_modal_view_branch = new bootstrap.Modal(kt_modal_view_branch);

            $(document).on('click', '#viewBranches', function (e) {

                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                renderModal(
                    "{{ isset($clientCallAction->telephone) ? route('restaurants.getByTelephone', ['telephone' => $clientCallAction->telephone]) : '#' }}",
                    $(this), '#kt_modal_view_branch',
                    modal_kt_modal_view_branch);
            });

            const kt_modal_view_captin = document.getElementById('kt_modal_view_captin');
            const modal_kt_modal_view_captin = new bootstrap.Modal(kt_modal_view_captin);

            $(document).on('click', '#viewCaptines', function (e) {

                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                renderModal(
                    "{{ isset($clientCallAction->telephone) ? route('captins.getByTelephone', ['telephone' => $clientCallAction->telephone]) : '#' }}",
                    $(this), '#kt_modal_view_captin',
                    modal_kt_modal_view_captin);
            });

            renderValidate();
        });

        function renderModal(url, button, modalId, modalBootstrap) {


            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    $(modalId).find('.modal-dialog').html(response.createView);
                    modalBootstrap.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();
                },
                complete: function () {
                    if (button) {
                        button.removeAttr('data-kt-indicator');
                    }
                }
            });
        }

        function renderSelect2() {

            $('[data-control="select2"]').select2();


        }


        function renderValidate() {


            // Log the list of registered plugins

            validator = FormValidation.formValidation(
                form, {
                    fields: {},
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            validator.on('core.form.invalid', function (event) {
                const fields = validator.getFields();
                $.each(fields, function (element) {
                    validator.validateField(element)
                        .then(function (status) {
                            // status can be one of the following value
                            // 'NotValidated': The element is not yet validated
                            // 'Valid': The element is valid
                            // 'Invalid': The element is invalid
                            if (status == 'Invalid')
                                console.log(element);
                        });
                });
            });


            const RequiredInputList = {
                'client_name': 'input',
                'call_telephone': 'input',
                'call_option_id': 'select',
                'call_notes': 'input'
            }


            for (var key in RequiredInputList) {
                // console.log("key " + key + " has value " + RequiredInputList[key]);
                var fieldName = $(RequiredInputList[key] + ["[name=" + key + "]"]).closest(".fv-row").find(
                    "label[data-input-name]").attr('data-input-name');

                const NameValidators = {
                    validators: {
                        notEmpty: {
                            message: fieldName + ' is required',
                        },
                    },
                };

                validator.addField(key, NameValidators);
                // validator.addField($(this).find('.constantNames').attr('name'),
                //                         NameValidators);
            }

            const submitButton = document.querySelector('[data-kt-clientCallAction-action="submit"]');
            submitButton.addEventListener('click', function (e) {

                // Prevent default button action
                e.preventDefault();

                var form = $("#myTabContent");
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function (status) {
                        console.log('validated!');
                        if (status == 'Valid') {
                            console.log('valid!');
                            form.submit();
                        } else {
                            Swal.fire({
                                text: "Sorry, looks like there are you missed some required fields, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    })
                }
            });


        }
    </script>
@endpush
