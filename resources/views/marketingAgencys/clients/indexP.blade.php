<div class="modal-content">

    <div class="modal-header" id="kt_modal_showCalls_header">
        <!--begin::Modal preparation_time-->

        <!--end::Modal preparation_time-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                      <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor"/>
                  </svg>
              </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>

    <div class="modal-body scroll-y ">
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <!--begin::Card-->

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
                                <input type="text" data-kt-clients-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-14"
                                       placeholder="Search Clients"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-clients-table-toolbar="base">
                                <!--begin::Filter-->
                                <!--begin::marketingAgencys 1-->
                                <!--end::marketingAgencys 1-->
                                <!--end::Filter-->
                                <!--begin::Add marketingAgencys-->
                                <a href="#" class="btn btn-primary" id="AddClientModal">
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
                                <!--end::Add marketingAgencys-->
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
                               id="kt_table_clients">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-25px all"><input type="checkbox" id="select-all"></th>
                                <th class="min-w-100px bold all">{{__('SN')}}</th>
                                <th class="min-w-100px bold all">{{__('City')}}</th>
                                <th class="min-w-200px bold all">{{__('Name')}}</th>

                                <th class="min-w-100px bold all">{{__('Client ID')}}</th>

                                <th class="min-w-100px bold all">{{__('Mobile')}}</th>
                                <th class="min-w-200px bold all">{{__('Category')}}</th>
                                <th class="min-w-200px bold all">{{__('Status')}}</th>
                                <th class="min-w-100px bold all">{{__('Total Orders Box')}}</th>
                                <th class="min-w-100px bold all">{{__('Total Orders Bot')}}</th>
                                <th class="min-w-100px bold all">{{__('Total Orders Now')}}</th>
                                <th class="min-w-100px bold all">{{__('Last order Box')}}</th>
                                <th class="min-w-100px bold all">{{__('Last order Bot')}}</th>
                                <th class="min-w-100px bold all">{{__('Last order Now')}}</th>

                                <th class="min-w-100px bold all">{{__('Active')}}</th>


                                <th class="min-w-200px bold all">{{__('Actions')}}</th>
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
                >
                <!--end::Card-->
            </div>
        </div>
    </div>
</div>


@isset($marketingAgency)

    <script>
        var selectedClientsRows = [];
        var selectedClientsData = [];
        var datatableClient;
        var initClients = (function () {


            return function () {


                executed = true;
                const columnDefs =
                    [
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                var isChecked = selectedClientsRows.includes(row.id.toString()) ? 'checked' : '';
                                return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                            },
                            orderable: false,

                        },
                        {
                            data: 'id',
                            name: 'id',
                        },
                        {
                            data: 'city.name',
                            name: 'city.name',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },

                        {
                            data: 'client_id',
                            name: 'client_id',
                        },



                        {
                            data: 'telephone',
                            name: 'telephone',
                        },

                        {
                            data: 'category.name',
                            name: 'category.name',
                        },
                        {
                            data: 'status.name',
                            name: 'status.name',
                        },
                        {
                            data: 'orders_box',
                            name: 'orders_box',
                        },

                        {
                            data: 'orders_bot',
                            name: 'orders_bot',
                        },


                        {
                            data: 'orders_now',
                            name: 'orders_now',
                        },





                        {
                            data: 'last_orders_box',
                            name: 'last_orders_box',
                        },
                        {
                            data: 'last_orders_bot',
                            name: 'last_orders_bot',
                        },

                        {
                            data: 'last_orders_now',
                            name: 'last_orders_now',
                        },




                        {
                            data: 'active',
                            name: 'active',
                        },



                        {
                            data: 'action',
                            name: 'action',
                            className: 'text-end',
                            orderable: false,
                            searchable: false
                        }
                    ];
                datatableClient = createDataTable('#kt_table_clients', columnDefs,
                    "{{ route('marketingAgencys.clients.index', ['marketingAgency' => isset($marketingAgency)?$marketingAgency->id:0]) }}",
                    [
                        [0, "ASC"]
                    ]);


            };
        })();
    </script>
    <script>
        const filterSearchClient = document.querySelector('[data-kt-clients-table-filter="search"]');
        filterSearchClient.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatableClient.columns(1).search(filterSearchClient.value).draw();
        }
    </script>

    <script>
        $(function () {


            const validatorClientFields = {};
            const RequiredInputListClient = {
                'name': 'input',
                'mobile': 'input',

                'title': 'input',
                'status': 'status',

            }

            const kt_modal_add_client = document.getElementById('kt_modal_add_client');
            const modal_kt_modal_add_client = new bootstrap.Modal(kt_modal_add_client);

            $(document).on('click', '#AddClientModal', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                globalRenderModal(
                    "{{ route('marketingAgencys.clients.add', ['marketingAgency_id' => isset($marketingAgency) ? $marketingAgency->id : '' ]) }}",
                    $(this), '#kt_modal_add_client',
                    modal_kt_modal_add_client,
                    validatorClientFields,
                    '#kt_modal_add_client_form',
                    datatableClient,
                    '[data-kt-clients-modal-action="submit"]', RequiredInputListClient);
            });


            $(document).on('click', '.btnUpdateClient', function (e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                const editURl = $(this).attr('href');

                globalRenderModal(editURl,
                    $(this), '#kt_modal_add_client',
                    modal_kt_modal_add_client,
                    validatorClientFields,
                    '#kt_modal_add_client_form',
                    datatableClient,
                    '[data-kt-clients-modal-action="submit"]', RequiredInputListClient);
            });


            $(document).on('click', '.btnDeleteClient', function (e) {
                e.preventDefault();
                const URL = $(this).attr('href');
                const clientName = $(this).attr('data-client-name');
                Swal.fire({
                    text: "Are you sure you want to delete " + clientName + "?",
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
                                datatableClient.ajax.reload(null, false);
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
            initClients();
        });
    </script>
@endisset



