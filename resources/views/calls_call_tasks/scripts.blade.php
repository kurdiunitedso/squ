<script>

    const element = document.getElementById('kt_modal_calls');
    const modal = new bootstrap.Modal(element);



    function renderModal(url, button) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(response) {
                // console.log(response);
                $('#kt_modal_calls').find('.modal-dialog').html(response.createView);
                // $('#AddEditModal').modal('show');
                modal.show();
                KTScroll.createInstances();

                const form = element.querySelector('#kt_modal_add_call_form');

                var validator = FormValidation.formValidation(
                    form, {
                        fields: {
                            'next_call': {
                                validators: {
                                    notEmpty: {
                                        message: 'Next call date is required'
                                    }
                                }
                            },
                            'sick_fund_id': {
                                validators: {
                                    notEmpty: {
                                        message: 'Sick fund is required'
                                    }
                                }
                            },
                            'callTask_clinic_id': {
                                validators: {
                                    notEmpty: {
                                        message: 'CallTask Clinic is required'
                                    }
                                }
                            },
                            'validation_date': {
                                validators: {
                                    notEmpty: {
                                        message: 'Validation date is required'
                                    }
                                }
                            },
                            'call_action_id': {
                                validators: {
                                    notEmpty: {
                                        message: 'Call Action is required'
                                    }
                                }
                            },
                            'debit_action_id': {
                                validators: {
                                    notEmpty: {
                                        message: 'Debit Action is required'
                                    }
                                }
                            },
                            'user_id': {
                                validators: {
                                    notEmpty: {
                                        message: 'Employee is required'
                                    }
                                }
                            },
                            'notes': {
                                validators: {
                                    notEmpty: {
                                        message: 'Notes is required'
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
                const submitButton = element.querySelector('[data-kt-call-modal-action="submit"]');
                submitButton.addEventListener('click', function(e) {
                    // Prevent default button action
                    e.preventDefault();

                    const formAdd = document.getElementById('kt_modal_add_call_form');
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

                                let data = $(formAdd).serialize();

                                $.ajax({
                                    type: 'POST',
                                    url: $(formAdd).attr('action'),
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

                $('[data-control="select2"]').select2({
                    dropdownParent: $('#kt_modal_calls'),
                    allowClear: true,
                });

                var target_blockUIQuestions = document.querySelector("#kt_block_ui_4_target");
                var blockUIQuestions = new KTBlockUI(target_blockUIQuestions, {
                    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
                });

                $('#call_questionnaire_id').on('select2:clear', function(e) {
                    $(".questions_list").each(function(i, e) {
                        validator.removeField($(this).attr('name'));
                    });
                    $('#questionnaire-questions-container').html('');
                });

                $('#call_questionnaire_id').on('change', function(e) {

                    $(".questions_list").each(function(i, e) {
                        validator.removeField($(this).attr('name'));
                    });

                    var url = $(this).val();
                    console.log($(this).val());
                    e.preventDefault();
                    blockUIQuestions.block();
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            $('#questionnaire-questions-container').html(response
                                .questionsList);

                            // Validate Questions


                            const ResponseValidators = {
                                validators: {
                                    notEmpty: {
                                        message: 'Response is required',
                                    },
                                },
                            };


                            $(".questions_list").each(function(i, e) {
                                validator.addField($(this).attr('name'),
                                    ResponseValidators)
                            });
                        },
                        complete: function() {
                            blockUIQuestions.release();
                        }
                    });
                });


                var dueDate = $(form.querySelector('[name="next_call"]'));
                dueDate.flatpickr({
                    enableTime: false,
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    allowInput: true,
                });

                var validaionDate = $(form.querySelector('[name="validation_date"]'));
                validaionDate.flatpickr({
                    enableTime: false,
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    allowInput: true,
                });


            },
            complete: function() {
                if (button)
                    button.removeAttr('data-kt-indicator');
            }

        });
    }



    $(document).on('click', '.btnAddCallTaskCall', function(e) {

        e.preventDefault();
        $(this).attr("data-kt-indicator", "on");
        const url = $(this).attr('href');
        renderModal(url, $(this));
    });

    $(document).on('click', '.btnDeleteCall', function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const callName = $(this).attr('data-call-name');
        const url = $(this).attr('data-refresh-url');
        Swal.fire({
            text: "Are you sure you want to delete " + callName + "?",
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
                        refreshCallTaskCalls(url);
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
