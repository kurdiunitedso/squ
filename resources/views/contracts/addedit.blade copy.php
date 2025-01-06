@php
    use App\Models\Contract;
    use App\Models\ClientTrillion;
    use App\Models\ContractItem;
@endphp
@extends('metronic.index')


@section('subpageTitle', Contract::ui['p_ucf'])

@section('title', t(Contract::ui['s_ucf'] . '- Add new ' . Contract::ui['s_ucf']))
@section('subpageTitle', Contract::ui['s_ucf'])
@section('subpageName', 'Add new ' . Contract::ui['s_ucf'])


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

                    {{-- <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_1" href="#kt_tab_pane_1">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t(Contract::ui['s_ucf']) }}
                        </a>
                    </li> --}}

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_2" href="#kt_tab_pane_2">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t(ClientTrillion::ui['s_ucf']) }}
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6  px-2 py-5
                          {{ app()->request->active == ContractItem::ui['route'] ? 'active' : '' }}   "
                            data-bs-toggle="tab" id="items" data-bs-target="#kt_tab_pane_3" href="#kt_tab_pane_3">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ t(ContractItem::ui['s_ucf']) }}
                        </a>
                    </li>



                    <!--end::Nav item-->
                    <!--begin::Nav item-->


                    {{-- <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($item_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_7" href="#kt_tab_pane_7">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('Attachments') }} </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($item_model) ? '' : 'disabled' }}"
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

                <a href="{{ route(Contract::ui['route'] . '.index') }}" class="btn btn-sm btn-light me-2"
                    id="kt_user_follow_button">
                    <!--begin::Indicator label-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                fill="currentColor" />
                            <rect x="7" y="15.3137" width="12" height="2" rx="1"
                                transform="rotate(-45 7 15.3137)" fill="currentColor" />
                            <rect x="8.41422" y="7" width="12" height="2" rx="1"
                                transform="rotate(45 8.41422 7)" fill="currentColor" />
                        </svg>
                    </span>
                    {{ __('Exit') }}
                </a>

                <a href="#" class="btn btn-sm btn-primary ms-5" data-kt-captin-action="submit">
                    <span class="indicator-label">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                    fill="currentColor" />
                                <path
                                    d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        {{ __('Save Form') }}</span>
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

    <form class="tab-content" id="myTabContent" method="post"
        action="{{ route(Contract::ui['route'] . '.addedit', ['Id' => isset($item_model) ? $item_model->id : '']) }}?{{ isset($item_model) ? 'department_id=' . $item_model->id : '' }}">
        @csrf
        {{-- <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ t(Contract::ui['s_ucf'] . ' Details') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">
                        @include(Contract::ui['route'] . '.form')
                    </div>
                </div>


                <!--end::Card body-->
            </div>

        </div> --}}
        <div class="tab-pane fade show active" id="kt_tab_pane_2" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ t(ClientTrillion::ui['s_ucf'] . ' Details') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">
                        @include(Contract::ui['route'] . '.' . ClientTrillion::ui['s_lcf'])
                    </div>
                </div>


                <!--end::Card body-->
            </div>

        </div>
        <div class="tab-pane fade  {{ app()->request->active == 'items' ? 'show active' : '' }}" id="kt_tab_pane_3"
            role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_itemes_details_view">
                <!--begin::Card header-->
                @if (isset($item_model))
                    @include(Contract::ui['p_lcf'] . '.' . ContractItem::ui['p_lcf'] . '.index')
                @endif
                <!--end::Card body-->
            </div>
        </div>
        {{-- <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
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
                    @if (isset($item_model))
                        @include(Contract::ui['route'] . '.attachments.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_history" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_history_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        History
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">


                    @include(Contract::ui['route'] . '.history.index')


                </div>
                <!--end::Card body-->
            </div>
        </div> --}}

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
        $(function() {
            // Initialize the contract start date picker
            $("input[name='contract_start_date']").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    // When the start date changes, update the minDate for the end date picker
                    console.log(selectedDates, dateStr, instance);
                    $("input[name='contract_end_date']").flatpickr().set('minDate', dateStr);
                }
            });

            // Initialize the contract end date picker
            $("input[name='contract_end_date']").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
                minDate: "today"
            });





        });
    </script>
    <script>
        const kt_modal_showCalls = document.getElementById('kt_modal_showCalls');
        const modal_kt_modal_showCalls = new bootstrap.Modal(kt_modal_showCalls);

        $(document).on('click', '.viewCalls', function(e) {

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
        $(function() {


            $("#kt_datepicker_8").flatpickr({
                altInput: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                altFormat: "H:i",
                maxTime: $("#kt_datepicker_9").val(),
                static: true
            });
            $("#kt_datepicker_9").flatpickr({
                altInput: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                altFormat: "H:i",
                minTime: $("#kt_datepicker_8").val(),
                static: true
            });


            $("#kt_datepicker_10").flatpickr({
                altInput: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                altFormat: "H:i",
                maxTime: $("#kt_datepicker_9").val(),
                static: true
            });
            $("#kt_datepicker_11").flatpickr({
                altInput: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                altFormat: "H:i",
                minTime: $("#kt_datepicker_8").val(),
                static: true
            });

        });
        const kt_modal_tickets = document.getElementById('kt_modal_tickets');
        const modal_kt_modal_tickets = new bootstrap.Modal(kt_modal_tickets);
        const kt_modal_visits = document.getElementById('kt_modal_visits');
        const modal_kt_modal_visits = new bootstrap.Modal(kt_modal_visits);

        $(document).on('click', '.btnUpdatevisit', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');
            var size = $(this).attr("size");
            /*       $('#kt_modal_visits').find('.modal-dialog').removeClass('modal-xl');
                   $('#kt_modal_visits').find('.modal-dialog').removeClass('modal-sm');
                   $('#kt_modal_visits').find('.modal-dialog').removeClass('modal-lg');
                   $('#kt_modal_visits').find('.modal-dialog').addClass(size);*/

            globalRenderModal(editURl,
                $(this), '#kt_modal_visits',
                modal_kt_modal_visits,
                [],
                '#kt_modal_add_visit_form',
                datatable,
                '[data-kt-visit-modal-action="submit"]');
        });
        $(document).on('click', '.btnUpdateticket', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var data_id = $(this).attr("data-id");
            const editURl = $(this).attr('href');
            var size = $(this).attr("size");
            /*  $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-xl');
              $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-sm');
              $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-lg');
              $('#kt_modal_tickets').find('.modal-dialog').addClass(size);*/

            globalRenderModal(editURl,
                $(this), '#kt_modal_tickets',
                modal_kt_modal_tickets,
                [],
                '#kt_modal_add_ticket_form',
                datatable,
                '[data-kt-ticket-modal-action="submit"]', data_id);
        });
    </script>
    <script>
        var validator;
        const form = document.getElementById('myTabContent');

        $(function() {

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
            var dueDatebirth_date = $(form.querySelector('[name="dob"]'));
            dueDatebirth_date.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                maxDate: "today",
                allowInput: true,
            });
            var dueDatebirth_date2 = $(form.querySelector('[name="reference_dob"]'));
            dueDatebirth_date2.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                maxDate: "today",
                allowInput: true,
            });
            var dueDatebirth_date3 = $(form.querySelector('[name="policy_start"]'));
            dueDatebirth_date3.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
            });
            var dueDatebirth_date4 = $(form.querySelector('[name="policy_end"]'));
            dueDatebirth_date4.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                maxDate: dueDatebirth_date3.val(),
                allowInput: true,
            });
            var dueDatebirth_date4 = $(form.querySelector('[name="policy_expire"]'));
            dueDatebirth_date4.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                maxDate: dueDatebirth_date3.val(),
                allowInput: true,
            });
            var dueDatebirth_date3 = $(form.querySelector('[name="license_expire_date"]'));
            dueDatebirth_date3.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
            });


            var license_expire_date = $(form.querySelector('[name="license_expire_date2"]'));
            license_expire_date.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
            });
            var dueDatebirth_date3 = $(form.querySelector('[name="join_date"]'));
            dueDatebirth_date3.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
            });
            validator.on('core.form.invalid', function(event) {
                const fields = validator.getFields();
                $.each(fields, function(element) {
                    validator.validateField(element)
                        .then(function(status) {
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
                // 'name': 'input',
                // 'full_name': 'input',
                // 'address': 'input',
                // 'blood_type': 'select',
                // 'captin_id': 'input',
                // 'city_id': 'select',
                // 'assign_city_id': 'select',
                // 'bod': 'input',
                // 'mobile1': 'input',
                // 'vehicle_type': 'select',
                // 'fuel_type': 'select',
                // 'box_no': 'input',
                // 'sign_permission': 'select',
                // 'vehicle_model': 'input',
                // 'vehicle_year': 'input',
                // 'reference_name': 'input',
                // 'motor_cc': 'input',

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
            $(document).on('change', '#has_insurance', function(e) {
                //alert($('#has_insurance').val());
                if ($('#has_insurance').val() == 'on') {
                    $('#has_insurance').val('off');
                    $('.tab3').addClass('d-none');
                } else {
                    $('#has_insurance').val('on');
                    $('.tab3').removeClass('d-none');
                }
            });
            $(document).on('change', '.is_current_wrok', function(e) {
                //alert($('#has_insurance').val());

                if ($(this).val() === '1') {
                    $('.current_work').removeClass('d-none');
                } else {
                    $('.current_work').addClass('d-none');
                }
            });

            const submitButton = document.querySelector('[data-kt-captin-action="submit"]');
            submitButton.addEventListener('click', function(e) {
                // Prevent default button action
                e.preventDefault();

                var formAddEdit = $("#kt_modal_constant_form");
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {
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
        $(document).on('click', '#AddvisitsModal', function(e) {
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
                success: function(response) {
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
                    submitButton.addEventListener('click', function(e) {
                        // Prevent default button action
                        e.preventDefault();

                        // const form = document.querySelector(formId);

                        // Validate form before submit
                        if (validator) {
                            validator.validate().then(function(status) {
                                console.log('validated!');

                                if (onFormSuccessCallBack == null) {
                                    onFormSuccessCallBack = function(response) {
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
                                        complete: function() {
                                            // Release button
                                            submitButton.removeAttribute(
                                                'data-kt-indicator');

                                            // Re-enable button
                                            submitButton.disabled = false;
                                        },
                                        error: function(response, textStatus,
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
                            url: '/getSelect?type=purpose&category=' + $('[ name="category"]').attr(
                                'value'),
                            dataType: 'json',
                            data: function(params) {
                                var query = {
                                    term: params.term,
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            }
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    });
                    $(document).on('change', '#category', function(e) {
                        $('[ name="purpose"]').select2({
                            ajax: {
                                url: '/getSelect?type=purpose&category=' + $(this).val(),
                                dataType: 'json',
                                data: function(params) {
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
                            url: '/getSelect?type=employeeDepartment&department=' + $(
                                '[ name="department"]').attr('value'),
                            dataType: 'json',
                            data: function(params) {
                                var query = {
                                    term: params.term,
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            }
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    });
                    $(document).on('change', '#department', function(e) {
                        $('[ name="employee"]').select2({
                            ajax: {
                                url: '/getSelect?type=employeeDepartment&department=' + $(this)
                                    .val(),
                                dataType: 'json',
                                data: function(params) {
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
                complete: function() {
                    if (button) {
                        button.removeAttr('data-kt-indicator');

                    }
                    if (data_id) {
                        var telephone = $('[name="telephone"]').val();

                        datatableTickets.ajax.url("{{ route('tickets.indexByPhone') }}?telephone=" + telephone)
                            .load();
                        datatableVisits.ajax.url("{{ route('visits.indexByPhone') }}?telephone=" + telephone)
                            .load();
                        datatableCalls.ajax.url("{{ route('calls.indexByPhone') }}?telephone=" + telephone)
                            .load();

                    }
                }
            });


        }
    </script>

    <script>
        $(document).on('change', '#vehicle_id', function(e) {
            var module = 'Vehicle';
            var vehicle = this.value;


            jQuery.ajax({
                url: '/getSelect?module=' + module + "&category_id=" + vehicle,
                type: 'GET',
                dataType: "json",
                success: function(data) {
                    console.log(data.data);


                    $('[name="license_expire_date2"]').attr('value', data.data.license_expire_date2);

                    $('[name="promissory"]').val(data.data.promissory);
                    $('[name="sign_permission"]').val(data.data.sign_permission);
                    $('[name="box_no"]').val(data.data.box_no);
                    $('[name="vehicle_no"]').val(data.data.vehicle_no);
                    /* $('[name="vehicle_model2"]').attr('value', data.data.vehicle_model2);*/
                    $('[name="vehicle_type"]').val(data.data.vehicle_type).trigger('change');

                    $('[name="fuel_type"]').val(data.data.fuel_type).trigger('change');
                    $('[name="motor_cc"]').val(data.data.motor_cc).trigger('change');
                    $('[name="vehicle_year"]').val(data.data.vehicle_year);

                    $('[name="insurance_type"]').val(data.data.motor_cc).trigger('insurance_type');
                    $('[name="policy_expire"]').val(data.data.policy_expire);
                    $('[name="insurance_company"]').val(data.data.insurance_company).trigger('change');


                },
                error: function(data) {
                    toastr.error('error', 'Errors', 'No Data for patient');
                }

            });


        });
    </script>
    <script>
        $(document).ready(function() {
            const ClientTrillionModel = "App\\Models\\ClientTrillion";
            const $clientTrillionSelect = $('[name="client_trillion_id"]');

            console.log('Initializing Client Trillion selector');
            initializeClientTrillionSelector();

            console.log('Setting up contract data');
            setupContractData();

            function initializeClientTrillionSelector() {
                getSelect2(ClientTrillionModel, $clientTrillionSelect, "Select a Client Trillion",
                    setClientTrillionDetails);

                // Set initial value if available
                const initialClientTrillionId =
                    "{{ old('client_trillion_id', isset($clientTrillion) ? $clientTrillion->id : '') }}";
                if (initialClientTrillionId) {
                    console.log(`Setting initial Client Trillion ID: ${initialClientTrillionId}`);
                    setClientTrillionDetails(initialClientTrillionId, ClientTrillionModel);
                }
            }

            function setupContractData() {
                const contractJson = `@json(isset($item_model) ? $item_model : null)`;
                console.log('Contract JSON string:', contractJson);

                try {
                    const contract = JSON.parse(contractJson);
                    console.log('Parsed contract:', contract);
                    if (contract && contract.client_trillion_id) {
                        console.log(`Setting Client Trillion from contract: ${contract.client_trillion_id}`);
                        setClientTrillionDetails(contract.client_trillion_id, ClientTrillionModel);
                    }
                } catch (error) {
                    console.error('Error parsing contract JSON:', error);
                }
            }
        });

        function setClientTrillionDetails(modelId, model) {
            console.log(`Setting Client Trillion details. Model ID: ${modelId}, Model: ${model}`);

            if (!modelId) {
                console.log('No model ID provided. Using old session values.');
                setFieldsFromOldValues();
                return;
            }

            console.log('Fetching Client Trillion details from server');
            $.ajax({
                url: "{{ route('getSelect2Details') }}",
                method: 'GET',
                data: {
                    model,
                    model_id: modelId
                },
                success: handleClientTrillionDataSuccess,
                // error: handleClientTrillionDataError
                error: handleAjaxErrors,

            });
        }

        function handleClientTrillionDataSuccess(data) {
            console.log('Client Trillion data received:', data);
            const clientTrillion = data.item;

            setField('name', clientTrillion.name);
            setField('name_en', clientTrillion.name_en);
            setField('name_h', clientTrillion.name_h);
            setField('representative_name', clientTrillion.representative_name);
            setField('registration_name', clientTrillion.registration_name);
            setField('registration_number', clientTrillion.registration_number);
            setSelectField('country_id', clientTrillion.country_id);
            setSelectField('city_id', clientTrillion.city_id);
            setSelectField('company_type', clientTrillion.company_type);
            setField('address', clientTrillion.address);
            setField('telephone', clientTrillion.telephone);
            setField('fax', clientTrillion.fax);
            setField('email', clientTrillion.email);

            setActiveStatus(clientTrillion.active);

            console.log('Client Trillion details set successfully');

            // Create and append the option to Select2
            var option = new Option(clientTrillion.name, clientTrillion.id, true, true);
            $('[name="client_trillion_id"]').append(option).trigger('change');
            console.log("Select2 option created and selected:", {
                name: clientTrillion.name,
                id: clientTrillion.id
            });
        }

        // function handleClientTrillionDataError(response) {
        //     console.error('Failed to fetch Client Trillion data:', response);
        //     toastr.error(response.responseJSON.message);
        // }


        function setFieldsFromOldValues() {
            setField('name');
            setField('name_en');
            setField('name_h');
            setField('representative_name');
            setField('registration_name');
            setField('registration_number');
            setSelectField('country_id');
            setSelectField('city_id');
            setSelectField('company_type');
            setField('address');
            setField('telephone');
            setField('fax');
            setField('email');

            const oldActiveStatus = "{{ old('active', 0) }}";
            setActiveStatus(parseInt(oldActiveStatus));

            console.log('Fields set from old values');
        }
    </script>
@endpush
