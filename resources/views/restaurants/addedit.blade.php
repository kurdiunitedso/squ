@extends('metronic.index')


@section('title', 'restaurant-' . 'Add new restaurant')
@section('subpageTitle', 'restaurant')
@section('subpageName', 'Add new restaurant')


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
    <div class="card mb-5 mb-xl-5" id="kt_restaurant_form_tabs">
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
                            {{__('Restaurant')}}
                        </a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5"
                           data-bs-toggle="tab" id="contact" data-bs-target="#kt_tab_pane_contact"
                           href="#kt_tab_pane_contact">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Contact')}} </a>
                    </li>
                    <li class="nav-item mt-2" id="tab2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5" data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_2" href="#kt_tab_pane_2">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Bank')}}  </a>
                    </li>


                    <li class="nav-item mt-2" id="tab3">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5  {{ isset($restaurant)&&$restaurant->has_marketing ? '' : 'd-none' }}"
                           data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_3" id="marketingTab" href="#kt_tab_pane_3">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Marketing')}} </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($restaurant)&&$restaurant->has_branch ? '' : 'd-none' }}  {{ isset($restaurant) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" id="branchTab" data-bs-target="#kt_tab_pane_6" href="#kt_tab_pane_6">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Branch')}} </a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($restaurant) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_4" href="#kt_tab_pane_4">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Employees')}} </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($restaurant) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_calls" href="#kt_tab_pane_calls">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Calls')}} </a>
                    </li>
                    <li class="nav-item mt-2" id="tabVisit">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5" data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_visits" href="#kt_tab_pane_visits">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Visits')}} </a>
                    </li>
                    <li class="nav-item mt-2" id="tabTicket">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5" data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_tickets" href="#kt_tab_pane_tickets">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Tickets')}} </a>
                    </li>


                 {{--   <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($restaurant) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_5" href="#kt_tab_pane_5">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Menu Items')}} </a>
                    </li>--}}

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($restaurant) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_7" href="#kt_tab_pane_7">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Attachments')}} </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($restaurant) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_8" href="#kt_tab_pane_8">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('History')}} </a>
                    </li>


                    <!--end::Nav item-->
                    <!--begin::Nav item-->

                </ul>


            </div>
            <div class="d-flex my-4 justify-content-end order-lg-2 order-1">
                @isset($restaurant)
                    <a href="#" id="AddvisitsModal"
                       url="{{route('visitRequests.create')}}?telephone={{$restaurant->telephone}}&visit_name={{$restaurant->name}}&visit_category=249"
                       class="btn btn-info me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <title>Stockholm-icons / Communication / Clipboard-check</title>
                            <desc>Created with Sketch.</desc>
                            <defs/>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path
                                    d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                    fill="currentColor"/>
                                <path
                                    d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z"
                                    fill="#000000"/>
                                <path
                                    d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                    fill="#000000"/>
                            </g>
                        </svg>
                        <span id="selectedRestaurantsRowsCount"></span>Visit Request</a>
                @endisset
                <a href="{{ route('restaurants.index') }}" class="btn btn-sm btn-light me-2"
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
                    {{__('Exit')}}
                </a>

                <a href="#" class="btn btn-sm btn-primary ms-5" data-kt-restaurant-action="submit">
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
                           {{__('Save Form')}} </span>
                    <span class="indicator-progress">
                             {{__('SPlease wait...')}} <span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                </a>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Content container-->
    <!--begin::Modal - Add task-->

    <form class="tab-content" id="myTabContent" method="post"
          action="{{ route('restaurants.addedit', ['Id' => isset($restaurant) ? $restaurant->id : '']) }}?{{ isset($restaurant) ? 'restaurant_id=' . $restaurant->id : '' }}">
        @csrf
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_restaurant_details_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Restaurant Details')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">
                        @include('restaurants.form')
                    </div>
                </div>


                <!--end::Card body-->
            </div>

            {{--   {!! $restaurantForm !!}--}}
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_bank_details_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Bank Details')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @include('restaurants.bank')

                </div>
                <!--end::Card body-->
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_calls" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_call_details_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Calls')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @include('restaurants.calls')

                </div>
                <!--end::Card body-->
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_contact" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_contact_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Contact')}} </h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @include('restaurants.contact')

                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_marketing_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Marketing')}} </h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @include('restaurants.marketing')

                </div>
                <!--end::Card body-->
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_employee_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Employee')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->

                <div class="card-body p-9">
                    @include('restaurants.employees.index')
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_menu_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Menu Item')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @include('restaurants.menuItems.index')
                </div>
                <!--end::Card body-->
            </div>
        </div>

        <div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_branch_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Branch')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @include('restaurants.branchs.index')
                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_attachments_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{__('Attachments')}}
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @if(isset($restaurant))
                        @include('restaurants.attachments.index')
                    @endif
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_tickets" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_tickets_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{__('Tickets')}}
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">


                    @include('restaurants.tickets')


                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_visits" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_visits_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{__('visits')}}
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">


                    @include('restaurants.visits')


                </div>
                <!--end::Card body-->
            </div>
        </div>

        <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_attachments_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{__('History')}}
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">


                    @include('restaurants.history.index')


                </div>
                <!--end::Card body-->
            </div>
        </div>

    </form>

    <div class="modal fade" id="kt_modal_add_employee" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_visits" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_tickets" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog  modal-lg  modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_menuItem" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_branch" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_showCalls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl table-responsive">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_attachment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>

