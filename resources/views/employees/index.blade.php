@extends('metronic.index')

@section('title', 'Employees')
@section('subpageTitle', 'Employees')

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
                            <input type="text" data-col-index="search"
                                   data-kt-employees-table-filter="search"
                                   class="form-control datatable-input form-control-solid w-250px ps-14"
                                   placeholder="Search Employees"/>
                            <input type="hidden" name="selectedEmployee">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-employees-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::employees 1-->
                            <!--end::employees 1-->
                            @include('employees._filter')


                            <a target="_blank" id="exportBtn" href="#"
                               data-export-url="{{ route('employees.export') }}" class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{__('Export')}}
                            </a>

                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_employees" tabindex="-1" aria-hidden="true">
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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_employees">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-25px all"><input type="checkbox" id="select-all"></th>
                            <th class="all"></th>
                            <th class="all">{{__('ID')}}</th>
                            <th class="all">{{__('Name')}}</th>
                            <th class="all">{{__('Mobile')}}</th>
                            <th class="all">{{__('Email')}}</th>
                            <th class="all">{{__('Project')}}</th>
                            <th class="all">{{__('Username')}}</th>

                            <th class="all">{{__('Balance')}}</th>

                            <th class="all">{{__('Status')}}</th>
                            <th class="tblaction-rg tblaction-three-rg">{{__('Edit')}}</th>

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

    <div class="modal fade" id="kt_modal_calls" tabindex="-1" aria-hidden="true">
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
        var selectedEmployeesRows = [];
        var selectedEmployeesData = [];

        const columnDefs =
            [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        var isChecked = selectedEmployeesRows.includes(row.id.toString()) ? 'checked' : '';
                        return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                    },
                    orderable: false,

                },
                {
                    className: 'dt-row',
                    orderable: false,
                    target: -1,
                    data: null,
                    render: function (data, type, row, meta) {
                        return '<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px"><span class="la la-list-ul"></span></a>';

                    }
                },
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email'},

                {data: 'projects', name: 'id'},

                {
                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.user)
                                return row.user.email;
                        }
                        return '';
                    },
                    name: 'user.email'
                },

                {data: 'balance', name: 'balance'},

                {data: 'active', name: 'active'},
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-end',
                    orderable: false,
                    searchable: false
                },

            ];
        var datatable = createDataTable('#kt_table_employees', columnDefs, "{{ route('employees.index') }}", [
            [0, "ASC"]
        ]);
        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function () {
            KTMenu.createInstances();
        });


        $('#kt_table_employees').find('#select-all').on('click', function () {
            $('#kt_table_employees').find('.row-checkbox').click();
        });

        $('#kt_table_employees tbody').on('click', '.row-checkbox', function () {
            var $row = $(this).closest('tr');
            var rowData = datatable.row($row).data();
            var rowIndex = selectedEmployeesRows.indexOf(rowData.id);

            if (this.checked && rowIndex === -1) {
                selectedEmployeesRows.push(rowData.id);
            } else if (!this.checked && rowIndex !== -1) {
                //console.log(data);
                selectedEmployeesRows.splice(rowIndex, 1);

            }

            $row.toggleClass('selected');
            datatable.row($row).select(this.checked);
            if (selectedEmployeesRows.length == 0)
                $('#selectedEmployeesRowsCount').html("");
            else
                $('#selectedEmployeesRowsCount').html("(" + selectedEmployeesRows.length + ")");


            $('[name="selectedEmployee"]').val(selectedEmployeesRows.join(','));

        });

        // Restore selected rows when page changes
        datatable.on('draw.dt', function () {
            datatable.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                if (selectedEmployeesRows.includes(rowData.id)) {
                    this.select();
                }
            });
        });

    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-employees-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.draw();
        }
    </script>


    <script>

        var employee_calls_card = document.querySelector(".employee_calls_card");
        var blockUI_employee_calls_card = new KTBlockUI(employee_calls_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });

        var employee_calls_questionnaire_logs_card = document.querySelector(".employee_calls_questionnaire_logs_card");
        var blockUI_employee_calls_questionnaire_logs_card = new KTBlockUI(employee_calls_questionnaire_logs_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });


        $(document).on('click', '.btnDeleteemployee', function (e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const employeeName = $(this).attr('data-employee-name');
            Swal.fire({
                html: "Are you sure you want to delete " + employeeName + "?",
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



    <script>


        function refreshEmployeeCalls(url) {
            $(employee_calls_card).find('.card-body').html('');

            blockUI_employee_calls_card.block();

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $(employee_calls_card).find('.card-title span').text(response
                        .employeeName);
                    $(employee_calls_card).find('.card-body').html(response.drawerView);

                },
                complete: function () {
                    blockUI_employee_calls_card.release();
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
                refreshEmployeeCalls(url);
            });
        });
    </script>
    <script>
        var employee_reigster_history_card = document.querySelector(".employee_reigster_history_card");
        var blockUI_employee_reigster_history_card = new KTBlockUI(employee_reigster_history_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });

        function refreshRegisterHistoryTable(url) {


            $(employee_reigster_history_card).find('.card-body').html('');

            blockUI_employee_reigster_history_card.block();

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    $(employee_reigster_history_card).find('.card-title span').text(response
                        .employeeName);
                    $(employee_reigster_history_card).find('.card-body').html(response
                        .drawerView);
                    $(employee_reigster_history_card).attr('data-url', url);
                },
                complete: function () {
                    blockUI_employee_reigster_history_card.release();
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

                $(employee_calls_questionnaire_logs_card).find('.card-body').html('');
                blockUI_employee_calls_questionnaire_logs_card.block();

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
                        $(employee_calls_questionnaire_logs_card).find(
                            '.card-title span').text(response
                            .employeeName);
                        $(employee_calls_questionnaire_logs_card)
                            .find('.card-body').html(response
                            .drawerView);

                    },
                    complete: function () {
                        blockUI_employee_calls_questionnaire_logs_card
                            .release();
                        setTimeout(
                            '$button.removeAttr("disabled")',
                            1500);
                    }
                });

            });
        });
    </script>



    <script>
        var employee_smses_card = document.querySelector(".employee_smses_card");
        var blockUI_employee_smses_card = new KTBlockUI(employee_smses_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });
        $(document).ready(function () {
            $(document).on('click', '.showSms', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                var drawerElement = document.querySelector("#kt_drawer_showSms");
                var drawer = KTDrawer.getInstance(drawerElement);
                drawer.show();

                $(employee_smses_card).find('.card-body').html('');

                blockUI_employee_smses_card.block();

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $(employee_smses_card).find('.card-title span').text(response
                            .employeeName);
                        $(employee_smses_card).find('.card-body').html(response.drawerView);
                        blockUI_employee_smses_card.release();
                    },
                    complete: function () {
                        // blockUI.release();
                    }

                });

            });
        });
    </script>

@endpush
