@php
    use App\Models\Lead;
@endphp

@extends('metronic.index')

@section('title', Lead::ui['p_ucf'])
@section('subpageTitle', Lead::ui['p_ucf'])

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
                            <input type="text" data-col-index="search" data-kt-lead-table-filter="search"
                                class="form-control datatable-input form-control-solid w-250px ps-14"
                                placeholder="{{ t('Search ' . Lead::ui['s_ucf']) }}" />
                            <input type="hidden" name="selectedLead">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-lead-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::lead 1-->
                            <!--end::lead 1-->
                            @include('leads._filter')


                            <a target="_blank" id="exportBtn" href="#" data-export-url="{{ route('leads.export') }}"
                                class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{ __('Export') }}
                            </a>
                            <!--end::Filter-->
                            <!--begin::Add lead-->
                            <a href="{{ route('leads.create') }}" class="btn btn-primary" id="AddleadModal">
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
                                    {{ t('Add ' . Lead::ui['s_ucf']) }}
                                </span>
                                <span class="indicator-progress">
                                    {{ t('Please wait... ') }}<span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </a>
                            <!--end::Add lead-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_lead" tabindex="-1" aria-hidden="true">
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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_lead">
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
                                <th class="min-w-100px bold all">{{ __('Visit ID') }}</th>
                                <th class="min-w-100px bold ">{{ __('Manager Name') }}</th>
                                <th class="min-w-100px bold ">{{ __('Social Media') }}</th>
                                <th class="min-w-100px bold ">{{ __('Wheels') }}</th>
                                <th class="min-w-100px bold ">{{ __('Offer ID') }}</th>
                                <th class="min-w-100px bold ">{{ __('Offer Type') }}</th>
                                <th class="min-w-100px bold all">{{ __('Intersted') }}</th>
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





    {{--    @include('calls.call_drawer')
        @include('calls.questionnaire_logs_drawer')
        @include('sms.sms_drawer') --}}

@endsection


