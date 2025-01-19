<script>
    $(document).on('click', '.btn_delete_' + "{{ $_model::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ $_model::ui['s_ucf'] }}" + '-name');
        Swal.fire({
            html: "Are you sure you want to delete " + itemModelName + "?",
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
</script>


<script>
    $(document).on('click', '.btnSendEmail' + "{{ $_model::ui['s_ucf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ $_model::ui['s_ucf'] }}" + '-name');
        const button = $(this);

        Swal.fire({
            html: "Are you sure you want to send price offer email to " + itemModelName + "?",
            icon: "question",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, send!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-success",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function(result) {
            if (result.value) {
                // Disable button and show loading
                button.attr('data-kt-indicator', 'on');
                button.prop('disabled', true);

                $.ajax({
                    url: URL,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            if (typeof datatable !== 'undefined') {
                                datatable.ajax.reload(null, false);
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        handleAjaxErrors(xhr, status, error, {
                            submitButton: button
                        });
                    },
                    complete: function() {
                        // Re-enable button and hide loading
                        button.removeAttr('data-kt-indicator');
                        button.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).on('click', '.btnSendBrochure' + "{{ $_model::ui['s_ucf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ $_model::ui['s_ucf'] }}" + '-name');
        const button = $(this);

        Swal.fire({
            html: "Are you sure you want to send  " + itemModelName + "?",
            icon: "question",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, send!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-success",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function(result) {
            if (result.value) {
                // Disable button and show loading
                button.attr('data-kt-indicator', 'on');
                button.prop('disabled', true);

                $.ajax({
                    url: URL,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            if (typeof datatable !== 'undefined') {
                                datatable.ajax.reload(null, false);
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        handleAjaxErrors(xhr, status, error, {
                            submitButton: button
                        });
                    },
                    complete: function() {
                        // Re-enable button and hide loading
                        button.removeAttr('data-kt-indicator');
                        button.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>


<script>
    // Status change click handler
    $(document).on('click', '.btnChangeStatus' + "{{ $_model::ui['s_ucf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');

        // Use ModalRenderer to show the status change modal
        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general_sm',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general_sm')),
            formId: '#kt_modal_change_status_form',
            dataTableId: datatable,
            submitButtonName: '[data-kt-change-status-modal-action="submit"]',
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        function positionDropdown(trigger, dropdown) {
            const rect = trigger.getBoundingClientRect();

            // Position relative to viewport
            dropdown.style.top = `${rect.bottom + window.scrollY}px`;
            dropdown.style.left = `${rect.left - 200 + rect.width}px`; // 200 is width of dropdown
        }

        function toggleDropdown(triggerBtn, containerClass) {
            const wrapper = triggerBtn.closest('.action-button-wrapper');
            const dropdown = wrapper.querySelector(containerClass);

            // Hide all other dropdowns
            document.querySelectorAll('.menu-container, .email-container').forEach(container => {
                if (container !== dropdown) {
                    container.style.display = 'none';
                }
            });

            // Toggle current dropdown
            const isVisible = dropdown.style.display !== 'none';
            dropdown.style.display = isVisible ? 'none' : 'block';

            if (!isVisible) {
                positionDropdown(triggerBtn, dropdown);
            }
        }

        document.addEventListener('click', function(e) {
            const menuTrigger = e.target.closest('.menu-trigger-btn');
            const emailTrigger = e.target.closest('.email-trigger-btn');

            if (menuTrigger) {
                toggleDropdown(menuTrigger, '.menu-container');
                e.stopPropagation();
            } else if (emailTrigger) {
                toggleDropdown(emailTrigger, '.email-container');
                e.stopPropagation();
            } else if (
                !e.target.closest('.menu-container') &&
                !e.target.closest('.email-container')
            ) {
                document.querySelectorAll('.menu-container, .email-container').forEach(container => {
                    container.style.display = 'none';
                });
            }
        });

        // Reposition dropdowns on scroll
        document.addEventListener('scroll', function() {
            const visibleDropdown = document.querySelector(
                '.menu-container[style*="block"], .email-container[style*="block"]');
            if (visibleDropdown) {
                const wrapper = visibleDropdown.closest('.action-button-wrapper');
                const trigger = wrapper.querySelector('.menu-trigger-btn, .email-trigger-btn');
                positionDropdown(trigger, visibleDropdown);
            }
        }, {
            passive: true
        });
    });
</script>
