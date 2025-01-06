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
                        <input type="text" data-kt-swhours-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="Search Swhours"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-swhours-table-toolbar="base">

                        <div class="d-flex justify-content-end" data-kt-employees-table-toolbar="base">
                            <a href="#" class="btn btn-primary" id="AddSwhourModal">
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
                       id="kt_table_swhours">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>{{__('ID')}}</th>
                        <th>{{__('Day')}}</th>
                        <th>{{__('From')}}</th>
                        <th>{{__('To')}}</th>
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


@push('scripts')

    @isset($employee)

        <script>
            var datatableSwhour;
            var initSwhours = (function () {


                return function () {


                    executed = true;
                    const columnDefs = [
                        {data: 'id', name: 'id'},
                        {data: 'days.name', name: 'days.name'},
                        {data: 'time_from', name: 'time_from'},
                        {data: 'time_to', name: 'time_to'},

                        {data: 'action', name: 'action'}
                    ];
                    datatableSwhour = createDataTable('#kt_table_swhours', columnDefs,
                        "{{ route('employees.swhours.index', ['employee' => isset($employee)?$employee->id:0]) }}",
                        [
                            [0, "DESC"]
                        ]);


                };
            })();
        </script>
        <script>
            const filterSearchSwhours = document.querySelector('[data-kt-swhours-table-filter="search"]');
            filterSearchSwhours.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                datatableSwhour.columns(1).search(filterSearchSwhours.value).draw();
            }
        </script>

        <script>
            $(function () {


                const validatorSwhourFields = {};
                const RequiredInputListSwhour = {
                    'from_time': 'input',
                    'to_time': 'input',
                    'work_date': 'input',

                }

                const kt_modal_add_swhour = document.getElementById('kt_modal_add_swhour');
                const modal_kt_modal_add_swhour = new bootstrap.Modal(kt_modal_add_swhour);

                $(document).on('click', '#AddSwhourModal', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    globalRenderModal(
                        "{{ route('employees.swhours.add', ['employee_id' => isset($employee) ? $employee->id : '' ]) }}",
                        $(this), '#kt_modal_add_swhour',
                        modal_kt_modal_add_swhour,
                        validatorSwhourFields,
                        '#kt_modal_add_swhour_form',
                        datatableSwhour,
                        '[data-kt-swhours-modal-action="submit"]', RequiredInputListSwhour);
                });


                $(document).on('click', '.btnUpdateSwhour', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    const editURl = $(this).attr('href');

                    globalRenderModal(editURl,
                        $(this), '#kt_modal_add_swhour',
                        modal_kt_modal_add_swhour,
                        validatorSwhourFields,
                        '#kt_modal_add_swhour_form',
                        datatableSwhour,
                        '[data-kt-swhours-modal-action="submit"]', RequiredInputListSwhour);
                });


                $(document).on('click', '.btnDeleteSwhour', function (e) {
                    e.preventDefault();
                    const URL = $(this).attr('href');
                    const swhourName = $(this).attr('data-swhour-name');
                    Swal.fire({
                        text: "Are you sure you want to delete " + swhourName + "?",
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
                                    datatableSwhour.ajax.reload(null, false);
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
                initSwhours();
            });
        </script>
        <script>
            $(document).on('click', '#filterBtn', function (e) {
                e.preventDefault();
                datatableSwhour.ajax.reload();
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
                datatableSwhour.ajax.reload();
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
    @endisset

@endpush