@push('scripts')
    <script>
        var selectedLeadRows = [];
        var selectedLeadData = [];

        const columnDefs = [{
                data: null,
                render: function(data, type, row, meta) {
                    var isChecked = selectedLeadRows.includes(row.id.toString()) ? 'checked' : '';
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
                            if (row.facility.name)
                                return row.facility.name;
                    }
                    return 'NA';
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
                name: 'facility.category',
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
                data: 'manager_name',
                name: 'manager_name',
            },
            {
                data: 'manager_social',
                name: 'manager_social',
            },
            {
                data: 'wheels',
                name: 'wheels',
            },
            {
                data: 'wheels',
                name: 'wheels',
            },
            {
                data: 'wheels',
                name: 'wheels',
            },
            {
                data: 'intersted',
                name: 'intersted',
            },
            {
                data: function(row, type, set) {
                    if (type === 'display') {
                        if (row.status)
                            return row.status.name;
                    }
                    return '';
                },
                name: 'status.name',
            },

            {
                data: 'action',
                name: 'action',
                className: 'text-end',
                orderable: false,
                searchable: false
            }
        ];
        var datatable = createDataTable('#kt_table_lead', columnDefs, "{{ route('leads.index') }}", [
            [2, "DESC"]
        ]);
        datatable.on('draw', function() {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function() {
            KTMenu.createInstances();
        });


        $('#kt_table_lead').find('#select-all').on('click', function() {
            $('#kt_table_lead').find('.row-checkbox').click();
        });

        $('#kt_table_lead tbody').on('click', '.row-checkbox', function() {
            var $row = $(this).closest('tr');
            var rowData = datatable.row($row).data();
            var rowIndex = selectedLeadRows.indexOf(rowData.id);

            if (this.checked && rowIndex === -1) {
                selectedLeadRows.push(rowData.id);
            } else if (!this.checked && rowIndex !== -1) {
                //console.log(data);
                selectedLeadRows.splice(rowIndex, 1);

            }

            $row.toggleClass('selected');
            datatable.row($row).select(this.checked);
            if (selectedLeadRows.length == 0)
                $('#selectedLeadRowsCount').html("");
            else
                $('#selectedLeadRowsCount').html("(" + selectedLeadRows.length + ")");


            $('[name="selectedLead"]').val(selectedLeadRows.join(','));

        });

        // Restore selected rows when page changes
        datatable.on('draw.dt', function() {
            datatable.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                if (selectedLeadRows.includes(rowData.id)) {
                    this.select();
                }
            });
        });
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-lead-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.draw();
        }
    </script>
    {{--    @include('calls.scripts')
        @include('sms.scripts') --}}

    <script>
        var lead_calls_card = document.querySelector(".lead_calls_card");
        var blockUI_lead_calls_card = new KTBlockUI(lead_calls_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });

        var lead_calls_questionnaire_logs_card = document.querySelector(".lead_calls_questionnaire_logs_card");
        var blockUI_lead_calls_questionnaire_logs_card = new KTBlockUI(lead_calls_questionnaire_logs_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });


        $(document).on('click', '.btnDeletelead', function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const leadName = $(this).attr('data-lead-name');
            Swal.fire({
                html: "Are you sure you want to delete " + leadName + "?",
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
    </script>
    {{--    <script>


            function refreshLeadCalls(url) {
                $(lead_calls_card).find('.card-body').html('');

                blockUI_lead_calls_card.block();

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $(lead_calls_card).find('.card-title span').text(response
                            .leadName);
                        $(lead_calls_card).find('.card-body').html(response.drawerView);

                    },
                    complete: function () {
                        blockUI_lead_calls_card.release();
                    }

                });

            }

            $(document).ready(function () {
                $(document).on('click', '.showCalls', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    var drawerElement = document.querySelector("#kt_drawer_showCalls");
                    var drawer = KTDrawer.getInstance(drawerElement);
                    drawer.show();
                    refreshLeadCalls(url);
                });
            });
        </script> --}}
    {{--  <script>
          var lead_reigster_history_card = document.querySelector(".lead_reigster_history_card");
          var blockUI_lead_reigster_history_card = new KTBlockUI(lead_reigster_history_card, {
              message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
          });

          function refreshRegisterHistoryTable(url) {


              $(lead_reigster_history_card).find('.card-body').html('');

              blockUI_lead_reigster_history_card.block();

              $.ajax({
                  type: "GET",
                  url: url,
                  dataType: "json",
                  success: function (response) {
                      $(lead_reigster_history_card).find('.card-title span').text(response
                          .leadName);
                      $(lead_reigster_history_card).find('.card-body').html(response
                          .drawerView);
                      $(lead_reigster_history_card).attr('data-url', url);
                  },
                  complete: function () {
                      blockUI_lead_reigster_history_card.release();
                  }
              });
          }

          $(function () {
              $(document).on('click', '.showRegisterHistory', function (e) {
                  e.preventDefault();
                  const url = $(this).attr('href');
                  var drawerElement = document.querySelector("#kt_drawer_register_history");
                  var drawer = KTDrawer.getInstance(drawerElement);
                  drawer.show();
                  refreshRegisterHistoryTable(url);
              });
              $(document).on('click', '.btnShowQuestionnaireLog', function (e) {
                  e.preventDefault();
                  $button = $(this);
                  const url = $(this).attr('href');
                  $(this).attr("disabled", "disabled");

                  $(lead_calls_questionnaire_logs_card).find('.card-body').html('');
                  blockUI_lead_calls_questionnaire_logs_card.block();

                  var drawerQuestionnaireElement = document.querySelector(
                      "#kt_drawer_questionnaireLogs");
                  var drawerQ = KTDrawer.getInstance(
                      drawerQuestionnaireElement);
                  drawerQ.show();


                  $.ajax({
                      type: "GET",
                      url: url,
                      dataType: "json",
                      success: function (response) {
                          $(lead_calls_questionnaire_logs_card).find(
                              '.card-title span').text(response
                              .leadName);
                          $(lead_calls_questionnaire_logs_card)
                              .find('.card-body').html(response
                              .drawerView);

                      },
                      complete: function () {
                          blockUI_lead_calls_questionnaire_logs_card
                              .release();
                          setTimeout(
                              '$button.removeAttr("disabled")',
                              1500);
                      }
                  });

              });
          });
      </script> --}}
    {{--    <script>
            var lead_smses_card = document.querySelector(".lead_smses_card");
            var blockUI_lead_smses_card = new KTBlockUI(lead_smses_card, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
            });
            $(document).ready(function () {
                $(document).on('click', '.showSms', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    var drawerElement = document.querySelector("#kt_drawer_showSms");
                    var drawer = KTDrawer.getInstance(drawerElement);
                    drawer.show();

                    $(lead_smses_card).find('.card-body').html('');

                    blockUI_lead_smses_card.block();

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "json",
                        success: function (response) {
                            // console.log(response);
                            $(lead_smses_card).find('.card-title span').text(response
                                .leadName);
                            $(lead_smses_card).find('.card-body').html(response.drawerView);
                            blockUI_lead_smses_card.release();
                        },
                        complete: function () {
                            // blockUI.release();
                        }

                    });

                });
            });
        </script> --}}
    {{--    <script>
            const kt_modal_visits = document.getElementById('kt_modal_visits');
            const modal_kt_modal_visits = new bootstrap.Modal(kt_modal_visits);

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


            var lead_call_sms_logs = document.querySelector(".lead_call_sms_logs");
            var blockUI_lead_call_sms_logs = new KTBlockUI(lead_call_sms_logs, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
            });
            $(document).ready(function () {
                $(document).on('click', '.ShowLeadCallsSmsLogs', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    var drawerElement = document.querySelector("#kt_drawer_lead_call_sms_logs");
                    var drawer = KTDrawer.getInstance(drawerElement);
                    drawer.show();

                    $(lead_call_sms_logs).find('.card-body').html('');

                    blockUI_lead_call_sms_logs.block();

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "json",
                        success: function (response) {
                            // console.log(response);
                            $(lead_call_sms_logs).find('.card-title span').text(response
                                .leadName);
                            $(lead_call_sms_logs).find('.card-body').html(response.drawerView);
                        },
                        complete: function () {
                            blockUI_lead_call_sms_logs.release();
                            // blockUI.release();
                        }

                    });

                });
            });
        </script>
        <script>
            $('#btnAddVisitRequest').click(function () {
                if (selectedLeadRows.length == 0) {
                    Swal.fire({
                        text: "Please select at least one Lead to visit Request",
                        icon: "error",
                        showCancelButton: false,
                        showConfirmButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                        }
                    });

                } else {
                    selectedData = datatable.rows('.selected').data().toArray();
                    var url = $(this).attr("url") + '?&visit_category=251&selectedLead=' + selectedLeadRows.join(',');
                    renderAModal(url,
                        $(this), '#kt_modal_visits',
                        modal_kt_modal_visits,
                        [],
                        '#kt_modal_add_visit_form',
                        datatable,
                        '[data-kt-visit-modal-action="submit"]');

                    //modal_kt_modal_call_schedules.show();
                    console.log(selectedData);
                }
            });

        </script> --}}
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
                    $('[name="purpose"]').select2({
                        dropdownParent: $(modalId),
                        allowClear: true,
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
                            dropdownParent: $(modalId),
                            allowClear: true,
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
                        dropdownParent: $(modalId),
                        allowClear: true,

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
                            dropdownParent: $(modalId),
                            allowClear: true,
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


        $(document).on('click', '.btnUpdatevisit', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');
            var size = $(this).attr("size");
            $('#kt_modal_visits').find('.modal-dialog').removeClass('modal-xl');
            $('#kt_modal_visits').find('.modal-dialog').removeClass('modal-sm');
            $('#kt_modal_visits').find('.modal-dialog').removeClass('modal-lg');
            $('#kt_modal_visits').find('.modal-dialog').addClass(size);

            renderAModal(editURl,
                $(this), '#kt_modal_visits',
                modal_kt_modal_visits,
                validatorVisitFields,
                '#kt_modal_add_visit_form',
                datatable,
                '[data-kt-visit-modal-action="submit"]');
        });
    </script>
@endpush
