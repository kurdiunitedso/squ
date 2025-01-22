@extends('metronic.index')

@section('title', t('User Management - Permissions'))
@section('subpageTitle', t('User Management'))
@section('subpageName', t('Permissions'))

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
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-col-index="name_code" data-kt-user-table-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">

                        @include('user-management.users._filter')

                        <a target="_blank" id="exportBtn" href="#"
                            data-export-url="{{ route('user-management.users.export') }}" class="btn btn-primary me-3">
                            <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                    class="path2"></span></i> {{ t('Export') }}
                        </a>
                        <!--begin::Add user-->
                        <button type="button" class="btn btn-primary" id="AddUserModal">
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
                                <!--end::Svg Icon-->{{ t('Add User') }}
                            </span>
                            <span class="indicator-progress">
                                {{ t('Please wait...') }} <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Add user-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th></th>
                                <th class="min-w-125px">{{ t('User') }}</th>
                                <th class="min-w-125px">{{ t('Mobile') }}</th>

                                <th class="min-w-125px mw-350px">{{ t('Role and Permissions') }}</th>
                                <th class="min-w-125px">{{ t('Status') }}</th>
                                <th class="min-w-125px">{{ t('Last login') }}</th>
                                <th class="min-w-125px">{{ t('Creation Date') }}</th>
                                <th class="text-end min-w-100px">{{ t('Actions') }}</th>
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
@endsection


