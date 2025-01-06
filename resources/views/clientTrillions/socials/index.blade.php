<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
        <!--begin::Card-->
        <div class="card table-responsive">
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
                        <input type="text" data-kt-socials-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="Search Socials"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-socials-table-toolbar="base">
                        <!--begin::Filter-->
                        <!--begin::clientTrillions 1-->
                        <!--end::clientTrillions 1-->
                        <!--end::Filter-->
                        <!--begin::Add clientTrillions-->
                        <a href="#" class="btn btn-primary" id="AddSocialModal">
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
                        <!--end::Add clientTrillions-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Modal - Add task-->

                    <!--end::Modal - Add task-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4 ">
                <!--begin::Table-->
                <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5 "
                       id="kt_table_socials">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="all ">{{__('SN')}}</th>

                        <th class="all min-w-125px">{{__('Platform')}}</th>
                        <th class="all min-w-125px">{{__('URL')}}</th>

                        <th class="all min-w-125px">{{__('User Name')}}</th>
                        <th class="all min-w-300px">{{__('Password')}}</th>

                        <th class="all min-w-125px">{{__('Last Update Date')}}</th>
                        <th class="all min-w-125px">   {{ __('Likes') }}/ {{ __('Followers') }}/ {{ __('Traffic') }}</th>
                        <th class="all text-end mw-100px">{{__('Actions')}}</th>
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
            var datatableSocial;
            var initSocials = (function () {


                return function () {


                    executed = true;
                    const columnDefs = [{
                        data: 'id',
                        name: 'id',
                    },
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.platform)
                                        return row.platform.name;
                                }
                                return '';
                            },
                            name: 'platform.name',
                        },
                        {
                            data: 'address',
                            name: 'address',
                        },

                        {
                            data: 'social_user_name',
                            name: 'social_user_name',
                        },


                        {

                            data: 'social_password',
                            name: 'social_password',
                        },


                        {
                            data: 'last_update_date',
                            name: 'last_update_date',
                        },
                        {
                            data: 'likes',
                            name: 'likes',
                        },


                        {
                            data: 'action',
                            name: 'action',
                            className: 'text-end',
                            orderable: false,
                            searchable: false
                        }
                    ];
                    datatableSocial = createDataTable('#kt_table_socials', columnDefs,
                        "{{ route('clientTrillions.socials.index', ['clientTrillion' => isset($clientTrillion)?$clientTrillion->id:0]) }}",
                        [
                            [0, "ASC"]
                        ]);

                    datatableSocial.on('draw.dt', function () {

                        $(document).on('click', '.toggle-password', function () {
                            console.log('hh');
                            let input = $(this).parents('tr').find('.password-input');
                            if (input.attr("type") === "password") {

                                $(this).parents('tr').find('.ki-eye').removeClass('d-none');
                                $(this).parents('tr').find('.ki-eye-slash').addClass('d-none');
                                input.attr("type", "text");
                            } else {

                                $(this).parents('tr').find('.ki-eye').addClass('d-none');
                                $(this).parents('tr').find('.ki-eye-slash').removeClass('d-none');
                                input.attr("type", "password");
                            }

                        });

                    });

                };
            })();
        </script>
        <script>
            const filterSearchSocial = document.querySelector('[data-kt-socials-table-filter="search"]');
            filterSearchSocial.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                datatableSocial.columns(1).search(filterSearchSocial.value).draw();
            }


        </script>

        <script>
            $(function () {


                const validatorSocialFields = {};
                const RequiredInputListSocial = {
                    'name': 'input',


                }

                const kt_modal_add_social = document.getElementById('kt_modal_add_social');
                const modal_kt_modal_add_social = new bootstrap.Modal(kt_modal_add_social);

                $(document).on('click', '#AddSocialModal', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    globalRenderModal(
                        "{{ route('clientTrillions.socials.add', ['clientTrillion' => isset($clientTrillion) ? $clientTrillion->id : '' ]) }}",
                        $(this), '#kt_modal_add_social',
                        modal_kt_modal_add_social,
                        validatorSocialFields,
                        '#kt_modal_add_social_form',
                        datatableSocial,
                        '[data-kt-socials-modal-action="submit"]', RequiredInputListSocial);
                });


                $(document).on('click', '.btnUpdateSocial', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    const editURl = $(this).attr('href');

                    globalRenderModal(editURl,
                        $(this), '#kt_modal_add_social',
                        modal_kt_modal_add_social,
                        validatorSocialFields,
                        '#kt_modal_add_social_form',
                        datatableSocial,
                        '[data-kt-socials-modal-action="submit"]', RequiredInputListSocial);
                });


                $(document).on('click', '.btnDeleteSocial', function (e) {
                    e.preventDefault();
                    const URL = $(this).attr('href');
                    const socialName = $(this).attr('data-social-name');
                    Swal.fire({
                        text: "Are you sure you want to delete " + socialName + "?",
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
                                    datatableSocial.ajax.reload(null, false);
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
                initSocials();
            });
        </script>
    @endisset

@endpush
