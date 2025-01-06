@extends('metronic.index')


@section('title', 'Claim-' . 'Add new claim')
@section('subpageTitle', 'Claim')
@section('subpageName', 'Add new claim')


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
    <div class="card mb-5 mb-xl-5" id="kt_claim_form_tabs">
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
                            {{__('Client')}}
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 " data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_claim" href="#kt_tab_pane_claim">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{__('Claim')}}
                        </a>
                    </li>

                    <li class="nav-item mt-2" id="tab2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($claim) ? '' : 'disabled' }} "
                           data-bs-toggle="tab"
                           data-bs-target="#kt_tab_pane_2" href="#kt_tab_pane_2">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Items')}} </a>
                    </li>


                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($claim) ? '' : 'disabled' }}"
                           data-bs-toggle="tab" data-bs-target="#kt_tab_pane_7" href="#kt_tab_pane_7">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{__('Attachments')}} </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($claim) ? '' : 'disabled' }}"
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

                <a href="{{ route('claims.index') }}" class="btn btn-sm btn-light me-2"
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

                <a href="#" class="btn btn-sm btn-primary ms-5" data-kt-claim-action="submit">
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
          action="{{ route('claims.addedit', ['Id' => isset($claim) ? $claim->id : '']) }}?{{ isset($claim) ? 'claim_id=' . $claim->id : '' }}">
        @csrf
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_client_details_view">
                <!--begin::Card header-->

                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">
                        @include('claims.client')
                    </div>
                </div>


                <!--end::Card body-->
            </div>

            {{--   {!! $clientForm !!}--}}
        </div>

        <div class="tab-pane fade  " id="kt_tab_pane_claim" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_claim_details_view">
                <!--begin::Card header-->

                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">
                        @include('claims.form')
                    </div>
                </div>


                <!--end::Card body-->
            </div>

            {{--   {!! $claimForm !!}--}}
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_itemes_details_view">
                <!--begin::Card header-->
                @if(isset($claim))
                    @include('claims.items.index')
                @endif
                <!--end::Card body-->
            </div>
        </div>




        <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
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
                    @if(isset($claim))

                        @include('claims.attachments.index')
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
                    @if(isset($claim))

                        @include('claims.history.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>

    </form>


    <div class="modal fade" id="kt_modal_showCalls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl ">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

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
            renderAModal(
                href,
                $(this), '#kt_modal_showCalls',
                modal_kt_modal_showCalls);
        });

    </script>
    <script>
        $(function () {


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
            var service_date = $(form.querySelector('[name="service_date_from"]'));
            service_date.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",

                allowInput: true,
            });
            var service_date_to = $(form.querySelector('[name="service_date_to"]'));
            service_date_to.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",

                allowInput: true,
            });
            var submit_date = $(form.querySelector('[name="submit_date"]'));
            submit_date.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",

                allowInput: true,
            });
            var claim_date = $(form.querySelector('[name="claim_date"]'));
            claim_date.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",

                allowInput: true,
            });


            var payment_date = $(form.querySelector('[name="payment_date"]'));
            payment_date.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
            });

            var dueDatebirth_date2 = $(form.querySelector('[name="reference_service_date"]'));
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
                maxDate: dueDatebirth_date3.val()
                ,
                allowInput: true,
            });
            var dueDatebirth_date4 = $(form.querySelector('[name="policy_expire"]'));
            dueDatebirth_date4.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                maxDate: dueDatebirth_date3.val()
                ,
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
                'name_en': 'input',
                'address': 'input',
                'city_id': 'select',

                'telephone': 'input',
                'type_id': 'select',


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
            $(document).on('change', '#has_insurance', function (e) {
                //alert($('#has_insurance').val());
                if ($('#has_insurance').val() == 'on') {
                    $('#has_insurance').val('off');
                    $('.tab3').addClass('d-none');
                } else {
                    $('#has_insurance').val('on');
                    $('.tab3').removeClass('d-none');
                }
            });
            $(document).on('change', '.is_current_wrok', function (e) {
                //alert($('#has_insurance').val());

                if ($(this).val() === '1') {
                    $('.current_work').removeClass('d-none');
                } else {
                    $('.current_work').addClass('d-none');
                }
            });

            const submitButton = document.querySelector('[data-kt-claim-action="submit"]');
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

                    $('[ name="team"]').select2({
                        ajax: {
                            url: '/getSelect?type=teamDepartment&department=' + $('[ name="department"]').attr('value'),
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
                        $('[ name="team"]').select2({
                            ajax: {
                                url: '/getSelect?type=teamDepartment&department=' + $(this).val(),
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
    <script>
        $(document).on('change', '#client_id', function (e) {
            var module = 'ClientTrillion';
            var client = this.value;

            $('[ name="project_id"]').select2({
                ajax: {
                    url: '/getSelect?type=projects&client_id=' + $(this).val(),
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
            jQuery.ajax({
                url: '/getSelect?module=' + module + "&category_id=" + client,
                type: 'GET',
                dataType: "json",
                success: function (data) {
                    console.log(data.data);


                    $('[name="name"]').attr('value', data.data.name);
                    $('[name="name_en"]').attr('value', data.data.name_en);
                    $('[name="name_h"]').attr('value', data.data.name_h);
                    $('[name="registration_number"]').attr('value', data.data.registration_number);
                    $('[name="registration_name"]').attr('value', data.data.registration_name);
                    $('[name="representative_name"]').attr('value', data.data.representative_name);
                    $('[name="service_date"]').attr('value', data.data.service_date);
                    if (data.data.country_id)
                        $('[name="country_id"]').val(data.data.country_id).trigger('change');
                    else
                        $('[name="country_id"]').val(null).trigger('change');

                    if (data.data.city_id)
                        $('[name="city_id"]').val(data.data.city_id).trigger('change');
                    else
                        $('[name="city_id"]').val(null).trigger('change');

                    if (data.data.company_type)
                        $('[name="company_type"]').val(data.data.company_type).trigger('change');
                    else
                        $('[name="company_type"]').val(null).trigger('change');



                    $('[name="address"]').attr('value', data.data.address);
                    $('[name="telephone"]').attr('value', data.data.telephone);
                    $('[name="fax"]').attr('value', data.data.fax);
                    $('[name="email"]').attr('value', data.data.email);

                },
                error:
                    function (data) {
                        toastr.error('error', 'Errors', 'No Data for patient');
                    }

            });



        });
    </script>
@endpush