@push('scripts')
    <script>
        const element = document.getElementById('kt_modal_add_user');
        const modal = new bootstrap.Modal(element);


        function renderModal(url, button) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $('#kt_modal_add_user').find('.modal-dialog').html(response.createView);
                    // $('#AddEditModal').modal('show');
                    modal.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();

                    const form = element.querySelector('#kt_modal_add_user_form');

                    var validator = FormValidation.formValidation(
                        form, {
                            fields: {
                                'user_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'User name is required'
                                        }
                                    }
                                },
                                'user_password': {
                                    validators: {
                                        notEmpty: {
                                            message: 'User name is required'
                                        }
                                    }
                                },
                                'user_email': {
                                    validators: {
                                        regexp: {
                                            regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                            message: "The value is not a valid email address",
                                        },
                                        notEmpty: {
                                            message: 'Email is required'
                                        }
                                    }
                                },
                                // 'role_name': {
                                //     validators: {
                                //         notEmpty: {
                                //             message: 'You must select at least one Role !'
                                //         }
                                //     }
                                // },
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




                    if ($("#kt_modal_add_user_form").attr('data-editMode') == 'enabled') {
                        validator.removeField('user_password');
                    }

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
                    submitButton.addEventListener('click', function(e) {
                        // Prevent default button action
                        e.preventDefault();

                        var formAddEdit = $("#kt_modal_add_user_form");
                        // Validate form before submit
                        if (validator) {
                            validator.validate().then(function(status) {
                                console.log('validated!');

                                if (status == 'Valid') {
                                    // Show loading indication
                                    submitButton.setAttribute('data-kt-indicator',
                                        'on');
                                    // Disable button to avoid multiple click
                                    submitButton.disabled = true;
                                    var member_avatar = $(form).find(
                                        'input[type="file"]');


                                    var formData = new FormData();

                                    $.each(formAddEdit.serializeArray(), function(i,
                                        field) {
                                        formData.append(field.name, field.value);
                                    });

                                    formData.append('member_avatar', member_avatar[0].files[0]);

                                    console.log(formData);
                                    $.ajax({
                                        type: 'POST',
                                        url: formAddEdit.attr('action'),
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function(response) {
                                            toastr.success(response.message);
                                            form.reset();
                                            modal.hide();
                                            datatable.ajax.reload(null, false);
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

                    $('[data-control="select2"]').select2({
                        dropdownParent: $('#kt_modal_add_user')
                    });

                },
                complete: function() {
                    if (button)
                        button.removeAttr('data-kt-indicator');
                }

            });
        }


        $(document).on('click', '.btnUpdateUser', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');
            renderModal(editURl, $(this));
        });

        $(document).on('click', '#AddUserModal', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            renderModal("{{ route('user-management.users.create') }}", $(this));
        });
        $(document).on('click', '#resetRole', function(e) {
            e.preventDefault();
            $('input[name="role_name"]').prop('checked', false);
        });
    </script>

    <script>
        var table = document.querySelector('#kt_table_users');

        var datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],
            ajax: {
                url: "{{ route('user-management.users.index') }}",
                type: "POST",
                data: function(d) {
                    // var params = {};
                    // $('.datatable-input').each(function() {
                    //     var i = $(this).data('col-index');
                    //     if (params[i]) {
                    //         params[i] += '|' + $(this).val();
                    //     } else {
                    //         params[i] = $(this).val();
                    //     }
                    // });
                    // d.params = params;
                    d.params = filterParameters();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    visible: false,
                    searchable: false
                },
                {
                    className: 'd-flex align-items-center',
                    data: 'fullname',
                    name: 'users.name',
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                },

                {
                    data: 'permissions',
                    name: 'permissions.name',
                    searchable: true,
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            var template = '';
                            // console.log(row);

                            if (Array.isArray(row.roles) && row.roles.length > 0) {
                                console.log(row.roles);
                                row.roles.forEach(element => {
                                    template +=
                                        '<span class="badge badge-light-success fs-7 m-1"">' +
                                        element
                                        .name + '</span>';
                                });
                            }

                            if (Array.isArray(data) && data.length > 0) {
                                data.forEach(element => {
                                    template +=
                                        '<span class="badge badge-light-primary fs-7 m-1"">' +
                                        element
                                        .name + '</span>';
                                });
                            }

                            return template;
                        }
                        return data;
                    },
                },
                // {
                //     data: 'roles',
                //     name: 'roles.name',
                //     searchable: true,
                //     render: function(data, type) {
                //         if (type === 'display') {
                //             if (Array.isArray(data) && data.length > 0) {
                //                 return '<span class="badge badge-light-primary fs-7 m-1"">' + data[0]
                //                     .name + '</span>';
                //             }
                //             return data;
                //         }
                //         return data;
                //     },
                // },
                {
                    data: 'active',
                    name: 'active',
                    render: function(data, type) {
                        if (type === 'display') {
                            if (Boolean(data) == true)
                                return '<span class="badge badge-light-primary fs-7 m-1"">Active</span>';
                            else
                                return '<span class="badge badge-light-danger fs-7 m-1"">Disabled</span>';
                        }
                        return data;
                    }
                },
                {
                    data: 'last_login_at',
                    name: 'last_login_at',
                    render: function(data, type) {
                        if (type === 'display') {
                            return '<div class="badge badge-light fw-bold">' + data + '</div>'
                        }
                        return data;
                    }
                },
                {
                    data: {
                        _: 'created_at.display',
                        sort: 'created_at.timestamp',
                    },
                    name: 'created_at',
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
                [7, "DESC"]
            ]
        });


        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.column(1).search(filterSearch.value).draw();
        }


        // Filter Datatable
        var handleFilterDatatable = () => {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
            const filterButton = filterForm.querySelector('[data-kt-user-table-filter="filter"]');
            const selectOptions = filterForm.querySelectorAll('select');

            // Filter datatable on submit
            filterButton.addEventListener('click', function() {
                var filterString = '';

                // Get filter values
                selectOptions.forEach((item, index) => {
                    if (item.value && item.value !== '') {
                        if (index !== 0) {
                            filterString += ' ';
                        }

                        // Build filter value options
                        filterString += item.value;
                    }
                });

                // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                datatable.column(2).search(filterString).draw();
                // datatable.search(filterString).draw();
            });
        }

        // Reset Filter
        var handleResetForm = () => {
            // Select reset button
            const resetButton = document.querySelector('[data-kt-user-table-filter="reset"]');

            // Reset datatable
            resetButton.addEventListener('click', function() {
                // Select filter options
                const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
                const selectOptions = filterForm.querySelectorAll('select');

                // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
                selectOptions.forEach(select => {
                    $(select).val('').trigger('change');
                });

                // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                datatable.column(2).search('').draw();
            });
        }

        // handleFilterDatatable();
        // handleResetForm();
    </script>
    <script>
        $(document).on('click', '.btnDeleteUser', function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const userName = $(this).attr('data-user-name');
            Swal.fire({
                text: "Are you sure you want to delete " + userName + "?",
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
                                text: "User successfully Deleted!",
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
    <script>
        $(document).on('click', '#filterBtn', function(e) {
            e.preventDefault();
            datatable.ajax.reload();
        });

        $(document).on('click', '#resetFilterBtn', function(e) {
            e.preventDefault();
            $('#filter-form').trigger('reset');
            // $('.datatable-input').each(function() {
            //     if ($(this).hasClass('selectpicker')) {
            //         $(this).selectpicker('val', "-1");
            //     }
            // });
            datatable.ajax.reload();
        });

        $(document).on('click', '#exportBtn', function(e) {
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
@endpush
