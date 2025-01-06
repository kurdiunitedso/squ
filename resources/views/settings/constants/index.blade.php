@extends('metronic.index')

@section('title', 'Settings - Constants')
@section('subpageTitle', 'Settings')
@section('subpageName', 'Constants')

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
                            <input type="text" data-kt-constant-table-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search constant" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-constant-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::constant 1-->
                            <!--end::constant 1-->
                            <!--end::Filter-->
                            <!--begin::Add constant-->
                            {{-- <button type="button" class="btn btn-primary" id="AddconstantModal">
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
                                    Add constant
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button> --}}
                            <!--end::Add constant-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-constant-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-constant-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger"
                                data-kt-constant-table-select="delete_selected">Delete
                                Selected</button>
                        </div>
                        <!--end::Group actions-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_constant" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-xl modal-dialog-centered mw-650px">

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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_constants">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Field</th>
                                {{-- <th class="min-w-125px">Parent</th> --}}
                                <th class="min-w-125px">Module</th>
                                <th class="">Total records</th>
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
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content container-->
    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_constant" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
@endsection


@push('scripts')
    <script src="{{ asset('plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>

    <script>
        const element = document.getElementById('kt_modal_constant');
        const modal = new bootstrap.Modal(element);

        function renderModal(url, button) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $('#kt_modal_constant').find('.modal-dialog').html(response.editView);
                    // $('#AddEditModal').modal('show');
                    modal.show();
                    KTScroll.createInstances();

                    const form = element.querySelector('#kt_modal_constant_form');

                    $('[data-control="select2"]').select2({
                        dropdownParent: $('#kt_modal_constant'),
                        allowClear: true,
                    });
                    $('#kt_constant_repeater').repeater({
                        initEmpty: false,

                        show: function() {
                            $(this).slideDown();
                            // Re-init select2
                            $(this).find('.select2-container').addClass('d-none');
                            $(this).find('[data-control="select2"]').select2({
                                dropdownParent: $('#kt_modal_constant'),
                                allowClear: true
                            });
                            $(this).find('[data-control="select2"]').val(null).trigger('change');

                            validator.addField($(this).find('.constantNames').attr('name'),
                                NameValidators);
                            validator.addField($(this).find('.constantValues').attr('name'),
                                ValueValidators);

                        },

                        hide: function(deleteElement) {
                            $(this).slideUp(deleteElement);
                            let ConstantId = $(this).attr('data-constant-id');
                            $("#deleted_contants").append(
                                '<input type="hidden" name="deleted_constants[]" value="' +
                                ConstantId + '">');
                            //remove validation


                            validator.removeField($(this).find('.constantNames').attr('name'));
                            validator.removeField($(this).find('.constantValues').attr('name'));
                        },

                        ready: function() {
                            // Init select2



                        }
                    });


                    const NameValidators = {
                        validators: {
                            notEmpty: {
                                message: 'The Name is required',
                            },
                        },
                    };
                    const ValueValidators = {
                        validators: {
                            notEmpty: {
                                message: 'The Value is required',
                            },
                        },
                    };

                    var validator = FormValidation.formValidation(
                        form, {
                            fields: {},
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

                    $(".constantNames").each(function(i, e) {
                        validator.addField($(this).attr('name'), NameValidators)
                    });
                    $(".constantValues").each(function(i, e) {
                        validator.addField($(this).attr('name'), ValueValidators)
                    });
                    // if ($("#kt_modal_constant_form").attr('data-editMode') == 'enabled') {
                    //     validator.removeField('user_password');
                    // }

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-constants-modal-action="submit"]');
                    submitButton.addEventListener('click', function(e) {
                        // Prevent default button action
                        e.preventDefault();

                        var formAddEdit = $("#kt_modal_constant_form");
                        // Validate form before submit
                        if (validator) {
                            validator.validate().then(function(status) {
                                console.log('validated!');
                                console.log($('#kt_constant_repeater').repeaterVal());
                                if (status == 'Valid') {
                                    // Show loading indication
                                    submitButton.setAttribute('data-kt-indicator',
                                        'on');
                                    // Disable button to avoid multiple click
                                    submitButton.disabled = true;
                                    console.log(formAddEdit);
                                    let data = formAddEdit.serialize();

                                    $.ajax({
                                        type: 'POST',
                                        url: formAddEdit.attr('action'),
                                        data: data,
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


                },
                complete: function() {
                    if (button)
                        button.removeAttr('data-kt-indicator');
                }

            });
        }



        $(document).on('click', '.btnUpdateConstant', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');
            renderModal(editURl, $(this));
        });

        var table = document.querySelector('#kt_table_constants');
        var datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],
            ajax: {
                url: "{{ route('settings.constants.index') }}",
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
                }
            },
            columns: [{
                    data: 'field',
                    name: 'field',
                },
                // {
                //     data: function(row, type, set) {
                //         if (type === 'display') {
                //             if (row.parent)
                //                 return row.parent.name;
                //         }
                //         return row.parent_id;
                //     },
                //     name: 'parent_id',
                // },
                {
                    data: 'module',
                    name: 'module',
                },
                {
                    data: 'total_values',
                    name: 'total_values'
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
                [0, "ASC"]
            ]
        });
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-constant-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.columns(0).search(filterSearch.value).draw();
        }
    </script>
@endpush
