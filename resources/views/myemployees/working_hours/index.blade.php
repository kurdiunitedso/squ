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
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                  height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                  fill="currentColor"/>
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="currentColor"/>
                                        </svg>
                                    </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-whours-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="Search Whours"/>
                    </div>

                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-whours-table-toolbar="base">

                        <div class="d-flex justify-content-end" data-kt-employees-table-toolbar="base">
                            <a href="#" class="btn btn-primary" id="AddWhourModal">
                                        <span class="indicator-label">
                                            <span class="svg-icon svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                                          height="2" rx="1"
                                                          transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                                    <rect x="4.36396" y="11.364" width="16" height="2"
                                                          rx="1" fill="currentColor"/>
                                                </svg>
                                            </span>
                                            {{__('Add')}}
                                        </span>
                                <span class="indicator-progress">
                                            Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                            </a>


                            @include('myemployees.working_hours._filter')

                        </div>

                    </div>

                    </div>

                    <!--end::Toolbar-->

                    <!--begin::Modal - Add task-->

                    <!--end::Modal - Add task-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3 statsBlock blockui d-flex flex-row align-items-center"
                     style="">
                    <!--begin::Number-->
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-arrows-loop fs-3 text-warning me-2"><span
                                class="path1"></span><span class="path2"></span></i>
                        <div class="fs-4 fw-bold text-gray-700" data-kt-countup="true" data-kt-countup-value="4500"
                             id="whours" data-kt-countup-prefix="$" data-kt-initialized="1">-
                        </div>
                        <a id="FilterWaiting" class="btn btn-sm btn-active-light-primary fw-semibold ms-3">{{__('Working Hours')}}</a>
                    </div>
                <!--begin::Table-->
                </div>
                <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                       id="kt_table_whours">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="mw-125px all">ID</th>
                        <th class="mw-125px all">Date</th>
                        <th class="mw-125px all">From</th>
                        <th class="mw-125px all">To</th>
                        <th class="mw-125px all">Qty</th>
                        <th class="mw-125px all">Schedule</th>
                        <th class="mw-125px all">Qty2</th>
                        <th class="mw-125px all">Notes</th>
                        <th class="mw-125px all">Status</th>
                        <th class="mw-125px all">Update User</th>
                        <th class="mw-125px all">Delete</th>
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








@push('scripts')

    @isset($employee)

        <script>
            var datatableWhour;
            var initWhours = (function () {
                var i = 1;

                return function () {


                    executed = true;
                    const columnDefs = [
                        {"render": function(data, type, full, meta) {
                                return i++;
                            }},
                        {data: 'work_date', name: 'work_date'},
                        {data: 'from_time', name: 'from_time'},
                        {data: 'to_time', name: 'to_time'},
                        {data: 'hours', name: 'hours'},
                        {data: 'schedule', name: 'schedule',orderable:false},
                        {data: 'hours2', name: 'hours2', visible: false},
                        {data: 'notes', name: 'notes'},
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.status)
                                        return row.status.name;
                                }
                                return '';
                            },
                            name: 'status.name ',
                        },
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.user)
                                        return row.user.name;
                                }
                                return '';
                            },
                            name: 'user.name ',
                        },
                        {data: 'action', name: 'action'}
                    ];
                    datatableWhour = createDataTable('#kt_table_whours', columnDefs,
                        "{{ route('myemployees.whours.index', ['employee' => isset($employee)?$employee->id:0]) }}",
                        [
                            [0, "DESC"]
                        ]);
                    datatableWhour.on('xhr', function(e, settings, json) {
                        $('#whours').text(json['total_whour']);

                    });


                };
            })();
        </script>
        <script>
            const filterSearchWhours = document.querySelector('[data-kt-whours-table-filter="search"]');
            filterSearchWhours.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                datatableWhour.columns(1).search(filterSearchWhours.value).draw();
            }
        </script>

        <script>
            $(function () {


                const validatorWhourFields = {};
                const RequiredInputListWhour = {
                    'from_time': 'input',
                    'to_time': 'input',
                    'work_date': 'input',

                }

                const kt_modal_add_whour = document.getElementById('kt_modal_add_whour');
                const modal_kt_modal_add_whour = new bootstrap.Modal(kt_modal_add_whour);


                $(document).on('click', '.btnUpdateWhour', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    const editURl = $(this).attr('href');

                    globalRenderModal(editURl,
                        $(this), '#kt_modal_add_whour',
                        modal_kt_modal_add_whour,
                        validatorWhourFields,
                        '#kt_modal_add_whour_form',
                        datatableWhour,
                        '[data-kt-whours-modal-action="submit"]', RequiredInputListWhour);
                });


                $(document).on('click', '.btnDeleteWhour', function (e) {
                    e.preventDefault();
                    const URL = $(this).attr('href');
                    const whourName = $(this).attr('data-whour-name');
                    Swal.fire({
                        text: "Are you sure you want to delete " + whourName + "?",
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
                                    datatableWhour.ajax.reload(null, false);
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
        <script>
            $(function () {
                initWhours();
            });
        </script>
        <script>
            $(document).on('click', '#filterBtn', function (e) {
                e.preventDefault();
                datatableWhour.ajax.reload();
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
                datatableWhour.ajax.reload();
            });

            $(document).on('click', '.exportBtn', function (e) {
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

            const validatorWhourFields = {};
            const RequiredInputListWhour = {
                'from_time': 'input',
                'to_time': 'input',
                'work_date': 'input',

            }
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
            const kt_modal_add_whour = document.getElementById('kt_modal_add_whour');
            const modal_kt_modal_add_whour = new bootstrap.Modal(kt_modal_add_whour);

            $(document).on('click', '#AddWhourModal', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                globalRenderModal(
                    "{{ route('employees.whours.add', ['employee_id' => isset($employee) ? $employee->id : '' ]) }}",
                    $(this), '#kt_modal_add_whour',
                    modal_kt_modal_add_whour,
                    validatorWhourFields,
                    '#kt_modal_add_whour_form',
                    datatableWhour,
                    '[data-kt-whours-modal-action="submit"]', RequiredInputListWhour);
            });


            $(document).on('click', '.btnUpdateWhour', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                const editURl = $(this).attr('href');

                globalRenderModal(editURl,
                    $(this), '#kt_modal_add_whour',
                    modal_kt_modal_add_whour,
                    validatorWhourFields,
                    '#kt_modal_add_whour_form',
                    datatableWhour,
                    '[data-kt-whours-modal-action="submit"]', RequiredInputListWhour);
            });


            $(document).on('click', '.btnDeleteWhour', function (e) {
                e.preventDefault();
                const URL = $(this).attr('href');
                const whourName = $(this).attr('data-whour-name');
                Swal.fire({
                    text: "Are you sure you want to delete " + whourName + "?",
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
                                datatableWhour.ajax.reload(null, false);
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
    @endisset

@endpush
