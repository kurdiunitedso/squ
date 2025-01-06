@extends('metronic.index')

@section('title', 'Settings - Questionnaires')
@section('subpageTitle', 'Settings')
@section('subpageName', 'Questionnaires')

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
                            <input type="text" data-kt-questionnaire-table-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search questionnaire" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-questionnaire-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::questionnaire 1-->
                            <!--end::questionnaire 1-->
                            <!--end::Filter-->
                            <!--begin::Add questionnaire-->
                            <button type="button" class="btn btn-primary" id="AddCallQuestionnaireModal">
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
                                    Add Call Questionnaire
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <!--end::Add questionnaire-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-questionnaire-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-questionnaire-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger"
                                data-kt-questionnaire-table-select="delete_selected">Delete
                                Selected</button>
                        </div>
                        <!--end::Group actions-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_questionnaire" tabindex="-1" aria-hidden="true">
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
                        id="kt_table_questionnaires">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Questionnaire</th>
                                <th class="min-w-125px">Type</th>
                                <th class="min-w-125px">Description</th>
                                <th class="min-w-125px"># of Questions</th>
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
    <div class="modal fade" id="kt_modal_questionnaire" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
@endsection


@push('scripts')
    <script src="{{ asset('plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        const element = document.getElementById('kt_modal_questionnaire');
        const modal = new bootstrap.Modal(element);

        function renderModal(url, button) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $('#kt_modal_questionnaire').find('.modal-dialog').html(response.createView);
                    // $('#AddEditModal').modal('show');
                    modal.show();
                    KTScroll.createInstances();

                    const form = element.querySelector('#kt_modal_add_questionnaire_form');

                    $('#kt_questionnaire_repeater').repeater({
                        initEmpty: false,

                        show: function() {
                            $(this).slideDown();
                            // Re-init select2
                            validator.addField($(this).find('.questionnaireNames').attr('name'),
                                NameValidators);

                        },

                        hide: function(deleteElement) {
                            $(this).slideUp(deleteElement);
                            let questionnaireId = $(this).attr('data-question-id');
                            $("#deleted_questions").append(
                                '<input type="hidden" name="deleted_questions[]" value="' +
                                questionnaireId + '">');
                            //remove validation
                            validator.removeField($(this).find('.questionnaireNames').attr('name'));

                        },

                        ready: function() {
                            // Init select2

                        }
                    });



                    const NameValidators = {
                        validators: {
                            notEmpty: {
                                message: 'Question Text is required',
                            },
                        },
                    };


                    var validator = FormValidation.formValidation(
                        form, {
                            fields: {
                                'questionnaire_title': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Title is required',
                                        },
                                    },
                                },
                                'questionnaire_type': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Type is required',
                                        },
                                    },
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



                    $('[data-control="select2"]').select2({
                        dropdownParent: $('#kt_modal_questionnaire')
                    });

                    $(".questionnaireNames").each(function(i, e) {
                        validator.addField($(this).attr('name'), NameValidators)
                    });
                    // $(".questionnaireValues").each(function(i, e) {
                    //     validator.addField($(this).attr('name'), ValueValidators)
                    // });
                    // if ($("#kt_modal_add_questionnaire_form").attr('data-editMode') == 'enabled') {
                    //     validator.removeField('user_password');
                    // }

                    // Submit button handler
                    const submitButton = element.querySelector(
                        '[data-kt-questionnaire-modal-action="submit"]');
                    submitButton.addEventListener('click', function(e) {
                        // Prevent default button action
                        e.preventDefault();

                        var formAddEdit = $("#kt_modal_add_questionnaire_form");
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



        $(document).on('click', '.btnUpdatequestionnaire', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');
            renderModal(editURl, $(this));
        });

        $(document).on('click', '#AddCallQuestionnaireModal', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            renderModal("{{ route('settings.questionnaires.create') }}", $(this));
        });


        $(document).on('click', '.btnDeleteQuestionannire', function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const questionnaireName = $(this).attr('data-questionnaire-name');
            Swal.fire({
                text: "Are you sure you want to delete " + questionnaireName + "?",
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



        var table = document.querySelector('#kt_table_questionnaires');
        var datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],
            ajax: {
                url: "{{ route('settings.questionnaires.index') }}",
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
                    data: 'title',
                    name: 'title',
                },
                {
                    data: 'type.name',
                    name: 'type.name',
                },
                {
                    data: 'description',
                    name: 'description',
                },
                {
                    data: 'questions_count',
                    name: 'questions_count',
                    searchable: false
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
        const filterSearch = document.querySelector('[data-kt-questionnaire-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.columns(0).search(filterSearch.value).draw();
        }
    </script>
@endpush
