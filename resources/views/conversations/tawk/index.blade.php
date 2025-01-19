@extends('metronic.index')

@section('title', 'Whatsapp History')
@section('subpageTitle', 'Whatsapp History')

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
                            <input type="text" data-kt-tawk-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-14" placeholder="Search"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_tawk" tabindex="-1" aria-hidden="true">
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
                           id="kt_table_tawk">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="all mw-40px">{{__('ID')}}</th>
                            <th class="all">{{__('Date')}}</th>
                            <th class="all">{{__('Name')}}</th>
                            <th class="all w-100px">{{__('Message')}}</th>
                            <th class="all">{{__('Email')}}</th>
                            <th class="all">{{__('Telephone')}}</th>
                            <th class=" w-100px">{{__('ChatID')}}</th>
                            <th class="all">{{__('Country')}}</th>
                            <th class="all">{{__('City')}}</th>


                            <th class="all w-100px">{{__('Lead ID')}}</th>
                            <th class="all">{{__('Status')}}</th>
                            <th class="all">{{__('Action')}}</th>
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
    <div class="modal fade" id="kt_modal_tawk" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_assignUser" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

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
@endsection


@push('scripts')
    <script>
        const columnDefs = [{
            data: 'id',
            name: 'id',
            searchable: false,
        },
            {
                data: 'time',
                name: 'time',
                searchable: false,
            },
            {
                data: 'visit_name',
                name: 'visit_name',
            },
            {
                data: 'message_msg',
                name: 'message_msg',
            },
            {
                data: 'visit_email',
                name: 'visit_email',
            },
            {
                data: 'telephone',
                name: 'telephone',
            },
            {
                data: 'chatId',
                name: 'chatId',
            },
            {
                data: 'visit_country',
                name: 'visit_country',
            },
            {
                data: 'visit_city',
                name: 'visit_city',
            },


            {
                data: 'lead_id',
                name: 'lead_id',
            },
            {
                data: 'status.name',
                name: 'status.name',
            },
            {
                data: 'action',
                name: 'action',
            },
        ];
        var datatable = createDataTable('#kt_table_tawk', columnDefs,
            "{{ route('conversations.tawk.index') }}", [
                [0, "DESC"]
            ]);
        datatable.on("draw.dt", function (e, dt, type, indexes) {
            $(".chatWhat").on('click', function () {
                window.open($(this).attr("href"),'popup','width=600,height=600,scrollbars=no,resizable=no');
                return false;
            });
        });
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-tawk-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.search(filterSearch.value).draw();
        }
    </script>

    <script>


        const validatorChangeStatusFields = {};
        const RequiredInputListTawkHistoryChnageStatus = {
            'tawkHistory_status': 'select',
        }
        const kt_modal_changeStatus = document.getElementById('kt_modal_changeStatus');
        const modal_kt_changeStatus = new bootstrap.Modal(kt_modal_changeStatus);

        $(document).on('click', '.btnChangeStatus', function(e) {
            e.preventDefault();
            const changeStatusUrl = $(this).attr('href');
            globalRenderModal(
                changeStatusUrl,
                $(this), '#kt_modal_changeStatus',
                modal_kt_changeStatus,
                validatorChangeStatusFields,
                '#kt_modal_changeStatus_form',
                datatable,
                '[data-kt-changeStatus-modal-action="submit"]', RequiredInputListTawkHistoryChnageStatus);
        });

        $(document).on('click', '.btnDeletetawkHistory', function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const TawkHistoryName = $(this).attr('data-tawkHistory-name');
            Swal.fire({
                html: "Are you sure you want to delete " + TawkHistoryName + "?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: URL,
                        dataType: "json",
                        success: function(response) {
                            datatable.ajax.reload(null, false);
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        complete: function() {},
                        error: function(response, textStatus,
                                        errorThrown) {
                            toastr.error(response
                                .responseJSON
                                .message);
                        },
                    });

                } else if (result.dismiss === 'cancel') {}

            });
        });
    </script>
@endpush
