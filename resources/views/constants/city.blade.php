<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6">
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
                                rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-city-table-filter="search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search Cities" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-city-table-toolbar="base">
                    <!--begin::Add city-->
                    <button type="button" class="btn btn-primary" id="AddcityModal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="indicator-label">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Add City
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Add City-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Modal - Add task-->
                <div class="modal fade" id="kt_modal_add_city" tabindex="-1" aria-hidden="true">
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
            <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_cities">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th></th>
                        <th class="min-w-125px">city</th>
                        <th class="min-w-125px">City en</th>
                        <th class="min-w-125px">Country</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->

            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
</div>
@push('scripts')
    <script>
        var cityTable = document.querySelector('#kt_table_cities');

        var city_datatable = $(cityTable).DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],
            ajax: {
                url: "{{ route('settings.country-city.cities') }}",
                type: "POST",
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    visible: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'name_en',
                    name: 'name_en',
                },
                {
                    data: 'country.name',
                    name: 'country.name',
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-end',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [1, "ASC"]
            ]
        });

        const filterCitySearch = document.querySelector('[data-kt-city-table-filter="search"]');
        filterCitySearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            city_datatable.search(filterCitySearch.value).draw();
        }
    </script>

    <script>
        const element_city = document.getElementById('kt_modal_add_city');
        const modal_city = new bootstrap.Modal(element_city);

        function renderModal_City(url, button) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $('#kt_modal_add_city').find('.modal-dialog').html(response.createView);
                    // $('#AddEditModal').modal('show');
                    modal_city.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();

                    const form_city = element_city.querySelector('#kt_modal_add_city_form');
                    var validator_city = FormValidation.formValidation(
                        form_city, {
                            fields: {
                                'city_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'City Name is required'
                                        }
                                    }
                                },
                                'city_country_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Country is required'
                                        },
                                    }
                                },
                            },

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


                    const submitButton = element_city.querySelector('[data-kt-city-modal-action="submit"]');
                    submitButton.addEventListener('click', function(e) {
                        // Prevent default button action
                        e.preventDefault();

                        const formAdd = document.getElementById('kt_modal_add_city_form');
                        // Validate form before submit
                        if (validator_city) {
                            validator_city.validate().then(function(status) {
                                console.log('validated!');

                                if (status == 'Valid') {
                                    // Show loading indication
                                    submitButton.setAttribute('data-kt-indicator',
                                        'on');
                                    // Disable button to avoid multiple click
                                    submitButton.disabled = true;

                                    let data = $(formAdd).serialize();
                                    $.ajax({
                                        type: 'POST',
                                        url: $(formAdd).attr('action'),
                                        data: data,
                                        success: function(response) {
                                            toastr.success(response.message);
                                            form_city.reset();
                                            modal_city.hide();
                                            city_datatable.ajax.reload(null, false);
                                        },
                                        complete: function() {
                                            // KTUtil.btnRelease(btn);
                                            submitButton.removeAttribute(
                                                'data-kt-indicator');
                                            // Disable button to avoid multiple click
                                            submitButton.disabled = false;
                                        },
                                        error: function(response, textStatus,
                                            errorThrown) {
                                            toastr.error(response.responseJSON
                                                .message);
                                        },
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


                    $('#city_country_id').select2({
                        dropdownParent: $('#kt_modal_add_city')
                    });


                },
                complete: function() {
                    if (button)
                        button.removeAttr('data-kt-indicator');
                }

            });
        }

        $(document).on('click', '.btnUpdateCity', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');
            renderModal_City(editURl, $(this));
        });

        $(document).on('click', '#AddcityModal', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            renderModal_City("{{ route('settings.country-city.city.create') }}", $(this));
        });

        $(document).on('click', '.btnDeleteCity', function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const cityName = $(this).attr('data-city-name');
            Swal.fire({
                text: "Are you sure you want to delete " + cityName + "?",
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
                            city_datatable.ajax.reload(null, false);
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
