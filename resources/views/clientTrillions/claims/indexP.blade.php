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
                                <input type="hidden" name="selectedCaptin">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-claim-table-toolbar="base">

                                <a href="#" class="btn btn-primary" id="AddClaimModal">
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

                            <!--end::Modal - Add task-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                               id="kt_table_claims">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="all"></th>
                                <th class="min-w-100px bold all">{{__('SN')}}</th>
                                <th class="min-w-250px bold all">{{__('Claim Title')}}</th>
                                <th class="min-w-100px bold all">{{__('Client')}}</th>
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




    </div>
</div>

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
                        data: 'title',
                        name: 'title',
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
                    '[data-kt-claims-modal-action="submit"]');
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
@endisset






