<div>
    <div class="card mb-5 mb-xl-10" id="kt_employee_attachments_details_view">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Employee Attachments</h3>
            </div>
            <div class="card-toolbar">
                @can('employee_edit')
                    <a href="#" class="btn btn-sm btn-success ms-5" id="AddAttachmentModal">
                            <span class="indicator-label">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                              rx="10" fill="currentColor"/>
                                        <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                              transform="rotate(-90 10.8891 17.8033)" fill="currentColor"/>
                                        <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                              fill="currentColor"/>
                                    </svg>
                                </span>
                                Add New Attachment</span>
                        <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                    </a>
                @endcan
            </div>
        </div>

        <!--begin::Card body-->
        <div class="card-body p-9">
            <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                   id="kt_table_employee_attachments">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>ID</th>
                    <th class="min-w-100px mw-100px">File Name</th>
                    <th class="min-w-100px mw-100px">Type</th>
                    <th class="min-w-100px mw-100px">Source</th>
                    <th class="min-w-100px mw-100px">Created at</th>
                    <th class="">Actions</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->

            </table>
        </div>

    </div>
</div>



@push('scripts')
    <script>
        var table = document.querySelector('#kt_table_employee_attachments');

        var  datatableAtt= $(table).DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],
            ajax: {
                url: "{{ route('myemployees.attachments', ['employee' => $employee->id]) }}",
                type: "POST",
                data: function (d) {
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
                data: 'id',
                name: 'id',
            },
                {
                    // className: 'd-flex align-items-center',
                    data: 'title',
                    name: 'title',
                },

                {
                    data: function (row, type, set) {
                        if (type === 'display') {
                            return row.attachment_type.name;
                        }
                        return row.attachment_type_id;
                    },
                    name: 'attachment_type_id',
                },
                {
                    data: 'source',
                    name: 'source',
                },
                {
                    data: {
                        _: 'created_at.display',
                        sort: 'created_at.timestamp',
                    },
                    name: 'created_at',
                    visible: true,
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
                [0, "DESC"]
            ]
        });
    </script>
    <script>
        const element = document.getElementById('kt_modal_add_attachment');
        const modal = new bootstrap.Modal(element);

        function renderModal(url, button) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('#kt_modal_add_attachment').find('.modal-dialog').html(response.createView);
                    // $('#AddEditModal').modal('show');
                    modal.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();

                    const form = element.querySelector('#kt_modal_add_attachment_form');

                    var validator = FormValidation.formValidation(
                        form, {
                            fields: {
                                'attachment_type_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Attachment type is required'
                                        }
                                    }
                                },
                                'attachment_file': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Attachment file is required'
                                        }
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

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-attachments-modal-action="submit"]');
                    submitButton.addEventListener('click', function (e) {
                        // Prevent default button action
                        e.preventDefault();

                        var formAddEdit = $("#kt_modal_add_attachment_form");
                        // Validate form before submit
                        if (validator) {
                            validator.validate().then(function (status) {
                                console.log('validated!');

                                if (status == 'Valid') {
                                    // Show loading indication
                                    submitButton.setAttribute('data-kt-indicator',
                                        'on');
                                    // Disable button to avoid multiple click
                                    submitButton.disabled = true;
                                    var attachment_file = $(form).find(
                                        'input[type="file"]');

                                    var formData = new FormData();

                                    $.each(formAddEdit.serializeArray(), function (i,
                                                                                   field) {
                                        formData.append(field.name, field.value);
                                    });

                                    formData.append('attachment_file', attachment_file[0].files[
                                        0]);

                                    console.log(formData);
                                    $.ajax({
                                        type: 'POST',
                                        url: formAddEdit.attr('action'),
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function (response) {
                                            toastr.success(response.message);
                                            form.reset();
                                            modal.hide();
                                              datatableAtt.ajax.reload(null, false);
                                        },
                                        complete: function () {
                                            // KTUtil.btnRelease(btn);
                                            submitButton.removeAttribute(
                                                'data-kt-indicator');
                                            // Disable button to avoid multiple click
                                            submitButton.disabled = false;
                                        },
                                        error: function (response, textStatus,
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


                    $('#attachment_type_id').select2({
                        dropdownParent: $('#kt_modal_add_attachment')
                    });

                },
                complete: function () {
                    if (button)
                        button.removeAttr('data-kt-indicator');
                    if (  datatableAtt)
                          datatableAtt.draw(false);
                }

            });
        }

        $(document).on('click', '.btnUpdateAttachment', function (e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            const editURl = $(this).attr('href');
            renderModal(editURl, $(this));
        });

        $(document).on('click', '#AddAttachmentModal', function (e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            renderModal("{{ route('myemployees.attachments.create', ['employee' => $employee->id]) }}", $(this));
        });


    </script>


    <script>
        $(document).on('click', '.btnDeleteEmployeeAttachment', function (e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const attachmentName = $(this).attr('data-attachment-name');
            Swal.fire({
                text: "Are you sure you want to delete " + attachmentName + "?",
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
                              datatableAtt.ajax.reload(null, false);
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
    </script>
@endpush
