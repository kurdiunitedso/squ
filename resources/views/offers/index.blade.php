@php
    use App\Models\Contract;
@endphp
@extends('metronic.index')

@section('title', 'Offer')
@section('subpageTitle', 'Offer')

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
                            <input type="text" data-col-index="search" data-kt-offer-table-filter="search"
                                class="form-control datatable-input form-control-solid w-250px ps-14"
                                placeholder="Search Offer" />
                            <input type="hidden" name="selectedOffer">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-offer-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::offer 1-->
                            <!--end::offer 1-->
                            @include('offers._filter')


                            <a target="_blank" id="exportBtn" href="#" data-export-url="{{ route('offers.export') }}"
                                class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{ __('Export') }}
                            </a>
                            <!--end::Filter-->
                            <!--begin::Add offer-->
                            <a href="{{ route('offers.create') }}" class="btn btn-primary" id="AddofferModal">
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
                                    {{ __('Add Offer') }}
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </a>
                            <!--end::Add offer-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_offer" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">

                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-lg modal-dialog-centered ">

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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_offer">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-25px all"><input type="checkbox" id="select-all"></th>
                                <th class="all"></th>
                                <th class="min-w-100px bold all">{{ __('SN') }}</th>
                                <th class="min-w-250px bold all">{{ __('Facility Name') }}</th>
                                <th class="min-w-100px bold all">{{ __('Facility Type') }}</th>
                                <th class="min-w-100px bold all">{{ __('Facility Telephone') }}</th>
                                <th class="min-w-100px bold ">{{ __('Visit ID') }}</th>
                                <th class="min-w-100px bold all">{{ __('Items') }}</th>
                                <th class="min-w-100px bold all">{{ __('Offer Type') }}</th>
                                <th class="min-w-100px bold ">{{ __('Wheels') }}</th>
                                <th class="min-w-100px bold all">{{ __('Duration') }}</th>
                                <th class="min-w-100px bold all">{{ __('Discount') }}</th>
                                <th class="min-w-100px bold all">{{ __('Total Cost') }}</th>
                                <th class="min-w-100px bold all">{{ __('Contract ID#') }}</th>
                                <th class="min-w-100px bold all">{{ __('Status') }}</th>
                                <th class="min-w-100px bold all">{{ __('Action') }}</th>

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
    <div class="modal fade" id="kt_modal_showCalls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl ">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_showItem" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl ">

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
    <div class="modal fade" id="kt_modal_visits" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
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
    <div class="modal fade" id="kt_modal_sendEmails" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl ">

        </div>
        <!--end::Modal dialog-->
    </div>




    {{--    @include('calls.call_drawer')
        @include('calls.questionnaire_logs_drawer')
        @include('sms.sms_drawer') --}}

@endsection


