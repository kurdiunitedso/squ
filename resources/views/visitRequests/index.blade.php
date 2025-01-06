@extends('metronic.index')

@section('title', 'Visits')
@section('subpageTitle', 'Visits')

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
                            <input type="text" data-col-index="name_code" data-kt-visits-table-filter="search"
                                class="form-control datatable-input form-control-solid w-250px ps-14"
                                placeholder="Search Visits" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-visits-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::visits 1-->
                            <!--end::visits 1-->
                            @include('visitRequests._filter')


                            <a target="_blank" id="exportBtn" href="#"
                                data-export-url="{{ route('visitRequests.export') }}" class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{ __('Export') }}
                            </a>
                            <!--end::Filter-->
                            <!--begin::Add visits-->
                            <button type="button" class="btn btn-primary" url="{{ route('visitRequests.create') }}"
                                id="AddvisitsModal">
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
                                    {{ __('Add Visit Request') }}
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <!--end::Add visits-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_visits" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">

                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - Add task-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_visits">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="all">{{ __('SN') }}</th>
                                <th class="all"></th>
                                <th class="all">{{ __('Category') }}</th>
                                <th class="all">{{ __('Source') }}</th>
                                <th class="all">{{ __('Name') }}</th>
                                <th class="all">{{ __('Telephone') }}</th>
                                <th class="all">{{ __('Type') }}</th>
                                <th class="min-w-300px all">{{ __('Employee') }}</th>

                                <th class="">{{ __('Max Visit Date') }}</th>


                                <th class="">{{ __('Visits') }}</th>
                                <th class="all">{{ __('Status') }}</th>
                                <th class="all">{{ __('Action') }}</th>
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
    <div class="modal fade" id="kt_modal_visits" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_leads" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_calls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_shortMessages" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_attachment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_showCalls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl ">

        </div>
        <!--end::Modal dialog-->
    </div>

@endsection


