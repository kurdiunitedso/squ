<script>
    const element_kt_modal_shortMessages = document.getElementById('kt_modal_shortMessages');
    const modal_element_kt_modal_shortMessages = new bootstrap.Modal(element_kt_modal_shortMessages);

    function renderModal_sms(url, button) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(response) {
                // console.log(response);
                $('#kt_modal_shortMessages').find('.modal-dialog').html(response.createView);
                // $('#AddEditModal').modal('show');
                modal_element_kt_modal_shortMessages.show();
                KTScroll.createInstances();
                KTImageInput.createInstances();

                const form_Sms = element_kt_modal_shortMessages.querySelector('#kt_modal_add_sms_form');

                var validator_shortsms = FormValidation.formValidation(
                    form_Sms, {
                        fields: {
                            'type_id': {
                                validators: {
                                    notEmpty: {
                                        message: 'Message Type is required'
                                    }
                                }
                            },
                            'to': {
                                validators: {
                                    notEmpty: {
                                        message: 'Captin Numberis required'
                                    }
                                }
                            },
                            'text': {
                                validators: {
                                    notEmpty: {
                                        message: 'Message Text is required'
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
                const submitButton_sms = element_kt_modal_shortMessages.querySelector('[data-kt-sms-modal-action="submit"]');
                submitButton_sms.addEventListener('click', function(e) {
                    // Prevent default button action
                    e.preventDefault();

                    const formAdd = document.getElementById('kt_modal_add_sms_form');
                    // Validate form before submit
                    if (validator_shortsms) {
                        validator_shortsms.validate().then(function(status) {
                            console.log('validated!');

                            if (status == 'Valid') {
                                // Show loading indication
                                submitButton_sms.setAttribute('data-kt-indicator',
                                    'on');
                                // Disable button to avoid multiple click
                                submitButton_sms.disabled = true;

                                let data = $(formAdd).serialize();

                                $.ajax({
                                    type: 'POST',
                                    url: $(formAdd).attr('action'),
                                    data: data,
                                    success: function(response) {
                                        toastr.success(response.message);
                                        form_Sms.reset();
                                        modal_element_kt_modal_shortMessages
                                            .hide();
                                        datatable.ajax.reload(null, false);
                                    },
                                    complete: function() {
                                        // KTUtil.btnRelease(btn);
                                        submitButton_sms.removeAttribute(
                                            'data-kt-indicator');
                                        // Disable button to avoid multiple click
                                        submitButton_sms.disabled = false;
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
                    dropdownParent: $('#kt_modal_shortMessages')
                });

                var dueDate = $(form_Sms.querySelector('[name="next_call"]'));
                dueDate.flatpickr({
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

    $(document).on('click', '.btnAddCaptinSms', function(e) {
        e.preventDefault();
        $(this).attr("data-kt-indicator", "on");
        const url = $(this).attr('href');
        renderModal_sms(url, $(this));
    });
</script>
