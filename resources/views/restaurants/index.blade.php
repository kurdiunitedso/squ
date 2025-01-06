@extends('metronic.index')

@section('title', 'Restaurants')
@section('subpageTitle', 'Restaurants')

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
                                   data-kt-restaurants-table-filter="search"
                                   class="form-control datatable-input form-control-solid w-250px ps-14"
                                   placeholder="Search Restaurants"/>
                            <input type="hidden" name="selectedRestaurant">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-restaurants-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::restaurants 1-->
                            <!--end::restaurants 1-->
                            @include('restaurants._filter')
                            <a href="#" id="btnAddVisitRequest" url="{{route('visitRequests.create')}}"
                               class="btn btn-info me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <title>Stockholm-icons / Communication / Clipboard-check</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs/>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="currentColor" />
                                        <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                    </g>
                                </svg>
                                <span id="selectedRestaurantsRowsCount"></span>{{__('Visit Request')}}</a>

                            <a target="_blank" id="exportBtn" href="#"
                               data-export-url="{{ route('restaurants.export') }}" class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{__('Export')}}
                            </a>
                            <!--end::Filter-->
                            <!--begin::Add restaurants-->
                            <a href="{{ route('restaurants.create') }}" class="btn btn-primary"
                               id="AddrestaurantsModal">
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
                                    {{__('Add Restaurant')}}
                                </span>
                                <span class="indicator-progress">
                                     {{__('Please wait...')}} <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </a>
                            <!--end::Add restaurants-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_restaurants" tabindex="-1" aria-hidden="true">
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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                           id="kt_table_restaurants">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-25px all"><input type="checkbox" id="select-all"></th>
                            <th class="all"></th>
                            <th class="min-w-25px bold all">{{__('SN')}}</th>
                            <th class="min-w-100px bold all">{{__('Restaurant ID')}}</th>

                            <th class="min-w-100px bold all">{{__('Name')}}</th>

                            <th class="min-w-100px bold all">{{__('Type')}}</th>
                            <th class="min-w-100px bold all">{{__('Telephone')}}</th>
                            <th class="min-w-100px bold all">{{__('City')}}</th>
                            <th class="min-w-100px bold all">{{__('Join Date')}}</th>
                            <th class="min-w-100px bold all">{{__('Has Now')}}</th>
                            <th class="min-w-100px bold all">{{__('Has Bot')}}</th>
                            <th class="min-w-100px bold all">{{__('Has B2B')}}</th>
                            <th class="min-w-100px bold all">{{__('Has POS')}}</th>
                            <th class="min-w-100px bold all">{{__('Has Marketing')}}</th>

                            <th class="min-w-100px bold all">{{__('Visits')}}</th>
                            <th class="min-w-100px bold all">{{__('Tickets')}}</th>

                            <th class="min-w-100px bold all">{{__('Employees')}}</th>
                            <th class="min-w-100px bold all">{{__('Branches')}}</th>
                            <th class="min-w-100px bold all">{{__('Attachments')}}</th>

                         {{--   <th class="min-w-100px bold all">{{__('Bank')}}</th>
                            <th class="min-w-100px bold all">{{__('Bank Branch')}}</th>
                            <th class="min-w-100px bold all">{{__('IBAN')}}</th>
                            <th class="min-w-100px bold all">{{__('Beneficiary')}}</th>--}}

                            <th class="min-w-100px bold all">{{__('Printer Type')}}</th>
                            <th class="min-w-100px bold all">{{__('Printer SN')}}</th>
                            <th class="min-w-100px bold all">{{__('Has Box')}}</th>
                            <th class="min-w-100px bold all">{{__('Box No')}}</th>


                            <th class="min-w-100px bold all">{{__('Commission Cash %')}}</th>
                            <th class="min-w-100px bold all">{{__('Commission Visa $')}}</th>
                            <th class="min-w-100px bold all">{{__('Sales Visa $')}}</th>
                            <th class="min-w-100px bold all">{{__('Sales Commission $')}}</th>
                            <th class="min-w-100px bold ">{{__('Paid to Restaurant')}}</th>
                            <th class="min-w-100px bold ">{{__('Net For Payemnt')}}</th>
                            <th class="min-w-100px bold ">{{__('Active')}}</th>
                            <th class="min-w-100px bold all">{{__('Actions')}}</th>
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
    <div class="modal fade" id="kt_modal_restaurants" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-fullscreen">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_changeStatus" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

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

    <div class="modal fade" id="kt_modal_tickets" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_patientConfirm" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>


    <div class="modal fade" id="kt_modal_showCalls" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl table-responsive">

        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_add_employee" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_menuItem" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_branch" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_add_attachment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>


    <!--end::Modal - Add task-->
@endsection


