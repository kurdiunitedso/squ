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
                               data-kt-claim-table-filter="search"
                               class="form-control datatable-input form-control-solid w-250px ps-14"
                               placeholder="Search Claim"/>
                        <input type="hidden" name="selectedClaim">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-claim-table-toolbar="base">

                        <a href="{{route('claims.create', ['clientTrillion'=>isset($clientTrillion)?$clientTrillion:'0'])}}" target="_blank" class="btn btn-primary" id="">
                                        <span class="indicator-label">
                                            <span class="svg-icon svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                                          height="2" rx="1"
                                                          transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                    <rect x="4.36396" y="11.364" width="16" height="2"
                                                          rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                        {{__('Add')}}
                                        </span>
                            <span class="indicator-progress">
                                            Please wait... <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                        </a>
                        <!--end::Add claim-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Modal - Add task-->
                    <div class="modal fade" id="kt_modal_add_claim" tabindex="-1" aria-hidden="true">
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
                <div class="d-flex flex-wrap">
                    <!--begin::Stat-->
                    <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3 statsBlock blockui d-flex flex-row align-items-center" style="">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-arrows-loop fs-3 text-warning me-2"><span class="path1"></span><span class="path2"></span></i>
                            <div class="fs-4 fw-bold text-gray-700" data-kt-countup="true" data-kt-countup-value="4500" id="total_amount" data-kt-countup-prefix="$" data-kt-initialized="1">-</div>
                        </div>
                        <!--end::Number-->

                        <!--begin::Label-->
                        <a id="filterTotal" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" class="btn btn-sm btn-active-light-primary fw-semibold ms-3" data-bs-original-title="all  claims" data-kt-initialized="1">All
                            Claim</a>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->
                    <!--begin::Stat-->
                    <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3 statsBlock blockui d-flex flex-row align-items-center" style="">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-arrows-loop fs-3 text-warning me-2"><span class="path1"></span><span class="path2"></span></i>
                            <div class="fs-4 fw-bold text-gray-700" data-kt-countup="true" data-kt-countup-value="4500" id="paid_amount" data-kt-countup-prefix="$" data-kt-initialized="1">-</div>
                        </div>
                        <!--end::Number-->

                        <!--begin::Label-->
                        <a id="filterPaid" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" class="btn btn-sm btn-active-light-warning fw-semibold ms-3" data-bs-original-title="filtering data based on <b class='text-warning'>'paid'</b> claims" data-kt-initialized="1">Paid
                            Claims</a>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->
                    <!--begin::Stat-->
                    <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3 statsBlock blockui d-flex flex-row align-items-center" style="">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span class="path1"></span><span class="path2"></span></i>
                            <div class="fs-4 fw-bold text-gray-700" data-kt-countup="true" data-kt-countup-value="60" id="not_paid_amount" data-kt-countup-prefix="%" data-kt-initialized="1">-</div>
                        </div>
                        <!--end::Number-->

                        <!--begin::Label-->
                        <a id="filterNotPaid" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" class="btn btn-sm btn-active-light-success fw-semibold ms-3" data-bs-original-title="filtering data based on <b class='text-success'>'Not paid'</b> claims" data-kt-initialized="1">Processing Claims</a>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->

                </div>
                <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                       id="kt_table_claims">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="all"></th>
                        <th class="min-w-100px bold all">{{__('SN')}}</th>
                        <th class="min-w-100px bold all">{{__('Client')}}</th>
                        <th class="min-w-250px bold all">{{__('Claim Title')}}</th>

                        <th class="min-w-100px bold all">{{__('Telephone')}}</th>
                        <th class="min-w-100px bold all">{{__('Items')}}</th>
                        <th class="min-w-100px bold ">{{__('Cost')}}</th>
                        <th class="min-w-100px bold ">{{__('Active')}}</th>
                        <th class="min-w-100px bold ">{{__('Status')}}</th>
                        <th class="min-w-100px bold all">{{__('Action')}}</th>

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

    @isset($clientTrillion)

        <script>
            var datatableClaim;
            var initClaims = (function () {


                return function () {


                    executed = true;
                    const columnDefs = [{
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
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.client)
                                        return row.client.name;
                                }
                                return '';
                            },
                            name: 'client.name',
                        },

                        {
                            data: 'title',
                            name: 'title',
                        },




                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.client)
                                        return row.client.telephone;
                                }
                                return '';
                            },
                            name: 'client.telephone',
                        },

                        {
                            data: 'items_count',
                            name: 'items_count',
                        },

                        {
                            data: 'cost',
                            name: 'cost',
                        },

                        {
                            data: 'active',
                            name: 'active',
                        },
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.status)
                                        return row.status.name;
                                }
                                return '';
                            },
                            name: 'client.telephone',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            className: 'text-end',
                            orderable: false,
                            searchable: false
                        }
                    ];
                    datatableClaim = createDataTable('#kt_table_claims', columnDefs,
                        "{{ route('clientTrillions.claims.index', ['clientTrillion' => isset($clientTrillion)?$clientTrillion->id:0]) }}",
                        [
                            [0, "ASC"]
                        ]);
                    datatableClaim.on('xhr', function(e, settings, json) {
                        $('#total_amount').text(json['total_amount']);
                        $('#paid_amount').text(json['paid_amount']);
                        $('#not_paid_amount').text(json['not_paid_amount']);

                    });


                };
            })();
        </script>
        <script>
            const filterSearchClaim = document.querySelector('[data-kt-claim-table-filter="search"]');
            filterSearchClaim.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                datatableClaim.columns(1).search(filterSearchClaim.value).draw();
            }
        </script>

        <script>
            $(function () {


                const validatorClaimFields = {};
                const RequiredInputListClaim = {
                    'client_trillion_id': 'input',
                }

                const kt_modal_add_claim = document.getElementById('kt_modal_add_claim');
                const modal_kt_modal_add_claim = new bootstrap.Modal(kt_modal_add_claim);

                $(document).on('click', '#AddClaimModal', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    globalRenderModal(
                        "{{ route('clientTrillions.claims.add', ['clientTrillion' => isset($clientTrillion) ? $clientTrillion->id : '' ]) }}",
                        $(this), '#kt_modal_add_claim',
                        modal_kt_modal_add_claim,
                        validatorClaimFields,
                        '#kt_modal_add_claim_form',
                        datatableClaim,
                        '[data-kt-claims-modal-action="submit"]', RequiredInputListClaim);
                });


                $(document).on('click', '.btnUpdateClaim', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    const editURl = $(this).attr('href');

                    globalRenderModal(editURl,
                        $(this), '#kt_modal_add_claim',
                        modal_kt_modal_add_claim,
                        validatorClaimFields,
                        '#kt_modal_add_claim_form',
                        datatableClaim,
                        '[data-kt-claims-modal-action="submit"]', RequiredInputListClaim);
                });


                $(document).on('click', '.btnDeleteClaim', function (e) {
                    e.preventDefault();
                    const URL = $(this).attr('href');
                    const claimName = $(this).attr('data-claim-name');
                    Swal.fire({
                        text: "Are you sure you want to delete " + claimName + "?",
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
                                    datatableClaim.ajax.reload(null, false);
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
                initClaims();
            });
        </script>
        <script>

            var claim_calls_card = document.querySelector(".claim_calls_card");
            var blockUI_claim_calls_card = new KTBlockUI(claim_calls_card, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
            });

            var claim_calls_questionnaire_logs_card = document.querySelector(".claim_calls_questionnaire_logs_card");
            var blockUI_claim_calls_questionnaire_logs_card = new KTBlockUI(claim_calls_questionnaire_logs_card, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
            });


            $(document).on('click', '.btnDeleteclaim', function (e) {
                e.preventDefault();
                const URL = $(this).attr('href');
                const claimName = $(this).attr('data-claim-name');
                Swal.fire({
                    html: "Are you sure you want to delete " + claimName + "?",
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
            const validatorEmailFields = {
                'to': {
                    validators: {
                        notEmpty: {
                            message: 'Fill To '
                        }
                    }
                },
                'text': {
                    validators: {
                        notEmpty: {
                            message: 'Fill Text '
                        }
                    }
                },
                'subject': {
                    validators: {
                        notEmpty: {
                            message: 'Fill subject '
                        }
                    }
                }

            };

            const RequiredInputListEmail = {
                'to': 'input',
                'subject': 'input',
                'text': 'input',

            }
            const kt_modal_sendEmails = document.getElementById('kt_modal_sendEmails');
            const modal_kt_modal_sendEmails = new bootstrap.Modal(kt_modal_sendEmails);

            $(document).on('click', '.sendEmail', function (e) {

                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                var href = $(this).attr("link");
                renderAModal(
                    href,
                    $(this), '#kt_modal_sendEmails',
                    modal_kt_modal_sendEmails,
                    validatorEmailFields,
                    '#kt_modal_add_email_form',
                    datatableClaim,
                    '[data-kt-emails-modal-action="submit"]', RequiredInputListEmail);

            });

        </script>
    @endisset

@endpush
