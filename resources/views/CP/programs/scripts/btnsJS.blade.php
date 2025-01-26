{{-- btn_send_brochure_ --}}
<script>
    $(document).on('click', '.btn_send_brochure_' + "{{ $_model::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const apartment_id = $(this).attr('apartment-id');
        const model_class = $(this).attr('model_class');
        const model_id = $(this).attr('model_id');
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
                    data: {
                        apartment_id: apartment_id,
                        model_class: model_class,
                        model_id: model_id,
                    },
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

{{-- positionDropdown --}}
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

{{-- btn_delete_ --}}
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
{{-- btn_request_priceOffer_ --}}
<script>
    $(document).on('click', '.btn_request_priceOffer_' + "{{ $_model::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ $_model::ui['s_ucf'] }}" + '-name');
        const button = $(this);

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to generate a price offer for " + itemModelName + "?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, generate it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
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
                        toastr.success('Price offer has been generated successfully');

                        if (typeof datatable !== 'undefined') {
                            datatable.ajax.reload();
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        handleAjaxErrors(xhr, status, error, {
                            submitButton: button
                        });
                    }
                });
            }
        });
    });
</script>

{{-- btnChangeStatus --}}
<script>
    // Status change click handler
    $(document).on('click', '.btnChangeStatus' + "{{ $_model::ui['s_ucf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');

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
{{-- get_email_menu_list --}}
<script>
    // Status change click handler
    $(document).on('click', '.get_email_menu_list', function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');

        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#kt_modal_email_form',
            dataTableId: datatable,
            submitButtonName: '[data-kt-emails-modal-action="submit"]',
        });


    });
</script>
{{-- show_general_modal_calls --}}
<script>
    $(document).on('click', '.show_general_modal_calls', function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');

        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            // callBackFunction: function() {
            //     // Any additional initialization after modal is shown
            //     KTScroll.createInstances();
            //     KTImageInput.createInstances();
            // }
        });
    });
</script>
