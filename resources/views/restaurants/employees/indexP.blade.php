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
                        <input type="text" data-kt-employees-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="Search Employees"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-employees-table-toolbar="base">
                        <!--begin::Filter-->
                        <!--begin::restaurants 1-->
                        <!--end::restaurants 1-->
                        <!--end::Filter-->
                        <!--begin::Add restaurants-->
                        <a href="#" class="btn btn-primary" id="AddEmployeeModal">
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
                        <!--end::Add restaurants-->
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
                       id="kt_table_employees">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="mw-40px">{{__('ID')}}</th>
                        <th class="min-w-125px">{{__('Name')}}</th>
                        <th class="min-w-125px">{{__('Mobile')}}</th>
                        <th class="min-w-125px">{{__('Whatsapp')}}</th>
                        <th class="min-w-125px">{{__('Employee Title')}}</th>
                        <th class="min-w-125px">{{__('Branch')}}</th>
                        <th class="min-w-125px">{{__('City')}}</th>
                        <th class="min-w-125px">{{__('Email')}}</th>
                        <th class="min-w-125px">{{__('Create Date')}}</th>
                        <th class="text-end mw-100px">{{__('Actions')}}</th>
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



@isset($restaurant)

    <script>
        var datatableEmployee;
        var initEmployees = (function () {


            return function () {


                executed = true;
                const columnDefs = [{
                    data: 'id',
                    name: 'id',
                },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'mobile',
                        name: 'mobile',
                    },
                    {
                        data: 'whatsapp',
                        name: 'whatsapp',
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: function (row, type, set) {
                            if (type === 'display') {
                                if (row.brnach)
                                    return row.brnach.address;
                            }
                            return '';
                        },
                        name: 'branch.address',
                    },
                    {
                        data: function (row, type, set) {
                            if (type === 'display') {
                                if (row.city)
                                    return row.city.name;
                            }
                            return '';
                        },
                        name: 'city.name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },


                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-end',
                        orderable: false,
                        searchable: false
                    }
                ];
                datatableEmployee = createDataTable('#kt_table_employees', columnDefs,
                    "{{ route('restaurants.employees.index', ['restaurant' => isset($restaurant)?$restaurant->id:0]) }}",
                    [
                        [0, "ASC"]
                    ]);


            };
        })();
    </script>
    <script>
        const filterSearchEmployee = document.querySelector('[data-kt-employees-table-filter="search"]');
        filterSearchEmployee.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatableEmployee.columns(1).search(filterSearchEmployee.value).draw();
        }
    </script>

    <script>
        $(function () {


            const validatorEmployeeFields = {};
            const RequiredInputListEmployee = {
                'name': 'input',
                'mobile': 'input',

                'title': 'input',
                'status': 'status',

            }

            const kt_modal_add_employee = document.getElementById('kt_modal_add_employee');
            const modal_kt_modal_add_employee = new bootstrap.Modal(kt_modal_add_employee);

            $(document).on('click', '#AddEmployeeModal', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                globalRenderModal(
                    "{{ route('restaurants.employees.add', ['restaurant_id' => isset($restaurant) ? $restaurant->id : '' ]) }}",
                    $(this), '#kt_modal_add_employee',
                    modal_kt_modal_add_employee,
                    validatorEmployeeFields,
                    '#kt_modal_add_employee_form',
                    datatableEmployee,
                    '[data-kt-employees-modal-action="submit"]', RequiredInputListEmployee);
            });


            $(document).on('click', '.btnUpdateEmployee', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                const editURl = $(this).attr('href');

                globalRenderModal(editURl,
                    $(this), '#kt_modal_add_employee',
                    modal_kt_modal_add_employee,
                    validatorEmployeeFields,
                    '#kt_modal_add_employee_form',
                    datatableEmployee,
                    '[data-kt-employees-modal-action="submit"]', RequiredInputListEmployee);
            });


            $(document).on('click', '.btnDeleteEmployee', function (e) {
                e.preventDefault();
                const URL = $(this).attr('href');
                const employeeName = $(this).attr('data-employee-name');
                Swal.fire({
                    text: "Are you sure you want to delete " + employeeName + "?",
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
                                datatableEmployee.ajax.reload(null, false);
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
            initEmployees();
        });
    </script>
@endisset