@push('scripts')
    <script>
        var selectedRestaurantsRows = [];
        var selectedRestaurantsData = [];
        const columnDefs =
            [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        var isChecked = selectedRestaurantsRows.includes(row.id.toString()) ? 'checked' : '';
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
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'restaurant_id',
                    name: 'restaurant_id',
                },


                {
                    data: 'name',
                    name: 'name',
                },


                {
                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.type)
                                return row.type.name;
                        }
                        return 'NA';
                    },

                    name: 'type.name',
                },

                {
                    data: 'telephone',
                    name: 'telephone',
                },

                {
                    data: 'city.name',
                    name: 'city.name',
                },
                {
                    data: 'join_date',
                    name: 'join_date',
                },

                {
                    data: 'has_wheels_now',
                    name: 'has_wheels_now',

                },
                {
                    data: 'has_wheels_bot',
                    name: 'has_wheels_bot',

                },
                {
                    data: 'has_wheels_b2b',
                    name: 'has_wheels_b2b',

                },
                {
                    data: 'has_pos',
                    name: 'has_pos',

                },
                {
                    data: 'has_marketing',
                    name: 'has_marketing',

                },
                {
                    data: 'visits_count',
                    name: 'visits_count',

                },
                {
                    data: 'tickets_count',
                    name: 'tickets_count',

                },


                {
                    data: 'employees_count',
                    name: 'employees_count',

                },
                {
                    data: 'branches_count',
                    name: 'branches_count',

                },
                {
                    data: 'attachments_count',
                    name: 'attachments_count',

                },


                /*  {
                    data: 'bank_name',
                    name: 'bank_name',

                },


              {
                    data: 'branch',
                    name: 'branch',

                },

                {
                    data: 'iban',
                    name: 'iban',

                },
                {
                    data: 'benficiary',
                    name: 'benficiary',

                },*/
                {
                    data: 'printer_type',
                    name: 'printer_type',

                },
                {
                    data: 'printer_sn',
                    name: 'printer_sn',

                },
                {
                    data: 'has_box',
                    name: 'has_box',

                },
                {
                    data: 'box_no',
                    name: 'box_no',

                },


                {
                    data: 'commission_cash',
                    name: 'commission_cash',

                },
                {
                    data: 'commission_visa',
                    name: 'commission_visa',

                },

                {
                    data: 'total_sales_cash',
                    name: 'total_sales_cash',

                },
                {
                    data: 'total_sales_visa',
                    name: 'total_sales_visa',

                },

                {
                    data: 'paid',
                    name: 'paid',

                },
                {
                    data: 'net_paid',
                    name: 'net_paid',

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
        var datatable = createDataTable('#kt_table_restaurants', columnDefs, "{{ route('restaurants.index') }}", [
            [0, "DESC"]
        ]);
        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function () {
            KTMenu.createInstances();
        });
        $('#kt_table_restaurants').find('#select-all').on('click', function () {
            $('#kt_table_restaurants').find('.row-checkbox').click();
        });

        $('#kt_table_restaurants tbody').on('click', '.row-checkbox', function () {
            var $row = $(this).closest('tr');
            var rowData = datatable.row($row).data();
            var rowIndex = selectedRestaurantsRows.indexOf(rowData.id);

            if (this.checked && rowIndex === -1) {
                selectedRestaurantsRows.push(rowData.id);
            } else if (!this.checked && rowIndex !== -1) {
                //console.log(data);
                selectedRestaurantsRows.splice(rowIndex, 1);

            }

            $row.toggleClass('selected');
            datatable.row($row).select(this.checked);
            if (selectedRestaurantsRows.length == 0)
                $('#selectedRestaurantsRowsCount').html("");
            else
                $('#selectedRestaurantsRowsCount').html("(" + selectedRestaurantsRows.length + ")");



            $('[name="selectedRestaurant"]').val(selectedRestaurantsRows.join(','));

        });

        // Restore selected rows when page changes
        datatable.on('draw.dt', function () {
            datatable.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                if (selectedRestaurantsRows.includes(rowData.id)) {
                    this.select();
                }
            });
        });


    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-restaurants-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.draw();
        }

        const kt_modal_visits = document.getElementById('kt_modal_visits');
        const modal_kt_modal_visits = new bootstrap.Modal(kt_modal_visits);

        var kt_modal_tickets = document.getElementById('kt_modal_tickets');
        var modal_kt_modal_tickets = new bootstrap.Modal(kt_modal_tickets);



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
        $(document).on('click', '.btnUpdateticket', function (e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var data_id = $(this).attr("data-id");
            const editURl = $(this).attr('href');
            var size = $(this).attr("size");
            /*  $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-xl');
              $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-sm');
              $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-lg');
              $('#kt_modal_tickets').find('.modal-dialog').addClass(size);*/

            globalRenderModal(editURl,
                $(this), '#kt_modal_tickets',
                modal_kt_modal_tickets,
                [],
                '#kt_modal_add_ticket_form',
                datatable,
                '[data-kt-ticket-modal-action="submit"]', data_id);
        });

    </script>


    <script>
        function renderModal(url, button, modalId, modalBootstrap) {


            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    $(modalId).find('.modal-dialog').html(response.callsView);
                    modalBootstrap.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();
                },
                complete: function () {
                    if (button) {
                        button.removeAttr('data-kt-indicator');
                    }
                }
            });
        }

        const validatorChangeStatusFields = {};
        const RequiredInputListRestaurantChnageStatus = {}
        const kt_modal_changeStatus = document.getElementById('kt_modal_changeStatus');
        const modal_kt_changeStatus = new bootstrap.Modal(kt_modal_changeStatus);

        $(document).on('click', '.btnChangeStatus', function (e) {
            e.preventDefault();
            const changeStatusUrl = $(this).attr('href');
            globalRenderModal(
                changeStatusUrl,
                $(this), '#kt_modal_changeStatus',
                modal_kt_changeStatus,
                validatorChangeStatusFields,
                '#kt_modal_changeStatus_form',
                datatable,
                '[data-kt-changeStatus-modal-action="submit"]', RequiredInputListRestaurantChnageStatus);
        });

        const validatorChangePatientConfirmFields = {};
        const RequiredInputListPatientConfirmStatus = {
            'patient_confirm': 'select',
        }
        const kt_modal_patientConfirm = document.getElementById('kt_modal_patientConfirm');
        const modal_kt_patientConfirm = new bootstrap.Modal(kt_modal_patientConfirm);

        $(document).on('click', '.btnChangePatientConfirm', function (e) {
            e.preventDefault();
            const changePatientConfirmUrl = $(this).attr('href');
            globalRenderModal(
                changePatientConfirmUrl,
                $(this), '#kt_modal_patientConfirm',
                modal_kt_patientConfirm,
                validatorChangePatientConfirmFields,
                '#kt_modal_patientConfirm_form',
                datatable,
                '[data-kt-patientConfirm-modal-action="submit"]', RequiredInputListPatientConfirmStatus);
        });


        $(document).on('click', '.btnDeleterestaurant', function (e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const restaurantName = $(this).attr('data-restaurant-name');
            Swal.fire({
                html: "Are you sure you want to delete " + restaurantName + "?",
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
        $('#btnAddVisitRequest').click(function () {
            if (selectedRestaurantsRows.length == 0) {
                Swal.fire({
                    text: "Please select at least one Restaurant to visit Request",
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
                var url = $(this).attr("url")+'?&visit_category=249&selectedRestaurants='+selectedRestaurantsRows.join(',');
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

    </script>
    <script>
        function renderAModal(url, button, modalId, modalBootstrap, validatorFields, formId, dataTableId,
                              submitButtonName, RequiredInputList = null, onFormSuccessCallBack = null, data_id = 0) {


            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
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
                    submitButton.addEventListener('click', function (e) {
                        // Prevent default button action
                        e.preventDefault();

                        // const form = document.querySelector(formId);

                        // Validate form before submit
                        if (validator) {
                            validator.validate().then(function (status) {
                                console.log('validated!');

                                if (onFormSuccessCallBack == null) {
                                    onFormSuccessCallBack = function (response) {
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
                                        complete: function () {
                                            // Release button
                                            submitButton.removeAttribute(
                                                'data-kt-indicator');

                                            // Re-enable button
                                            submitButton.disabled = false;
                                        },
                                        error: function (response, textStatus,
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
                            data: function (params) {
                                var query = {
                                    term: params.term,
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            }
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    });
                    $(document).on('change', '#category', function (e) {
                        $('[ name="purpose"]').select2({
                            dropdownParent: $(modalId),
                            allowClear: true,
                            ajax: {
                                url: '/getSelect?type=purpose&category=' + $(this).val(),
                                dataType: 'json',
                                data: function (params) {
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
                            url: '/getSelect?type=employeeDepartment&department=' + $('[ name="department"]').val(),
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    term: params.term,
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            }
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    });
                    $(document).on('change', '#department', function (e) {
                        $('[ name="employee"]').select2({
                            dropdownParent: $(modalId),
                            allowClear: true,
                            ajax: {
                                url: '/getSelect?type=employeeDepartment&department=' + $(this).val(),
                                dataType: 'json',
                                data: function (params) {
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
                complete: function () {
                    if (button) {
                        button.removeAttr('data-kt-indicator');

                    }
                    if (data_id) {
                        var telephone = $('[name="telephone"]').val();

                        datatableTickets.ajax.url("{{ route('tickets.indexByPhone') }}?telephone=" + telephone).load();
                        datatableVisits.ajax.url("{{ route('visits.indexByPhone') }}?telephone=" + telephone).load();
                        datatableCalls.ajax.url("{{ route('calls.indexByPhone') }}?telephone=" + telephone).load();

                    }
                }
            });


        }
    </script>
@endpush