@push('scripts')
    <script>
        const columnDefs = [{
                data: 'id',
                name: 'id',
            },
            {
                className: 'dt-row',
                orderable: false,
                target: -1,
                data: null,
                render: function(data, type, row, meta) {
                    return '<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px"><span class="la la-list-ul"></span></a>';

                }
            },
            {

                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.categories)
                            return row.categories.name;
                    }
                    return '';
                },
                name: 'categories.name',

            },
            {
                data: 'visitable_type',
                name: ' visitable_type',
            },
            {
                data: 'visit_name',
                name: ' visit_name',
            },


            {
                data: 'telephone',
                name: 'telephone',
            },
            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.visit_types)
                            return row.visit_types.name;
                    }
                    return '';
                },
                name: ' visit_types.name',


            },


            {
                data: 'employee_name',
                name: 'employees.name',
            },
            {
                data: 'last_date',
                name: 'last_date ',
            },

            {
                data: 'visits_count',
                name: 'visits_count',
            },
            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.statuses)
                            return row.statuses.name;
                    }
                    return '';
                },
                name: 'statuses.name',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ];
        var datatable = createDataTable('#kt_table_visits', columnDefs, "{{ route('visitRequests.index') }}", [
            [0, "DESC"]
        ]);
        datatable.on('draw', function() {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function() {
            KTMenu.createInstances();
        });
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-visits-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.columns(3).search(filterSearch.value).draw();
        }
    </script>
    <script>
        const validatorVisitFields = {
            'visit_name': {
                validators: {
                    notEmpty: {
                        message: 'Name '
                    }
                }
            },


        };

        const kt_modal_visits = document.getElementById('kt_modal_visits');
        const modal_kt_modal_visits = new bootstrap.Modal(kt_modal_visits);

        const validatorLeadFields = {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Name '
                    }
                }
            },


        };


        $(document).on('click', '#AddvisitsModal', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            url = $(this).attr('url');

            globalRenderModal(url,
                $(this), '#kt_modal_visits',
                modal_kt_modal_visits,
                validatorVisitFields,
                '#kt_modal_add_visit_form',
                datatable,
                '[data-kt-visit-modal-action="submit"]');


        });


        const kt_modal_leads = document.getElementById('kt_modal_leads');
        const modal_kt_modal_leads = new bootstrap.Modal(kt_modal_leads);
        $(document).on('click', '#AddleadsModal', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            url = $(this).attr('url');

            globalRenderModal(url,
                $(this), '#kt_modal_leads',
                modal_kt_modal_leads,
                validatorLeadFields,
                '#kt_modal_add_lead_form',
                datatable,
                '[data-kt-lead-modal-action="submit"]');


        });


        $(document).on('click', '.btnUpdatevisit', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');

            renderAModal(editURl,
                $(this), '#kt_modal_visits',
                modal_kt_modal_visits,
                validatorVisitFields,
                '#kt_modal_add_visit_form',
                datatable,
                '[data-kt-visit-modal-action="submit"]');
        });
    </script>

    <script>
        $(document).on('change', '#employee', function(e) {
            jQuery.ajax({
                url: '/getSelect?module=employee&id=' + $(this).val(),
                type: 'GET',
                dataType: "json",
                success: function(data) {
                    console.log(data.data.telephone);

                    if (data.data != []) {
                        $('[name="telephone"]').attr('value', data.data.mobile);
                        $('[name="email"]').attr('value', data.data.email);
                        $('[name="city_id"]').val(data.data.assign_city_id).trigger('change');

                    }


                },
                error: function(data) {
                    toastr.error('error', 'Errors', 'No Data for patient');
                }

            });
        });
    </script>
    <script>
        $(document).on('click', '.btnDeletevisit', function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const visitName = $(this).attr('data-visit-name');
            Swal.fire({
                html: "Are you sure you want to delete " + visitName + "?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: URL,
                        dataType: "json",
                        success: function(response) {
                            datatable.ajax.reload(null, false);
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        complete: function() {},
                        error: function(response, textRating_Captin,
                            errorThrown) {
                            toastr.error(response
                                .responseJSON
                                .message);
                        },
                    });

                } else if (result.dismiss === 'cancel') {}

            });
        });

        const kt_modal_showCalls = document.getElementById('kt_modal_showCalls');
        const modal_kt_modal_showCalls = new bootstrap.Modal(kt_modal_showCalls);

        $(document).on('click', '.viewCalls', function(e) {

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
        $(document).on('click', '#filterBtn', function(e) {
            e.preventDefault();
            datatable.ajax.reload();
        });

        $(document).on('click', '#resetFilterBtn', function(e) {
            e.preventDefault();
            $('#filter-form').trigger('reset');
            $('.datatable-input').each(function() {
                if ($(this).hasClass('filter-selectpicker')) {
                    $(this).val('');
                    $(this).trigger('change');
                }
                if ($(this).hasClass('flatpickr-input')) {
                    const fp = $(this)[0]._flatpickr;
                    fp.clear();
                }
            });
            datatable.ajax.reload();
        });

        $(document).on('click', '#exportBtn', function(e) {
            e.preventDefault();
            const url = $(this).data('export-url');
            const myUrlWithParams = new URL(url);

            const parameters = filterParameters();
            Object.keys(parameters).map((key) => {
                myUrlWithParams.searchParams.append(key, parameters[key]);
            });

            window.open(myUrlWithParams, "_blank");

        });
    </script>



    <script>
        function refreshVisitCalls(url) {
            $(visit_calls_card).find('.card-body').html('');

            blockUI_visit_calls_card.block();

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $(visit_calls_card).find('.card-title span').text(response
                        .visitName);
                    $(visit_calls_card).find('.card-body').html(response.drawerView);

                },
                complete: function() {
                    blockUI_visit_calls_card.release();
                }

            });

        }

        $(document).ready(function() {
            $(document).on('click', '.showCalls', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                var drawerElement = document.querySelector("#kt_drawer_showCalls");
                var drawer = KTDrawer.getInstance(drawerElement);
                drawer.show();
                refreshVisitCalls(url);
            });
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
                    $('[name="visit_date"]').flatpickr({
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        allowInput: true,
                        minDate: "today"
                    });

                    $('[name="last_date"]').flatpickr({
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        allowInput: true,
                        minDate: "today"
                    });

                    //var appointmentTime = $(form.querySelector('.time-flatpickr'));
                    $('[name="visit_time"]').flatpickr({
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
                            url: '/getSelect?type=purpose&category=' + $('#category').val(),
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
                        var optionsS = {

                            url: function() {
                                return "getSelect?type=search_name&category=" + $('#category')
                                    .val() + "&name=" + $("input[name='visit_name']").val()
                            },

                            requestDelay: 100,
                            list: {
                                maxNumberOfElements: 10,
                                minNumberOfElements: 1,
                                match: {
                                    enabled: false
                                },
                                sort: {
                                    enabled: false
                                },

                            },

                        };
                        $("input[name='visit_name']").easyAutocomplete(optionsS);
                    });
                    $(document).on('change', '[name="visit_name"]', function(e) {
                        console.log("hh");
                        var category = $('#category').val()
                        var name = $(this).val()
                        jQuery.ajax({
                            url: '/getSelect?type=getData&category=' + category + "&name=" +
                                name,
                            type: 'GET',
                            dataType: "json",
                            success: function(data) {
                                console.log(data.data);

                                if (category === 251)
                                    $('[name="telephone"]').attr('value', data.data
                                    .mobile1);
                                else
                                    $('[name="telephone"]').attr('value', data.data
                                        .telephone);

                                $('[name="city_id"]').val(data.data.city_id).trigger(
                                    'change');


                            },
                            error: function(data) {
                                toastr.error('error', 'Errors', 'No Data for patient');
                            }

                        });


                    });
                    $("#employee").select2({
                        ajax: {
                            url: '/getSelect?type=employeeDepartment&department=' + $(
                                '[ name="department"]').val(),
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
                        $("#employee").select2({
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
@endpush
