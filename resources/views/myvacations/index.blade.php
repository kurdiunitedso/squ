@extends('metronic.index')

@section('title', 'vacations')
@section('subpageTitle', 'vacations')

@section('content')
    <!--begin::Content container-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header bvacation-0 pt-6">
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
                            <input type="text" data-col-index="name_code"
                                   data-kt-vacations-table-filter="search"
                                   class="form-control datatable-input form-control-solid w-250px ps-14"
                                   placeholder="Search vacations"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-vacations-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::vacations 1-->
                            <!--end::vacations 1-->
                            @include('myvacations._filter')


                            <a target="_blank" id="exportBtn" href="#"
                               data-export-url="{{ route('myvacations.export') }}" class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{__('Export')}}
                            </a>

                            <!--end::Filter-->
                            <!--begin::Add vacations-->
                            <button type="button" class="btn btn-primary" size="modal-xl" id="AddVacationModal">
                                <span class="indicator-label">
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                  rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                  fill="currentColor"/>
                                        </svg>
                                    </span>
                                    {{__('Add Vacation')}}
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-bvacation spinner-bvacation-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <!--end::Add vacations-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_vacation" tabindex="-1" aria-hidden="true">
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
                    <table class="table table-bvacationed align-middle table-row-dashed fs-6 gy-5"
                           id="kt_table_vacations">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-25px all"><input type="checkbox" id="select-all"></th>
                            <th class="all"></th>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Employee')}}</th>
                            <th>{{__('Type')}}</th>
                            <th>{{__('From Date')}}</th>
                            <th>{{__('To Date')}}</th>
                            <th>{{__('Days')}}</th>
                            <th>{{__('Balance')}}</th>
                            <th>{{__('Request date')}}</th>
                            <th>{{__('Status')}}</th>
                            <th class="mw-125px all">{{__('Action')}}</th>
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
    <div class="modal fade" id="kt_modal_vacations" tabindex="-1" aria-hidden="true">
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
        var selectedVacationsRows = [];
        var selectedVacationsData = [];
        const columnDefs = [
            {
                data: null,
                render: function (data, type, row, meta) {
                    var isChecked = selectedVacationsRows.includes(row.id.toString()) ? 'checked' : '';
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
            {
                data: function (row, type, set) {
                    if (type === 'display') {
                        if (row.employees)
                            return row.employees.name;
                    }
                    return '';
                },
                name: 'employees.name ',
            },
            {
                data: function (row, type, set) {
                    if (type === 'display') {
                        if (row.types)
                            return row.types.name;
                    }
                    return '';
                },
                name: 'types.name ',
            },
            {data: 'from_date', name: 'from_date'},
            {data: 'to_date', name: 'to_date'},
            {data: 'days', name: 'days'},
            {data: 'balance', name: 'balance'},
            {data: 'created_at', name: 'created_at'},
            {
                data: function (row, type, set) {
                    if (type === 'display') {
                        if (row.statuss)
                            return row.statuss.name;
                    }
                    return '';
                },
                name: 'statuss.name ',
            },
            {data: 'action', name: 'action'}
        ];
        var datatable = createDataTable('#kt_table_vacations', columnDefs, "{{ route('myvacations.index') }}", [
            [2, "DESC"]
        ]);
        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function () {
            KTMenu.createInstances();
        });

        $('#kt_table_vacations').find('#select-all').on('click', function () {
            $('#kt_table_vacations').find('.row-checkbox').click();
        });

        $('#kt_table_vacations tbody').on('click', '.row-checkbox', function () {
            var $row = $(this).closest('tr');
            var rowData = datatable.row($row).data();
            var rowIndex = selectedVacationsRows.indexOf(rowData.id);

            if (this.checked && rowIndex === -1) {
                selectedVacationsRows.push(rowData.id);
            } else if (!this.checked && rowIndex !== -1) {
                //console.log(data);
                selectedVacationsRows.splice(rowIndex, 1);

            }

            $row.toggleClass('selected');
            datatable.row($row).select(this.checked);
            if (selectedVacationsRows.length == 0)
                $('.selectedVacationsRowsCount').html("");
            else
                $('.selectedVacationsRowsCount').html("(" + selectedVacationsRows.length + ")");


            $('[name="selectedvacation"]').val(selectedVacationsRows.join(','));

        });

        // Restore selected rows when page changes
        datatable.on('draw.dt', function () {
            datatable.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                if (selectedVacationsRows.includes(rowData.id)) {
                    this.select();
                }
            });
        });

    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-vacations-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.columns(3).search(filterSearch.value).draw();
        }
    </script>



    <script>


        $(document).on('click', '.btnDeleteVacation', function (e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const vacationName = $(this).attr('data-vacation-name');
            Swal.fire({
                html: "Are you sure you want to delete " + vacationName + "?",
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
                        error: function (response, textRating_Captin,
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
            renderModal(
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
            const myUrlWithParams = new URL(url);

            const parameters = filterParameters();
            Object.keys(parameters).map((key) => {
                myUrlWithParams.searchParams.append(key, parameters[key]);
            });

            window.open(myUrlWithParams, "_blank");

        });

    </script>


    <script>
        $('.btnApprove').click(function () {
            if (selectedVacationsRows.length == 0) {
                Swal.fire({
                    text: "Please select at least one Vaction to visit Request",
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
                var url = $(this).attr("url")+'&selectedVacations='+selectedVacationsRows.join(',');
                console.log(url);
                $.ajax({
                    type: "GET",
                    url: url,
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
            }
        });

    </script>

    <script>
        $(function () {


            const validatorVacationFields = {};
            const RequiredInputListVacation = {
                'from_time': 'input',
                'to_time': 'input',
                'work_date': 'input',

            }

            const kt_modal_add_vacation = document.getElementById('kt_modal_add_vacation');
            const modal_kt_modal_add_vacation = new bootstrap.Modal(kt_modal_add_vacation);

            $(document).on('click', '#AddVacationModal', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                globalRenderModal(
                    "{{ route('myvacations.create', ['employee_id' => isset($employee) ? $employee->id : '' ]) }}",
                    $(this), '#kt_modal_add_vacation',
                    modal_kt_modal_add_vacation,
                    validatorVacationFields,
                    '#kt_modal_add_vacation_form',
                    datatable,
                    '[data-kt-vacations-modal-action="submit"]', RequiredInputListVacation);
            });


            $(document).on('click', '.btnUpdateVacation', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                const editURl = $(this).attr('href');

                globalRenderModal(editURl,
                    $(this), '#kt_modal_add_vacation',
                    modal_kt_modal_add_vacation,
                    validatorVacationFields,
                    '#kt_modal_add_vacation_form',
                    datatable,
                    '[data-kt-vacations-modal-action="submit"]', RequiredInputListVacation);
            });


            $(document).on('click', '.btnDeleteVacation', function (e) {
                e.preventDefault();
                const URL = $(this).attr('href');
                const vacationName = $(this).attr('data-vacation-name');
                Swal.fire({
                    text: "Are you sure you want to delete " + vacationName + "?",
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

        });
    </script>




@endpush