@endsection

@push('scripts')
    <script>
        const kt_modal_showCalls = document.getElementById('kt_modal_showCalls');
        const modal_kt_modal_showCalls = new bootstrap.Modal(kt_modal_showCalls);

        $(document).on('click', '.viewCalls', function (e) {

            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var href = $(this).attr("href");
            renderModal(
                href,
                $(this), '#kt_modal_showCalls',
                modal_kt_modal_showCalls);
        });

    </script>
    <script>

        var validator;
        const form = document.getElementById('myTabContent');

        $(function () {

            var tabContentEl = document.querySelector("#myTabContent");
            var tabContentElblockUI = new KTBlockUI(tabContentEl, {
                message: '<div class="bg-white blockui-message position-absolute" style="top:25px;"><span class="spinner-border text-primary"></span> Loading...</div>',
            });
            $(document).on('click', '#has_branch_select', function (e) {
                // alert($('#has_branch').val());
                if ($('#has_branch').val() == 'on') {
                    $('#has_branch').val('off');
                    $('#branchTab').addClass('d-none');
                } else {
                    $('#has_branch').val('on');
                    $('#branchTab').removeClass('d-none');
                }
            });
            $(document).on('click', '#has_marketing_select', function (e) {
                if ($('#has_marketing').val() == 'on') {
                    $('#has_marketing').val('off');
                    $('#marketingTab').addClass('d-none');
                } else {
                    $('#has_marketing').val('on');
                    $('#marketingTab').removeClass('d-none');
                }
            });
            var dueDatebirth_date3 = $(form.querySelector('[name="join_date"]'));
            dueDatebirth_date3.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
            });
            renderValidate();

        });

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
                'type_id': 'select',
                'restaurant_id': 'input',
                /* 'has_branch': 'select',*/
                'has_pos': 'select',
                'has_call_center': 'select',
                'os_type': 'select',
                'need_internal_call_sys': 'select',
                'bank': 'select',
                'bank_name': 'select',
                // 'register_date': 'input',
                'name': 'input',

                // 'call_action_id': 'select',
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

            const submitButton = document.querySelector('[data-kt-restaurant-action="submit"]');
            submitButton.addEventListener('click', function (e) {
                // Prevent default button action
                e.preventDefault();

                var formAddEdit = $("#kt_modal_constant_form");
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
    <script>
        const kt_modal_visits = document.getElementById('kt_modal_visits');
        const modal_kt_modal_visits = new bootstrap.Modal(kt_modal_visits);

        const kt_modal_tickets = document.getElementById('kt_modal_tickets');
        const modal_kt_modal_tickets = new bootstrap.Modal(kt_modal_tickets);


        $(document).on('click', '#AddvisitsModal', function (e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var url = $(this).attr("url");

            renderAModal(url,
                $(this), '#kt_modal_visits',
                modal_kt_modal_visits,
                [],
                '#kt_modal_add_visit_form',
                datatable,
                '[data-kt-visit-modal-action="submit"]');


        });

    </script>
    <script>
        function renderAModal(url, button, modalId, modalBootstrap, validatorFields, formId, dataTableId,
                              submitButtonName, RequiredInputList = null, onFormSuccessCallBack = null, data_id = 0) {


            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    $(modalId).find('.modal-dialog').html(response.createView);
                    modalBootstrap.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();

                    const form = document.querySelector(formId);

                    var validator = FormValidation.formValidation(
                        form, {
                            fields: validatorFields,
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


                    if (RequiredInputList != null) {
                        for (var key in RequiredInputList) {
                            // console.log("key " + key + " has value " + RequiredInputList[key]);
                            var fieldName = $(RequiredInputList[key] + ["[name=" + key + "]"]).closest(
                                ".fv-row")
                                .find(
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

                    }

                    // Submit button handler
                    const submitButton = document.querySelector(submitButtonName);
                    submitButton.addEventListener('click', function (e) {
                        // Prevent default button action
                        e.preventDefault();

                        // const form = document.querySelector(formId);

                        // Validate form before submit
                        if (validator) {
                            validator.validate().then(function (status) {
                                console.log('validated!');

                                if (onFormSuccessCallBack == null) {
                                    onFormSuccessCallBack = function (response) {
                                        toastr.success(response.message);
                                        form.reset();
                                        modalBootstrap.hide();
                                        if (dataTableId != '')
                                            dataTableId.ajax.reload(null,
                                                false);
                                    };
                                }
                                if (status == 'Valid') {
                                    // Show loading indication
                                    submitButton.setAttribute('data-kt-indicator', 'on');

                                    // Disable button to avoid multiple clicks
                                    submitButton.disabled = true;

                                    let data = $(form).serialize();

                                    $.ajax({
                                        type: 'POST',
                                        url: $(form).attr('action'),
                                        data: data,
                                        success: onFormSuccessCallBack,
                                        complete: function () {
                                            // Release button
                                            submitButton.removeAttribute(
                                                'data-kt-indicator');

                                            // Re-enable button
                                            submitButton.disabled = false;
                                        },
                                        error: function (response, textStatus,
                                                         errorThrown) {
                                            toastr.error(response.responseJSON
                                                .message);
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        text: "Sorry, looks like there are some errors detected, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            });
                        }
                    });

                    //var appointmentDate = $(form.querySelector('.date-flatpickr'));
                    $('.date-flatpickr').flatpickr({
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        allowInput: true,
                        minDate: "today"
                    });

                    //var appointmentTime = $(form.querySelector('.time-flatpickr'));
                    $('.time-flatpickr').flatpickr({
                        allowInput: true,
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true
                    });

                    $('[data-control="select2"]').select2({
                        dropdownParent: $(modalId),
                        allowClear: true,
                    });
                    $('[ name="purpose"]').select2({
                        ajax: {
                            url: '/getSelect?type=purpose&category=' + $('[ name="category"]').attr('value'),
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    term: params.term,
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            }
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    });
                    $(document).on('change', '#category', function (e) {
                        $('[ name="purpose"]').select2({
                            ajax: {
                                url: '/getSelect?type=purpose&category=' + $(this).val(),
                                dataType: 'json',
                                data: function (params) {
                                    var query = {
                                        term: params.term,
                                    }

                                    // Query parameters will be ?search=[term]&type=public
                                    return query;
                                }
                                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                            }
                        });
                    });

                    $('[ name="employee"]').select2({
                        ajax: {
                            url: '/getSelect?type=employeeDepartment&department=' + $('[ name="department"]').attr('value'),
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    term: params.term,
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            }
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    });
                    $(document).on('change', '#department', function (e) {
                        $('[ name="employee"]').select2({
                            ajax: {
                                url: '/getSelect?type=employeeDepartment&department=' + $(this).val(),
                                dataType: 'json',
                                data: function (params) {
                                    var query = {
                                        term: params.term,
                                    }

                                    // Query parameters will be ?search=[term]&type=public
                                    return query;
                                }
                                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                            }
                        });
                    });


                },
                complete: function () {
                    if (button) {
                        button.removeAttr('data-kt-indicator');

                    }
                    if (data_id) {
                        var telephone = $('[name="telephone"]').val();

                        datatableTickets.ajax.url("{{ route('tickets.indexByPhone') }}?telephone=" + telephone).load();
                        datatableVisits.ajax.url("{{ route('visits.indexByPhone') }}?telephone=" + telephone).load();
                        datatableCalls.ajax.url("{{ route('calls.indexByPhone') }}?telephone=" + telephone).load();

                    }
                }
            });


        }
    </script>
@endpush
