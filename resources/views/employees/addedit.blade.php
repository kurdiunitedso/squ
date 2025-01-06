@extends('metronic.index')


@section('title', 'Employee-' . 'Add new employee')
@section('subpageTitle', 'Employee')
@section('subpageName', 'Add new employee')


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
    <div class="card mb-5 mb-xl-5" id="kt_employee_form_tabs">
        <div class="card-body pt-0 pb-0">
            <div class="d-flex flex-column flex-lg-row justify-content-between">
                <!--begin::Navs-->
                <ul id="myTab"
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold order-lg-1 order-2">

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_employee" href="#kt_tab_pane_employee">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{__('Employees')}}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5" data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_bank" href="#kt_tab_pane_bank">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{__('Bank')}}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5  {{ isset($employee) ? '' : 'disabled' }}"
                           data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_whour" href="#kt_tab_pane_whour">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Working Hours')}} </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5  {{ isset($employee) ? '' : 'disabled' }}"
                           data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_scheduled_hours" href="#kt_tab_pane_scheduled_hours">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Schedule Working Hours')}} </a>
                    </li>

                    <li class="nav-item mt-2 ">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5  {{ isset($employee) ? '' : 'disabled' }}"
                           data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_payment_roll" href="#kt_tab_pane_payment_roll">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Payment Roll')}} </a>
                    </li>

                    <li class="nav-item mt-2 ">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5  {{ isset($employee) ? '' : 'disabled' }}"
                           data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_salary" href="#kt_tab_pane_salary">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Salary')}} </a>
                    </li>
                    <li class="nav-item mt-2 ">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5  {{ isset($employee) ? '' : 'disabled' }}"
                           data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_vacations" href="#kt_tab_pane_vacations">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Vacations')}} </a>
                    </li>

                    <!--end::Nav item-->
                    <!--begin::Nav item-->


                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($employee) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_attachments"
                           href="#kt_tab_pane_attachments">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Attachments')}} </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($employee) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_history" href="#kt_tab_pane_history">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('History')}} </a>
                    </li>


                    <!--end::Nav item-->
                    <!--begin::Nav item-->

                </ul>


            </div>
            <div class="d-flex my-4 justify-content-end order-lg-2 order-1">

                <a href="{{ route('employees.index') }}" class="btn btn-sm btn-light me-2"
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

                <a href="#" class="btn btn-sm btn-primary ms-5" data-kt-employee-action="submit">
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
                            {{__('Save Form')}}</span>
                    <span class="indicator-progress">
                            {{__('Please wait...')}} <span
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
          action="{{ route('employees.addedit', ['Id' => isset($employee) ? $employee->id : '']) }}?{{ isset($employee) ? 'employee_id=' . $employee->id : '' }}">
        @csrf
        <div class="tab-pane fade show active" id="kt_tab_pane_employee" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_employee_details_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Employee Details')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">
                        @include('employees.form')
                    </div>
                </div>


                <!--end::Card body-->
            </div>

            {{--   {!! $employeeForm !!}--}}
        </div>

        <div class="tab-pane fade" id="kt_tab_pane_bank" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_bank_details_view">
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('Bank')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">

                    @include('employees.bank')
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_history" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_history_details_view">
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{__('History')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">

                    @include('employees.history.index')
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_attachments" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_attachments_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        attachments
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @if(isset($employee))

                        @include('employees.attachments.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_whour" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_whour_details_view">
                <!--begin::Card header-->
                @if(isset($employee))
                    @include('employees.working_hours.index')
                @endif
                <!--end::Card body-->
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_vacations" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_vacations_details_view">
                <!--begin::Card header-->
                @if(isset($employee))
                    @include('employees.vacations.index')
                @endif
                <!--end::Card body-->
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_salary" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_marketing_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        Salary
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @if(isset($employee))
                        @include('employees.salarys.index')
                    @endif
                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_scheduled_hours" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_scheduled_hours_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{__('Schedule Working Hours')}}
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">

                    @if(isset($employee))
                        @include('employees.scheduled_hours.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_payment_roll" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_payment_roll_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{__('Payment Roll')}}
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">

                    @if(isset($employee))
                        @include('employees.payment_rolls.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>


    </form>
    <div class="modal fade" id="kt_modal_add_salary" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_show_whour" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_whour" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_vacation" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_add_payment_roll" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_add_swhour" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_showCalls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl ">

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
        $(function () {


            $("#kt_datepicker_8").flatpickr({
                altInput: true,
                altFormat: "Y-m-d",
                dateFormat: "Y-m-d",
                static: true
            });
            $('.date-flatpickr').flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,

            });


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
                'name': 'input',

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
            const submitButton = document.querySelector('[data-kt-employee-action="submit"]');
            submitButton.addEventListener('click', function (e) {
                // Prevent default button action
                e.preventDefault();

                var formAddEdit = $("#kt_modal_employee_form");
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


