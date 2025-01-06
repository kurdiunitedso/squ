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
                        <input type="text" data-kt-salarys-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="Search Salarys"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-salarys-table-toolbar="base">

                        <div class="d-flex justify-content-end" data-kt-employees-table-toolbar="base">
                            <a href="#" class="btn btn-primary" id="AddSalaryModal">
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
            <!--begin::Table-->
            <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                   id="kt_table_salarys">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>{{__('ID')}}</th>
                    <th>{{__('Month')}}</th>
                    <th>{{__('Year')}}</th>
                    <th>{{__('Net Salary')}}</th>
                    <th>{{__('Allowance')}}</th>
                    <th>{{__('Deduction')}}</th>
                    <th>{{__('Working Hours')}}</th>
                    <th>{{__('Schedule Hours')}}</th>
                    <th>{{__('Status')}}</th>
                    <th class="tblaction-rg tblaction-three-rg">{{__('Action')}}</th>
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


@push('scripts')

    @isset($employee)

        <script>
            var datatableSalary;
            var initSalarys = (function () {


                return function () {


                    executed = true;
                    const columnDefs = [
                        {data: 'id', name: 'id'},
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.months)
                                        return row.months.name;
                                }
                                return '';
                            },
                            name: 'months.name'
                        },
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.years)
                                        return row.years.name;
                                }
                                return '';
                            },
                            name: 'years.name'
                        },
                        {data: 'total_salary', name: 'total_salary'},

                        {data: 'total_allowance', name: 'total_allowance'},
                        {data: 'total_deduction', name: 'total_deduction'},
                        {data: 'working_hours', name: 'working_hours'},
                        {data: 'schedule_hours', name: 'schedule_hours'},
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.statuss)
                                        return row.statuss.name;
                                }
                                return '';
                            },
                            name: 'statuss.name'
                        },
                        {data: 'action', name: 'action'}
                    ];
                    datatableSalary = createDataTable('#kt_table_salarys', columnDefs,
                        "{{ route('employees.salarys.index', ['employee' => isset($employee)?$employee->id:0]) }}",
                        [
                            [0, "DESC"]
                        ]);


                };
            })();
        </script>
        <script>
            const filterSearchSalarys = document.querySelector('[data-kt-salarys-table-filter="search"]');
            filterSearchSalarys.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                datatableSalary.columns(1).search(filterSearchSalarys.value).draw();
            }
        </script>

        <script>
            $(function () {


                const validatorSalaryFields = {};
                const RequiredInputListSalary = {
                    'month': 'select'


                }

                const kt_modal_add_salary = document.getElementById('kt_modal_add_salary');
                const modal_kt_modal_add_salary = new bootstrap.Modal(kt_modal_add_salary);

                $(document).on('click', '#AddSalaryModal', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    globalRenderModal(
                        "{{ route('employees.salarys.add', ['employee_id' => isset($employee) ? $employee->id : '' ]) }}",
                        $(this), '#kt_modal_add_salary',
                        modal_kt_modal_add_salary,
                        validatorSalaryFields,
                        '#kt_modal_add_salary_form',
                        datatableSalary,
                        '[data-kt-salarys-modal-action="submit"]', RequiredInputListSalary);
                });


                $(document).on('click', '.btnUpdateSalary', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    const editURl = $(this).attr('href');

                    globalRenderModal(editURl,
                        $(this), '#kt_modal_add_salary',
                        modal_kt_modal_add_salary,
                        validatorSalaryFields,
                        '#kt_modal_add_salary_form',
                        datatableSalary,
                        '[data-kt-salarys-modal-action="submit"]', RequiredInputListSalary);
                });


                $(document).on('click', '.btnDeleteSalary', function (e) {
                    e.preventDefault();
                    const URL = $(this).attr('href');
                    const salaryName = $(this).attr('data-salary-name');
                    Swal.fire({
                        text: "Are you sure you want to delete " + salaryName + "?",
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
                                    datatableSalary.ajax.reload(null, false);
                                    Swal.fire({
                                        text: response.message,
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                },
                                complete: function () {
                                },
                                error: function (response, textStatuss,
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
                initSalarys();
            });
        </script>
        <script>
            $(document).on('click', '#filterBtn', function (e) {
                e.preventDefault();
                datatableSalary.ajax.reload();
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
                datatableSalary.ajax.reload();
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
            const kt_modal_show_whour = document.getElementById('kt_modal_show_whour');
            const modal_kt_modal_show_whour = new bootstrap.Modal(kt_modal_show_whour);

            $(document).on('click', '.ShowWhourReport', function (e) {
                e.preventDefault();
                var url = $(this).attr("href");
                $(this).attr("data-kt-indicator", "on");
                globalRenderModal(
                    url,
                    $(this), '#kt_modal_show_whour',
                    modal_kt_modal_show_whour);
            });



        </script>
    @endisset

@endpush
