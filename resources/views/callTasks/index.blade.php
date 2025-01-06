@extends('metronic.index')

@section('title', 'Calls Task')
@section('subpageTitle', 'Calls Task')

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
                                          rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-col-index="client_name" data-kt-Calls-table-filter="search"
                                   class="form-control datatable-input form-control-solid w-350px ps-14"
                                   placeholder="Search By Name, ID No., Mobile"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-Calls-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::Calls 1-->
                            <!--end::Calls 1-->
                            <!--end::Filter-->

                            @include('callTasks._filter')

                            <a target="_blank" id="exportBtn" href="#"
                               data-export-url="{{ route('call_tasks.export') }}"
                               class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> Export
                            </a>


                            <!--end::Add Calls-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_Calls" tabindex="-1" aria-hidden="true">
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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_Calls">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="all">ID</th>
                            <th class="all">Call Date</th>
                            <th class="all">Call Type</th>
                            <th class="all">Name</th>
                            <th class="all">City</th>
                            <th class="all">Telephone</th>
                            <th class="all">Employee - Call Center</th>
                            <th class="all">Action</th>
                            <th class="all">Notes By Call Center</th>
                            <th class="all">Notes Of Employee</th>
                            <th class="all">Urgency</th>
                            <th class="all">Listen</th>
                            <th class="all"> Status</th>
                            <th class="all">Actions</th>
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
    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_calls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_ActionCall" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_shortMessages" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

    @include('calls_call_tasks.call_drawer')
    @include('calls_call_tasks.questionnaire_logs_drawer')
    @include('sms_call_tasks.sms_drawer')

@endsection


@push('scripts')
    @include('calls_call_tasks.scripts')
    @include('sms_call_tasks.scripts')
    <script>

        const columnDefs = [{
            data: 'id',
            name: 'id',
            orderable: false,
        },
            {
                data: {
                    _: 'created_at.display',
                    sort: 'created_at.timestamp',
                },
                name: 'created_at',
                searchable: false,
            },
            {
                data: 'call_caller_name',
                name: 'call_caller_name',
            },
            {
                data: 'call.client_name',
                name: 'call.client_name',

            },
            {
                data:'call_city_name',
                name: 'call_city_name',

            },
            {
                data: 'call.telephone',
                name: 'call.telephone',

            },

            {
                data: 'call_employee_name',
                name: 'call_employee_name',
            },
            {
                data: 'call_callOption_name',
                name: 'call_callOption_name',
            },
            {
                data: 'call.notes',
                name: 'call.notes',
            },
            {
                data: 'task_notes',
                name: 'task_notes',
            },

            {
                data: 'task_urgencys.name',
                name: 'task_urgencys.name',
            },


            {
                data: 'listen',
                name: 'listen',

                nullable: true,
            },

            {
                data: 'task_statuss.name',
                name: 'task_statuss.name',
            },
            {
                data: 'action',
                name: 'action',
                className: 'text-end',
                orderable: false,
                searchable: false,
            }
        ];
        var datatable = createDataTable('#kt_table_Calls', columnDefs, "{{ route('call_tasks.index') }}", [
            [0, "DESC"]
        ]);
        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function () {
            KTMenu.createInstances();
        });
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-Calls-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.columns(3).search(filterSearch.value).draw();
        }
    </script>


    <script>
        $(document).on('click', '.btnDeleteCallTask', function (e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const clientCallActionName = $(this).attr('data-callTask-name');
            Swal.fire({
                text: "Are you sure you want to delete " + clientCallActionName + "?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: URL,
                        dataType: "json",
                        success: function (response) {
                            datatable.ajax.reload(null, false);
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        complete: function () {
                        },
                        error: function (response, textStatus,
                                         errorThrown) {
                            toastr.error(response
                                .responseJSON
                                .message);
                        },
                    });

                } else if (result.dismiss === 'cancel') {
                }

            });
        });
    </script>

    <script>
        $(document).on('click', '#filterBtn', function (e) {
            e.preventDefault();
            datatable.ajax.reload();
        });

        $(document).on('click', '#resetFilterBtn', function (e) {
            e.preventDefault();
            $('#filter-form').trigger('reset');
            $('.datatable-input').each(function () {
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

        $(document).on('click', '#exportBtn', function (e) {
            e.preventDefault();
            const url = $(this).data('export-url');
            const myUrlWithParams = new URL(url);

            const parameters = filterParameters();
            Object.keys(parameters).map((key) => {
                myUrlWithParams.searchParams.append(key, parameters[key]);
            });

            window.open(myUrlWithParams, "_blank");

        });
        const kt_modal_ActionCall = document.getElementById('kt_modal_ActionCall');
        const modal_kt_modal_ActionCall = new bootstrap.Modal(kt_modal_ActionCall);
        const validatorActionCallFields = {};
        const RequiredInputListActionCall = {
            'action_employee': 'select',


        }


        $(document).on('click', '.btnAction', function (e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var href = $(this).attr("href");
            globalRenderModal(
                href,
                $(this), '#kt_modal_ActionCall',
                modal_kt_modal_ActionCall,
                validatorActionCallFields,
                '#kt_modal_ActionCall_form',
                datatable,
                '[data-kt-ActionCall-modal-action="submit"]', RequiredInputListActionCall);
        });

    </script>
    <script>

        var callTask_calls_card = document.querySelector(".call_task_calls_card");
        var blockUI_callTask_calls_card = new KTBlockUI(callTask_calls_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });


        var callTasks_calls_questionnaire_logs_card = document.querySelector(".call_task_calls_questionnaire_logs_card");
        var blockUI_callTasks_calls_questionnaire_logs_card = new KTBlockUI(callTasks_calls_questionnaire_logs_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });

        function refreshCallTaskCalls(url) {
            $(callTask_calls_card).find('.card-body').html('');

            blockUI_callTask_calls_card.block();

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $(callTask_calls_card).find('.card-title span').text(response
                        .callTaskName);
                    $(callTask_calls_card).find('.card-body').html(response.drawerView);

                },
                complete: function () {
                    blockUI_callTask_calls_card.release();
                }

            });

        }
        $(document).on('click', '.btnShowQuestionnaireLog', function (e) {
            e.preventDefault();
            $button = $(this);
            const url = $(this).attr('href');
            $(this).attr("disabled", "disabled");

            $(callTasks_calls_questionnaire_logs_card).find('.card-body').html('');
            blockUI_callTasks_calls_questionnaire_logs_card.block();

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
                    $(callTasks_calls_questionnaire_logs_card).find(
                        '.card-title span').text(response
                        .callTasksName);
                    $(callTasks_calls_questionnaire_logs_card)
                        .find('.card-body').html(response
                        .drawerView);

                },
                complete: function () {
                    blockUI_callTasks_calls_questionnaire_logs_card
                        .release();
                    setTimeout(
                        '$button.removeAttr("disabled")',
                        1500);
                }
            });

        });
        $(document).ready(function () {
            $(document).on('click', '.showCalls', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                var drawerElement = document.querySelector("#kt_drawer_showCalls");
                var drawer = KTDrawer.getInstance(drawerElement);
                drawer.show();
                refreshCallTaskCalls(url);
            });
        });
    </script>

@endpush