@push('scripts')
    <script>
        var selectedOfferRows = [];
        var selectedOfferData = [];
        var initial = true;
        const columnDefs = [{
                data: null,
                render: function(data, type, row, meta) {
                    var isChecked = selectedOfferRows.includes(row.id.toString()) ? 'checked' : '';
                    return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                },
                orderable: false,

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
                data: 'id',
                name: 'id',
            },
            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.facility)
                            return row.facility.name;
                    }
                    return '';
                },
                name: 'facility.name',
            },
            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.facility)
                            if (row.facility.category)
                                return row.facility.category.name;
                    }
                    return '';
                },
                name: 'facility.category.name',
            },
            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.facility)
                            return row.facility.telephone;
                    }
                    return '';
                },
                name: 'facility.telephone',
            },
            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.visit)
                            return row.visit.id;
                    }
                    return '';
                },
                name: 'visit.id',
            },
            {
                data: 'items_count',
                name: 'items_count',
            },

            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.type)
                            return row.type.name;
                    }
                    return '';
                },
                name: 'type.name',
            },
            {
                data: 'wheels',
                name: 'wheels',
            },
            {
                data: 'duration',
                name: 'duration',
            },

            {
                data: 'discount',
                name: 'discount',
            },
            {
                data: 'total_cost',
                name: 'total_cost',
            },

            {
                data: 'contract.name',
                name: 'contract.name',
                render: function(data, type, row) {
                    return row.contract?.id || 'NA';
                }
            },
            {
                data: row => row.status || 'NA',
                name: `status.name`
            },
            {
                data: 'action',
                name: 'action',
                className: 'text-end',
                orderable: false,
                searchable: false
            }


        ];
        var datatable = createDataTable('#kt_table_offer', columnDefs, "{{ route('offers.index') }}", [
            [2, "DESC"]
        ]);
        datatable.on('draw', function() {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function() {
            KTMenu.createInstances();
        });


        $('#kt_table_offer').find('#select-all').on('click', function() {
            $('#kt_table_offer').find('.row-checkbox').click();
        });

        $('#kt_table_offer tbody').on('click', '.row-checkbox', function() {
            var $row = $(this).closest('tr');
            var rowData = datatable.row($row).data();
            var rowIndex = selectedOfferRows.indexOf(rowData.id);

            if (this.checked && rowIndex === -1) {
                selectedOfferRows.push(rowData.id);
            } else if (!this.checked && rowIndex !== -1) {
                //console.log(data);
                selectedOfferRows.splice(rowIndex, 1);

            }

            $row.toggleClass('selected');
            datatable.row($row).select(this.checked);
            if (selectedOfferRows.length == 0)
                $('#selectedOfferRowsCount').html("");
            else
                $('#selectedOfferRowsCount').html("(" + selectedOfferRows.length + ")");


            $('[name="selectedOffer"]').val(selectedOfferRows.join(','));

        });

        // Restore selected rows when page changes
        datatable.on('draw.dt', function() {
            datatable.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                if (selectedOfferRows.includes(rowData.id)) {
                    this.select();
                }
            });
        });
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-offer-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.draw();
        }
    </script>
    {{--    @include('calls.scripts')
        @include('sms.scripts') --}}


    {{-- <script>
        // Status change click handler
        $(document).on('click', '.btnChangeStatus' + "{{ $_model::ui['s_ucf'] }}", function(e) {
            e.preventDefault();
            const button = $(this);
            button.attr("data-kt-indicator", "on");
            const url = button.attr('href');

            globalRenderModal(url,
                $(this), '#kt_modal_add_item',
                modal_kt_modal_add_item,
                validatorItemFields,
                '#kt_modal_add_item_form',
                datatableItem,
                '[data-kt-items-modal-action="submit"]',
                RequiredInputListItem);

            // ModalRenderer.render({
            //     url: url,
            //     button: button,
            //     modalId: '#kt_modal_general_sm',
            //     modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general_sm')),
            //     formId: '#kt_modal_change_status_form',
            //     dataTableId: datatable,
            //     submitButtonName: '[data-kt-change-status-modal-action="submit"]',
            // });


        });
    </script> --}}

    <script>
        $(document).on('click', '.btnDeleteoffer', function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const offerName = $(this).attr('data-offer-name');
            Swal.fire({
                html: "Are you sure you want to delete " + offerName + "?",
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
                        error: function(response, textStatus,
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

        const validatorEmailFields = {
            'to': {
                validators: {
                    notEmpty: {
                        message: 'Fill To '
                    }
                }
            },
            'text': {
                validators: {
                    notEmpty: {
                        message: 'Fill Text '
                    }
                }
            },
            'subject': {
                validators: {
                    notEmpty: {
                        message: 'Fill subject '
                    }
                }
            }

        };

        const RequiredInputListEmail = {
            'to': 'input',
            'subject': 'input',
            'text': 'input',

        }
        const kt_modal_sendEmails = document.getElementById('kt_modal_sendEmails');
        const modal_kt_modal_sendEmails = new bootstrap.Modal(kt_modal_sendEmails);

        $(document).on('click', '.sendEmail', function(e) {

            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var href = $(this).attr("link");
            renderAModal(
                href,
                $(this), '#kt_modal_sendEmails',
                modal_kt_modal_sendEmails,
                validatorEmailFields,
                '#kt_modal_add_email_form',
                datatable,
                '[data-kt-emails-modal-action="submit"]', RequiredInputListEmail);

        });
        $(document).on('click', '.btn_add_{{ Contract::ui['s_lcf'] }}', function(e) {
            e.preventDefault();
            var href = $(this).attr("href");

            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Create Contract',
                text: 'Are you sure you want to create contract for this offer?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, create it!',
                cancelButtonText: 'No, cancel',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with the AJAX request
                    $.post(href, {
                            _token: $('meta[name="csrf-token"]').attr('content')
                            // Add other data here if needed
                        })
                        .done(function(response) {
                            console.log('Success:', response);
                            datatable.ajax.reload();

                            // Show success message
                            Swal.fire({
                                title: 'Created!',
                                text: 'Contract has been created successfully.',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        })
                        .fail(function(error) {
                            handleAjaxErrors(error);

                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to create contract.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        });
                }
            });
        });
    </script>
    <script>
        const kt_modal_showItem = document.getElementById('kt_modal_showItem');
        const modal_kt_modal_showItem = new bootstrap.Modal(kt_modal_showItem);

        $(document).on('click', '.viewItem', function(e) {

            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var href = $(this).attr("href");
            renderAModal(
                href,
                $(this), '#kt_modal_showItem',
                modal_kt_modal_showItem, null, null, datatable, null, null, null, $(this).attr('data_id'));
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
            console.log(url);
            const myUrlWithParams = new URL(url);

            const parameters = filterParameters();
            //myUrlWithParams.searchParams.append('params',JSON.stringify( parameters))
            Object.keys(parameters).map((key) => {
                myUrlWithParams.searchParams.append(key, parameters[key]);
            });
            console.log(myUrlWithParams);
            window.open(myUrlWithParams, "_blank");

        });

        $('#kt_modal_showItem').on('hidden.bs.modal', function() {
            datatable.ajax.reload();
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');

            // Refresh the DataTable

        });
        $('#kt_modal_add_item').on('hidden.bs.modal', function() {
            // Ensure any lingering backdrop is removed
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');

            datatable.ajax.reload();
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

                    if (validatorFields) {
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
                    } else
                        validator = null;


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
                            if (validator)
                                validator.addField(key, NameValidators);
                            // validator.addField($(this).find('.constantNames').attr('name'),
                            //                         NameValidators);
                        }

                    }

                    // Submit button handler
                    if (submitButtonName != null) {
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
                    }

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
                    $('[name="purpose"]').select2({
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
                        $('[name="purpose"]').select2({
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
                    if (modalId == '#kt_modal_showItem') {

                        var filterSearchItems = document.querySelector('[data-kt-items-table-filter="search"]');
                        filterSearchItems.onkeydown = debounce(keyPressCallback, 400);

                        function keyPressCallback() {
                            datatableItem.columns(1).search(filterSearchItems.value).draw();
                        }

                        var initItems = (function() {


                            return function() {


                                executed = true;
                                const columnDefs = [{
                                        data: 'id',
                                        name: 'id',
                                    },
                                    {
                                        data: 'description',
                                        name: 'description',
                                    },
                                    {
                                        data: 'notes',
                                        name: 'notes',
                                    },
                                    {
                                        data: 'cost',
                                        name: 'cost',
                                    },
                                    {
                                        data: 'qty',
                                        name: 'qty',
                                    },
                                    {
                                        data: 'discount',
                                        name: 'discount',
                                    },
                                    {
                                        data: 'total_cost',
                                        name: 'total_cost',
                                    },


                                    {
                                        data: 'action',
                                        name: 'action',
                                        className: 'text-end',
                                        orderable: false,
                                        searchable: false
                                    }
                                ];
                                datatableItem = createDataTable('#kt_table_items', columnDefs,
                                    "offers/" + data_id + "/offerItem",
                                    [
                                        [0, "ASC"]
                                    ]);
                                datatableItem.on('xhr', function(e, settings, json) {

                                    let c = parseInt(json['offer_total_cost']);
                                    let d = parseInt($('#total_discount').val()) ? parseInt(
                                        $('#total_discount').val()) : 0;
                                    console.log(c);
                                    console.log(d);
                                    $('#offer_total_cost').val(c - d);


                                });

                            };
                        })();

                        initItems();

                        $(function() {


                            const validatorItemFields = {};
                            const RequiredInputListItem = {
                                'address': 'input',
                                'telephone': 'input',
                                'city_id': 'select',
                                'floor': 'select',
                                'fax': 'input',

                            }

                            const kt_modal_add_item = document.getElementById('kt_modal_add_item');
                            const modal_kt_modal_add_item = new bootstrap.Modal(kt_modal_add_item);

                            $(document).on('click', '#AddItemModal', function(e) {
                                e.preventDefault();
                                $(this).attr("data-kt-indicator", "on");
                                renderAModal(
                                    "offers/addItem?offer_id=" + data_id,
                                    $(this), '#kt_modal_add_item',
                                    modal_kt_modal_add_item,
                                    validatorItemFields,
                                    '#kt_modal_add_item_form',
                                    datatableItem,
                                    '[data-kt-items-modal-action="submit"]',
                                    RequiredInputListItem);
                            });


                            $(document).on('click', '.btnUpdateItem', function(e) {
                                e.preventDefault();
                                $(this).attr("data-kt-indicator", "on");
                                const editURl = $(this).attr('href');

                                globalRenderModal(editURl,
                                    $(this), '#kt_modal_add_item',
                                    modal_kt_modal_add_item,
                                    validatorItemFields,
                                    '#kt_modal_add_item_form',
                                    datatableItem,
                                    '[data-kt-items-modal-action="submit"]',
                                    RequiredInputListItem);
                            });


                            $(document).on('click', '.btnDeleteItem', function(e) {
                                e.preventDefault();
                                const URL = $(this).attr('href');
                                const itemName = $(this).attr('data-item-name');
                                Swal.fire({
                                    text: "Are you sure you want to delete " +
                                        itemName + "?",
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
                                                datatableItem.ajax.reload(
                                                    null, false);
                                                Swal.fire({
                                                    text: response
                                                        .message,
                                                    icon: "success",
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            },
                                            complete: function() {},
                                            error: function(response,
                                                textStatus,
                                                errorThrown) {
                                                toastr.error(response
                                                    .responseJSON
                                                    .message);
                                            },
                                        });

                                    } else if (result.dismiss === 'cancel') {}

                                });
                            });

                        });

                    }
                }
            });


        }
    </script>
@endpush
