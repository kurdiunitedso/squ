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
                        <input type="text" data-kt-drivers-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="Search Drivers"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-drivers-table-toolbar="base">
                        <!--begin::Filter-->
                        <!--begin::policyOffers 1-->
                        <!--end::policyOffers 1-->
                        <!--end::Filter-->
                        <!--begin::Add policyOffers-->
                        <a href=#" class="btn btn-primary" id="AddDriverModal">
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
                        <!--end::Add policyOffers-->
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
                       id="kt_table_drivers">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="mw-40px">{{__('ID')}}</th>
                        <th class="min-w-125px">{{__('Name')}}</th>
                        <th class="min-w-125px">{{__('Card ID')}}</th>
                        <th class="min-w-125px">{{__('Address')}}</th>
                        <th class="min-w-125px">{{__('Telephone')}}</th>
                        <th class="min-w-125px">{{__('license No')}}</th>
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

@push('scripts')

    @isset($policyOffer)

        <script>
            var datatableDriver;
            var initDrivers = (function () {


                return function () {


                    executed = true;
                    const columnDefs = [{
                        data: 'id',
                        name: 'id',
                    },
                        {
                            data: 'driver_name',
                            name: 'driver_name',
                        },
                        {
                            data: 'driver_id',
                            name: 'driver_id',
                        },
                        {
                            data: 'address',
                            name: 'address',
                        },
                        {
                            data: 'telephone',
                            name: 'telephone',
                        },

                        {
                            data: 'license_no',
                            name: 'license_no',
                        },

                        {
                            data: 'action',
                            name: 'action',
                            className: 'text-end',
                            orderable: false,
                            searchable: false
                        }
                    ];
                    var route = "{{ route('policyOffers.drivers.index', ['vehicle' => isset($policyOffer)?$policyOffer->id:0]) }}";
                    route = route.replace("/{{ isset($policyOffer)?$policyOffer->id:0}}/", "/" + $('#vehicle_id').val() + "/");
                    console.log(route);
                    datatableDriver = createDataTable('#kt_table_drivers', columnDefs, route
                        ,
                        [
                            [0, "ASC"]
                        ]);


                };
            })();
        </script>
        <script>
            const filterSearchDrivers = document.querySelector('[data-kt-drivers-table-filter="search"]');
            filterSearchDrivers.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                datatableDriver.columns(1).search(filterSearchDrivers.value).draw();
            }
        </script>

        <script>
            $(function () {


                const validatorDriverFields = {};
                const RequiredInputListDriver = {
                    'driver_name': 'input',
                    'driver_id': 'input',
                    'city_id': 'select',
                    'floor': 'select',
                    'license_no': 'input',

                }

                const kt_modal_add_driver = document.getElementById('kt_modal_add_driver');
                const modal_kt_modal_add_driver = new bootstrap.Modal(kt_modal_add_driver);

                $(document).on('click', '#AddDriverModal', function (e) {
                    console.log("hh");
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    globalRenderModal(
                        "{{ route('policyOffers.drivers.add', ['policyOffer_id' => isset($policyOffer) ? $policyOffer->id : '' ]) }}" + "&vehicle_id=" + $('#vehicle_id').val(),
                        $(this), '#kt_modal_add_driver',
                        modal_kt_modal_add_driver,
                        validatorDriverFields,
                        '#kt_modal_add_driver_form',
                        datatableDriver,
                        '[data-kt-drivers-modal-action="submit"]', RequiredInputListDriver);
                });


                $(document).on('click', '.btnUpdateDriver', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    const editURl = $(this).attr('href');

                    globalRenderModal(editURl,
                        $(this), '#kt_modal_add_driver',
                        modal_kt_modal_add_driver,
                        validatorDriverFields,
                        '#kt_modal_add_driver_form',
                        datatableDriver,
                        '[data-kt-drivers-modal-action="submit"]', RequiredInputListDriver);
                });


                $(document).on('click', '.btnDeleteDriver', function (e) {
                    e.preventDefault();
                    const URL = $(this).attr('href');
                    const driverName = $(this).attr('data-driver-name');
                    Swal.fire({
                        text: "Are you sure you want to delete " + driverName + "?",
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
                                    datatableDriver.ajax.reload(null, false);
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
                initDrivers();
            });
        </script>
    @endisset

@endpush
